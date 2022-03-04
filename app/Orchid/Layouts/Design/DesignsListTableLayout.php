<?php

namespace App\Orchid\Layouts\Design;

use App\Models\Client;
use App\Models\Design;
use App\Models\Tariff;
use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DesignsListTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'designs';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {

        return [
            TD::make('id', 'Номер договора')
                ->render(function (Design $design) {
                    return Link::make($design->id)
                        ->route('platform.design.edit', $design);
                })->sort(),
            TD::make('Клиент')
                ->render(function (Design $design) {
                    return Client::find($design->person)->name;
                }),
            TD::make('objectAddress', 'Адрес обьекта')->sort(),
            TD::make('objectSquare', 'Площадь')->sort(),
//            TD::make('objectSquare', 'Площадь после замера'),
            TD::make('objectTariff', 'тариф/цена квадрата')->sort()
               ->render(fn(Design $design) => Tariff::find
                ($design->objectTariff)->name . '<br>' . Tariff::find($design->objectTariff)->price),
            TD::make('objectSquare', 'Стоиомость')
                ->sort()
                ->render(fn(Design $design) => ($design->objectSquare * Tariff::find($design->objectTariff)->price).' .р' ),
            TD::make('objectTariff', 'Менеджер/Дизайнер')->render(function (Design $design) {
                $manager = $designer = User::find(1);
                isset($design->manager) ? $manager = User::find($design->manager) : $manager->name = 'Не назначен';
                isset($design->designer) ? $designer = User::find($design->designer) : $designer->name = 'Не назначен' ;
                return $manager->name . "<br>" . $designer->name;
           }),
            TD::make('created_at', 'Создан')->sort()->defaultHidden(),
            TD::make('updated_at', 'Изменен')->sort()->defaultHidden(),
        ];
    }
}
