<?php

namespace App\Orchid\Layouts\Repair;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Entities;
use App\Models\Estimate;
use App\Models\Repair;
use App\Models\Tariff;
use App\Models\User;
use App\Orchid\Layouts\RepairListener;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;

class RepairCreate extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;


    protected $targets = [
        'repair.estimate',
        'repair.totalAmount',
        'repair.disignCoast',
        'repair.discount',
        'repair.objectSquare',

    ];
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */



    public function asyncSum($disignCoast, $objectSquare)
    {
        return [
            'repair.disignCoast' => $disignCoast,
            'repair.objectSquare' => $objectSquare,
            'repair.totalAmount' => $disignCoast + $objectSquare
        ];
    }


    protected function fields(): array
    {
        return [
            Group::make([
                Relation::make('repair.objectType')
                    ->title('Тип договора')
                    ->required()
                    ->fromModel(Contract::class, 'contrType')
                    ->help('Тип договора'),
                Relation::make('repair.company')
                    ->title('Компания')
                    ->required()
                    ->fromModel(Entities::class, 'organizationNameFull')
                    ->help('Тип компании'),
            ]),
            Group::make([
                Relation::make('repair.estimate')
                    ->title('Смета')
                    ->required()
                    ->help('Выберите существующего клиента со сметой')
                    ->fromModel(Estimate::class, 'objectAddress')
                    ->applyScope('active'),
                Link::make('Смета')
                    ->horizontal()
                    ->route('platform.estimate.edit', $this->query->getContent('repair.estimate')),
            ]),
            Group::make([
                Relation::make('repair.person')
                    ->title('Клиент')
                    ->required()
                    ->fromModel(Client::class, 'name'),
                ModalToggle::make('Редактировать клиента')
                    ->canSee($this->query->has('repair.person'))
                    ->modal('client_edit')
                    ->method('asyncSaveClient')
                    ->asyncParameters([
                        'client' => $this->query->getContent('repair.person'),
                    ])
                    ->icon('user'),
            ]),
            Select::make('repair.tariff')
                ->title('Тариф')
                ->required()
                ->fromQuery(Tariff::where('type', '=', 'Ремонт'), 'name' )
                ->help('Тип тарифа'),

                //ModalToggle::make('Смета')
                //->horizontal()
                //->modal('estimate_edit')
                //->method('asyncSaveEstimate')
                //->route('platform.estimate.edit', $this->query->getContent('repair.estimate')),

            Group::make([
                Input::make('repair.disignCoast')
                    ->title('Стоимость дизайна')
                    ->placeholder('Стоимость дизайна')
                    ->type('number')
                    ->help('Введите стоимость дизайна')
                    ->mask([
                        'alias' => 'currency',
                        'prefix' => '',
                        'groupSeparator' => '',
                        'digitsOptional' => true,
                    ]),
                CheckBox::make('repair.checkPresent')
                    ->value(1)
                    ->title('Статус')
                    ->placeholder('Дизайн в подарок')
                    ->help('Если дизайн идёт в подарок'),
            ]),

            Input::make('repair.discount')
                ->title(' Указать размер скидки в %')
                ->help('Введите размер скидки')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            Input::make('repair.deposit')
                ->title('Обеспечительный депозит в рублях')
                ->help('Введите размер обеспечительного депозита')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            Input::make('repair.termContract')
                ->title('Срок исполнения договора')
                ->type('number')
                ->help('Сколько в днях')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            Input::make('repair.objectSquare')
                ->title('Площадь объекта')
                ->required()
                ->type('number')
                ->help('Введите площадь обьекта м²')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,])
                ,

            //подтянуть сумму из сметы/ либо если выбран фикс ремонт - то расчет производится
            // автоматически согласно проставленной площади и выбранного тарифа
            Input::make('repair.totalAmount')
                ->title('Общая сумма договора ')
                //->readonly()
                //->disabled()
                //->canSee($this->query->has('repair.objectSquare')),
                ->title('Общая сумма договора ')
                ->required()
                ->help('')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ]),

            Group::make([
                Select::make('repair.manager')
                    ->title('Менеджер проекта')
                    ->fromQuery(User::with(['roles'])->whereHas('roles', function (Builder $query) {
                        $query->where('slug', 'client manager');
                    }), 'name')
                    ->help( 'Менеджер проекта'),

                Select::make('repair.foreman')
                    ->title('Прораб проекта')
                    ->fromQuery(User::with(['roles'])->whereHas('roles', function (Builder $query) {
                        $query->where('slug', 'projetman');
                    }), 'name')
                    ->help( 'Прораб проекта'),

                Select::make('repair.supplier')
                    ->title('Снабженец проекта')
                    ->fromQuery(User::with(['roles'])->whereHas('roles', function (Builder $query) {
                        $query->where('slug', 'snab');
                    }), 'name')
                    ->help( 'Снабженец проекта'),
            ]),
//            Select::make('repair.paySchedule')
//                ->title('График платежей')
////                ->required()
//                ->options([
//                    ''=>'',
//                    '1' => 'окно 1-й платеж - 50% от общей суммы+окно - дата платежа',
//                    '2' => 'окно 2-й платеж - 25% от общей суммы+окно - дата платежа',
//                    '3' => 'окно 3-й платеж - 15% от общей суммы+окно - дата платежа',
//                    '4' => 'окно 4-й платеж - 10% от общей суммы+окно - дата платежа',
//                ])
//                ->help('График платежей'),

        ];
    }
    public function layout(): array
    {
        return [
            RepairListener::class,
        ];
    }
}
