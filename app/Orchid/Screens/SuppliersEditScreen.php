<?php

namespace App\Orchid\Screens;

use App\Models\Suppliers;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class SuppliersEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование поставщика';
    public $permission = [
        'platform.suppliers.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Панель для редактирования поставщика';

    /**
     * Query data.
     *
     * @param Suppliers $supplier
     * @return array
     */
    public function query(Suppliers $supplier): array
    {
        $this->exists = $supplier->exists;

        if($this->exists){
            $this->name = 'Редактирование поставщика';
        }

        return [
            'supplier' => $supplier
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('supplier.name')
                        ->title('Полное Наименование')
                        ->placeholder('Наименование')
                        ->help('Введите наименование для поставщика')
                        ->required(),
                    Input::make('supplier.badge')
                        ->title('Краткое Название')
                        ->placeholder('Название')
                        ->required()
                        ->help('Введите краткое название для поставщика'),
                ]),
                Group::make([
                    Input::make('supplier.email')
                        ->title('email')
                        ->type('email')
                        ->placeholder('Email')
                        ->help('Выедите email'),
                    Input::make('supplier.phone')
                        ->title('Телефон')
                        ->required()
                        ->mask('+7(999)999-9999')
                        ->placeholder('Телефон')
                        ->help('Введите телефон 11 цифр с кодом'),
                ]),
                Group::make([
                    TextArea::make('supplier.address')
                        ->title('Фактический адрес')
                        ->required()
                        ->rows(2)
                        ->placeholder('Адрес(Фактический Адрес)'),
                    TextArea::make('supplier.addressj')
                        ->title('Юридический адрес')
                        ->required()
                        ->rows(2)
                        ->placeholder('Адрес(Юридический Адрес)')
                ]),
                Group::make([
                    Input::make('supplier.inn')
                        ->title('ИНН')
                        ->type('numbers')
                        ->mask("9999999999")
                        ->placeholder('ИНН')
                        ->help('Введите ИНН'),
                    Input::make('supplier.kpp')
                        ->title('КПП')
                        ->mask("999999999")
                        ->placeholder('КПП')
                        ->help('Введите КПП'),
                ]),
                Group::make([
                    Input::make('supplier.ogrn')
                        ->title('ОГРН')
                        ->type('numbers')
                        ->mask("9999999999999")
                        ->placeholder('ОГРН')
                        ->help('Введите ОГРН'),
                    Input::make('supplier.okved')
                        ->mask("999999")
                        ->title('ОКВЭД')
                        ->placeholder('ОКВЭД')
                        ->help('Введите ОКВЭД'),
                ]),
                Group::make([
                    Select::make('supplier.additional')
                        ->options([
                            '' => '',
                            0 => 'Юр.Лицо',
                            1 => 'Физ.Лицо',
                            2 => 'ИП'
                        ])
                        ->help('Выберите тип поставщика'),
                    ])
            ])->title('Основные и зависимые поля'),
        ];
    }

    public function createOrUpdate(Suppliers $supplier, Request $request)
    {
        $supplier->fill($request->get('supplier'))->save();

        Alert::info('Поставщик "'.$supplier['name'].'" успешно добавлен\обновлен');

        return redirect()->route('platform.suppliers.list');
    }


    public function remove(Suppliers $supplier)
    {
        $supplier->delete();

        Alert::info('Вы удалили поставщика'.$supplier['name']);

        return redirect()->route('platform.suppliers.list');
    }
}
