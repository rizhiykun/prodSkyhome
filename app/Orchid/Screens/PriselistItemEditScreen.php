<?php

namespace App\Orchid\Screens;

use App\Models\Pricelistitem;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class PriseListItemEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PriselistItemEditScreen';
    public $permission = [
        'platform.price_list.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'PriselistItemEditScreen';
    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @param Pricelistitem $item
     * @return array
     */
    public function query(Pricelistitem $item): array
    {
        $this->exists = $item->exists;

        if($this->exists){
            $this->name = 'Редактировать элемент';
        }

        return [
            'item' => $item
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
            Button::make('Создать')
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
                Input::make('item.name')
                    ->title('Название')
                    ->placeholder('Название')
                    ->required()
                    ->help('Название'),

                Input::make('item.type')
                    ->title('Тип')
                    ->placeholder('Тип')
                    ->help('Тип'),

                Select::make('item.unit')
                    ->title('Еденица измерения')
                    ->options([
                        'м2' => 'м2',
                        'м2+м.п.' => 'м2+м.п.',
                        'м.п.' => 'м.п.',
                        'ед.' => 'ед.'
                    ])
                    ->help('Еденица измерения'),

                Input::make('item.base_price')
                    ->title('Базовая цена')
                    ->placeholder('Базовая цена')
                    ->type('number')
                    ->step(0.01)
                    ->help('Базовая цена'),

                Input::make('item.manager_price')
                    ->title('Цена прораба')
                    ->placeholder('Цена прораба')
                    ->type('number')
                    ->step(0.01)
                    ->help('Цена прораба'),

                Input::make('item.master_price')
                    ->title('Цена мастера')
                    ->placeholder('Цена мастера')
                    ->type('number')
                    ->step(0.01)
                    ->help('Цена мастера'),

                Switcher::make('item.visible')
                    ->sendTrueOrFalse()
                    ->title('Видимость')
                    ->placeholder('Видимость')
                    ->help('Видимость'),

            ])
        ];
    }

    /**
     * @param Pricelistitem $item
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createOrUpdate(Pricelistitem $item, Request $request)
    {
        $item->fill($request->get('item'))->save();

        Alert::info('You have successfully created an $item.');

        return redirect()->route('platform.price.list');
    }

    /**
     * @param Pricelistitem $item
     * @return RedirectResponse
     * @throws Exception
     */
    public function remove(Pricelistitem $item)
    {
        $item->delete();

        Alert::info('You have successfully deleted the $item.');

        return redirect()->route('platform.price.list');
    }
}
