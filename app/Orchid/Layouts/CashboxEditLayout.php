<?php

namespace App\Orchid\Layouts;

use App\Models\Client;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CashboxEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('cashbox.cboxName')
                ->title('Наименование счета')
                ->required()
                ->help('Введите наименование счета'),
            Relation::make('repair.cboxPerson')
                ->title('Ответственный сотрудник')
                ->required()
                ->fromModel(Client::class, 'surname')
                ->searchColumns( 'name', 'surname'),
            CheckBox::make('cashbox.cboxActive')
                ->title('Активный счёт')
                ->required()
                ->help('Отметить активный счёт'),
            ];
    }
}
