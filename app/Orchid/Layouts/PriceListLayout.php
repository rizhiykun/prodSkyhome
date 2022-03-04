<?php

namespace App\Orchid\Layouts;

use App\Models\Pricelistitem;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PriceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'Items';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Pricelistitem $item) {
                    return Link::make($item->name)
                        ->route('platform.price.edit', $item);
                })
                ->cantHide(),
            TD::make('type', 'Тип')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('unit', 'Еденица измерения'),
            TD::make('base_price', 'Базовая цена'),
            TD::make('manager_price', 'Цена прораба'),
            TD::make('master_price', 'Цена мастера'),
            TD::make('visible', 'Видимость'),
            TD::make('created_at', 'Создан')->defaultHidden(),
            TD::make('updated_at', 'Изменен')->defaultHidden(),

        ];
    }
}
