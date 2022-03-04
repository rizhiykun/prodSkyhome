<?php

namespace App\Orchid\Layouts\Estimates;

use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class EstimateClientListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'estimate.clientID'
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
    protected $asyncMethod = 'asyncEsimatesdata';
    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Relation::make('estimate.clientID')
                        ->title('Клиент')
                        ->required()
                        ->help('Выберите существующего клиента')
                        ->fromModel(Client::class, 'name')
                        ->searchColumns( 'name'),
                    Input::make('estimate.objectAddress')
                        ->type('text')
                        ->help('Введите адрес объекта')
                        ->title('Адрес объекта')
                        ->required(),
                    Input::make('estimate.floorArea')
                        ->type('text')
                        ->value(fn($value) => (float)$value)
                        ->mask([
                            'alias' => 'currency',
                            'prefix' => '',
                            'groupSeparator' => '',
                            'digitsOptional' => true,
                            'radixPoint' => '.',])
                        ->help('Площадь пола в квадратных метрах')
                        ->title('Площадь пола')
                        ->required(),
                    Input::make('estimate.ceilingHeight')
                        ->type('text')
                        ->value(fn($value) => (float)$value)
                        ->mask([
                            'alias' => 'currency',
                            'prefix' => '',
                            'groupSeparator' => '',
                            'digitsOptional' => true,
                            'radixPoint' => '.',])
                        ->help('Высота потолков в метрах')
                        ->title('Высота потолков')
                        ->required(),
                ]),
            ])->title('Данные проекта из карты клиента'),
        ];
    }
}
