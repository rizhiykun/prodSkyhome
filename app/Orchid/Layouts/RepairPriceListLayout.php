<?php

namespace App\Orchid\Layouts;

use App\Models\Measurement;
use App\Models\RepairBlock;
use App\Models\RepairPriceList;
use App\Models\RepairType;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RepairPriceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'plItem';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('workGroup', 'Группа')
                ->render(fn(RepairPriceList $item) => RepairType::find($item->workGroup)->name)
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('workBlock', 'Блок')
                ->render(fn(RepairPriceList $item) => RepairBlock::find($item->workBlock)->name)
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('workName', 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (RepairPriceList $item) {
                    return Link::make($item->workName)
                        ->route('platform.repPrice.edit', $item);
                })
                ->cantHide(),
            TD::make('plVisible', 'Печать'),
            TD::make('measurement', 'Еденица измерения')
                ->render(fn(RepairPriceList $item) => Measurement::find($item->measurement)->name),
            TD::make('basePrice', 'Базовая цена'),
            TD::make('discount', 'Скидка'),
            TD::make('discountPrice', 'Цена со скидкой')
                ->render(fn(RepairPriceList $item) => round($item->basePrice * (100 - $item->discount)/100, 2) ),
            TD::make('masterPrice', 'Цена мастера'),
            TD::make('foremanPrice', 'Цена прораба'),
            TD::make('created_at', 'Создан')->defaultHidden(),
            TD::make('updated_at', 'Изменен')->defaultHidden(),
        ];
    }

    /**
     * @return bool
     */
    protected function striped(): bool
    {
        return true;
    }
}
