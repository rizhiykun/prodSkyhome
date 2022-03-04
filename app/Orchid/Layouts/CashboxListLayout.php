<?php

namespace App\Orchid\Layouts;

use App\Models\Cashbox;
use App\Models\Pricelistitem;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CashboxListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'cashbox';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Название')
                ->render(function (Cashbox $item) {
                    return Link::make($item->name)
                        ->route('platform.cashbox.edit', $item);
                })
                ->cantHide(),
        ];
    }
}
