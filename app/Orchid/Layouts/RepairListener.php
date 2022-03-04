<?php

namespace App\Orchid\Layouts;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Entities;
use App\Models\Estimate;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;

class RepairListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
//        'repair.estimate',
//        'repair.totalAmount',
       'repair.disignCoast',
//        'repair.discount',
        'repair.objectSquare',

    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncSum';
    public function asyncSum( $disignCoast, $objectSquare)
    {
        return [
            'repair.disignCoast' => $disignCoast,
            'repair.objectSquare' => $objectSquare,
            'repair.totalAmount' => $disignCoast + $objectSquare
        ];
    }


    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [



                Input::make('repair.disignCoast')
                    ->title('Стоимость дизайна')
                    ->placeholder('Стоимость дизайна')
                    ->help('Введите стоимость дизайна')
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => '',
                        'groupSeparator' => '',
                        'digitsOptional' => true,
                    ]),
            Input::make('repair.objectSquare')
                ->title('Площадь объекта')
                ->required()
                ->help('Введите площадь обьекта м²')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            //подтянуть сумму из сметы/ либо если выбран фикс ремонт - то расчет производится
            // автоматически согласно проставленной площади и выбранного тарифа
            Input::make('repair.totalAmount')
                ->canSee($this->query->has('totalAmount'))
                ->title('Общая сумма договора ')
                ->required()
                ->help('')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),
        ];
    }


}
