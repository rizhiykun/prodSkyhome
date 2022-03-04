<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Models\Measurement;
use App\Models\RepairBlock;
use App\Models\RepairPriceList;
use App\Models\RepairType;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class RepairPriseEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование позиции';
    public $permission = [
        'platform.repair_price_list.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование позиции в прайс-листе по ремонту';


    /**
     * Query data.
     *
     * @param RepairPriceList $plItem
     * @return array
     */
    public function query(RepairPriceList $plItem): array
    {
        $this->exists = $plItem->exists;

        if($this->exists){
            $this->name = 'Редактирование позиции';
        }
        $data = $plItem->data;
        $options = $plItem->options;
        return [
            'plItem' => $plItem,
            'data' => $data,
            'options' => $options
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
            Button::make('Создать позицию')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
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
                    Relation::make('plItem.workGroup')
                        ->title('Группа')
                        ->required()
                        ->help('Группа работ')
                        ->fromModel(RepairType::class, 'name')
                        ->searchColumns( 'name'),
                    Relation::make('plItem.workBlock')
                        ->title('Блок')
                        ->required()
                        ->help('Блок работ')
                        ->fromModel(RepairBlock::class, 'name')
                        ->searchColumns( 'name'),
                    Relation::make('plItem.measurement')
                        ->fromModel(Measurement::class, 'name')
                        ->title('Еденица измерения')
                        ->required()
                        ->help('Укажите еденицу измерения которой меряется эта работа'),
                ]),
                Group::make([
                    Input::make('plItem.workName')
                        ->title('Название')
                        ->placeholder('Название')
                        ->required()
                        ->help('Название работы'),
                    CheckBox::make('plItem.plVisible')
                        ->value(1)
                        ->title('Добавить в смету')
                        ->placeholder('Выводить на печать')
                        ->help('Добавить в расчетник сметы'),
                ]),
                Group::make([
                    Relation::make('plItem.additionalWorks')
                        ->fromModel(RepairPriceList::class, 'workName')
                        ->multiple()
                        ->title('Дополнительные работы')
                        ->help('Укажите дополнительные работы которые должны идти вместе с этой'),
                ]),
                Group::make([
                    Input::make('plItem.basePrice')
                        ->type('text')
                        ->value(fn($value) => (float) $value)
                        ->mask([
                            'alias'          => 'currency',
                            'prefix'         => '',
                            'groupSeparator' => '',
                            'digitsOptional' => true,
                            'radixPoint'     => '.',])
                        ->help('Базовая цена')
                        ->title('Базовая цена')
                        ->required(),
                    Input::make('plItem.discount')
                        ->type('number')
                        ->value(0)
                        ->max(100)
                        ->title('Скидка')
                        ->help('Скидка'),
                ]),
                Group::make([
                    Input::make('plItem.masterPrice')
                        ->type('text')
                        ->value(fn($value) => (float) $value)
                        ->mask([
                            'alias'          => 'currency',
                            'prefix'         => '',
                            'groupSeparator' => '',
                            'digitsOptional' => true,
                            'radixPoint'     => '.',])
                        ->title('Цена мастера')
                        ->help('Цена мастера')
                        ->required(),
                    Input::make('plItem.foremanPrice')
                        ->type('text')
                        ->value(fn($value) => (float) $value)
                        ->mask([
                            'alias'          => 'currency',
                            'prefix'         => '',
                            'groupSeparator' => '',
                            'digitsOptional' => true,
                            'radixPoint'     => '.',])
                        ->title('Цена прораба')
                        ->help('Цена прораба')
                        ->required(),
                ]),
            ])->title('Основные и зависимые поля'),
        ];
    }

    public function createOrUpdate(RepairPriceList $plItem, Request $request)
    {
        $plItem->fill($request->get('plItem'))->save();

        Alert::info('Позиция успешно добавлена\обновлена');

        return redirect()->route('platform.repPrice.list');
    }


    public function remove(RepairPriceList $plItem)
    {
        $plItem->delete();

        Alert::info('Вы удалили позицию');

        return redirect()->route('platform.repPrice.list');
    }
}
