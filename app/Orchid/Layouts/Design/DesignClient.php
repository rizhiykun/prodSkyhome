<?php

namespace App\Orchid\Layouts\Design;

use App\Models\Client;
use App\Models\Design;
use App\Models\Entities;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DesignClient extends Rows
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
            Group::make([

                Relation::make('design.person')
                    ->title('Клиент')
                    ->required()
                    ->fromModel(Client::class, 'name')
                    ->searchColumns( 'name'),
                ModalToggle::make('Редактировать клиента')
                    ->canSee($this->query->has('design.person'))
                    ->modal( function () {
                        if ($this->query->has('design.person')) {
                            $client = Client::find($this->query->getContent('design.person'));
                            return $client->inn > 0 ? 'client_edit_ent' : 'client_edit_fiz';
                        }
                        else {
                            return 'client_edit_ent';
                        }
                } )
                    ->method('asyncSaveClient')
                    ->asyncParameters([
                        'client' => $this->query->getContent('design.person'),
                    ])
                    ->icon('user'),
            ]),

            Relation::make('design.ourCompany')
                ->title('Наша компания')
                ->fromModel(Entities::class, 'organizationNameFull')
                ->help('Наша компания - подписант документов'),

            Input::make('design.objectAddress')
                ->title('Адрес обьекта')
                ->required()
                ->placeholder('Адрес обьекта')
                ->help('Введите Адрес обьекта'),

            Input::make('design.objectSquare')
                ->title('Площадь м²')
                ->required()
                ->help('Введите площадь')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            Select::make('design.manager')
                ->title('Менеджер проекта')
                ->fromQuery(User::with(['roles'])->whereHas('roles', function (Builder $query) {
                    $query->where('slug', 'client manager');
                }), 'name')
                ->help( 'Менеджер проекта'),

            Select::make('design.designer')
                ->title('Дизайнер проекта')
                ->fromQuery(User::with(['roles'])->whereHas('roles', function (Builder $query) {
                    $query->where('slug', 'designer');
                }), 'name')
                ->help( 'Дизайнер проекта'),


            Select::make('design.objectTariff')
                ->title('Тариф')
                ->required()
                ->fromQuery(Tariff::where('type', '=', 'Дизайн'), 'name')
                ->help('Тариф'),

            Input::make('design.objectData')
                ->title('Срок исполнения (дней)')
                ->type('number')
                ->required(),

//            Input::make('design.objectData')
//                ->title('Срок исполнения (рабочих дней)')
//                ->required()
//                ->help('Введите количество дней на исполнение')
//                ->mask([
//                    'alias' => 'currency',
//                    'prefix' => '',
//                    'groupSeparator' => '',
//                    'digitsOptional' => true
//
//                ]),
//            Input::make('design.cost')
//                ->title('Стоимость')
//                ->required()
//                ->disabled(true)
//                ->help('Стоимость с учётом тарифа'),
//            Input::make('design.discount')
//                ->title('Размер скидки в %')
//                ->required()
//                ->help('Введите размер скидки в %')
//                ->mask([
//                    'alias' => 'currency',
//                    'prefix' => ' ',
//                    'groupSeparator' => ' ',
//                    'digitsOptional' => true
//
//                ]),
        ];
    }
}
