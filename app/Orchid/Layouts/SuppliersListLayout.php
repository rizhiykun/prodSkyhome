<?php

namespace App\Orchid\Layouts;

use App\Models\Suppliers;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SuppliersListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'Suppliers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('badge', 'Наименование')
                ->width(80)
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Suppliers $supplier) {
                    return Link::make($supplier->badge)
                        ->route('platform.suppliers.edit', $supplier);
                })
                ->cantHide(),
            TD::make('email', 'email')->filter(TD::FILTER_TEXT)->sort(),
            TD::make('phone', 'Телефон')->filter(TD::FILTER_TEXT)->sort(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Suppliers $suppliers) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.suppliers.edit', $suppliers->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->parameters([
                                    'id' => $suppliers->id,
                                ]),
                        ]);
                }),
        ];
    }
}
