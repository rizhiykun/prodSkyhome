<?php

namespace App\Orchid\Layouts;

use App\Models\Client;
use App\Models\Estimate;
use App\Models\RepairType;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EstimateListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'estimates';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'Номер')
                ->render(function (Estimate $estimate) {
                    return Link::make($estimate->id)
                        ->route('platform.estimate.edit', $estimate);
                })->sort(),
            TD::make('created_at', 'Создан')
                ->render(fn ($value) => date('d-m-Y', strtotime($value->created_at)))->sort(),
            TD::make('Клиент')
                ->render(function (Estimate $estimate) {
                    return Client::find($estimate->clientID)->name;
                }),
            TD::make('approval','Согласование')
                ->render(function (Estimate $estimate) {
                    if ($estimate->approval == 0) return 'Не согласована'; else return 'Согласована';
                }
            ),
            TD::make('objectAddress','Адрес'),
            TD::make('summaryPrice', 'Цена рублей'),
            TD::make('floorArea','Площадь пола'),
//            TD::make('objectType','Тип сметы')
//            ->render(function (Estimate $estimate) {
//                return RepairType::find($estimate->objectType)->name;
//            }),
            TD::make('updated_at', 'Изменен')->sort()->defaultHidden(),
        ];
    }
}
