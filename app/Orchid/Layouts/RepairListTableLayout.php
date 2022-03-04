<?php

namespace App\Orchid\Layouts;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Estimate;
use App\Models\Repair;
use App\Models\RepairType;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RepairListTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'repair';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('idDate', '№/Дата')
                ->width('50px')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Repair $item) {
                    return Link::make($item->id)
                        ->route('platform.repair.edit', $item);
                })
                ->cantHide(),
//            TD::make('status', 'Статус')
//                ->sort()
//                ->filter(TD::FILTER_TEXT),
            TD::make('objectType', 'Тип договора')

                ->sort()
                ->render(function (Repair $item) {
                    return Contract::find($item->objectType)->contrType;
                    //return RepairType::find($item->objectType)->name;
                })
                ->filter(TD::FILTER_TEXT),
            TD::make('person', 'ФИО клиента и адрес объекта')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Repair $item) {
                    return Client::find($item->person)->name.'<br>'.Client::find($item->person)->real_address;
                }),
            TD::make('objectSquare', 'Площадь'),
            TD::make('estimate', 'Смета')
                ->sort()
                ->render(function (Repair $item) {
                    $smeta = Estimate::find($item->estimate);
                    return Link::make($smeta->id)->route('platform.estimate.edit', $smeta);
                })
                ->filter(TD::FILTER_TEXT),
            TD::make('termContract', 'Срок'),
            TD::make('leftovers', 'Остаток средств на работы, на материалы,
             на комплектацию ')->defaultHidden(),
            TD::make('manager', 'Менеджер проекта'),
            TD::make('supplier', 'Снабженец'),
            TD::make('foreman', 'Прораб'),
        ];
    }
    protected function striped(): bool
    {
        return true;
    }
}
