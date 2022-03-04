<?php

namespace App\Orchid\Layouts;

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
    public function asyncEsimatesdata($estimateClientID)
    {
        $client = Client::find($estimateClientID);
        Log::error('method started');
        return [
            'estimate.clientID' => $estimateClientID,
            'estimate.objectAddress' => $client->address
        ];
    }
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
                        ->help('Введите адрес обьекта')
                        ->title('Адрес обьекта')
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
                        ->help('Площадь пола в квадртаных метрах')
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
                        ->help('Высота потолков в квадратных метрах')
                        ->title('Высота потолков')
                        ->required(),
                ]),
            ])->title('Данные проекта из карты клиента'),
        ];
    }
}
