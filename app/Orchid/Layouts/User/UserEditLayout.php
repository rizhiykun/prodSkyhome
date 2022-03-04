<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__("Email")),
            Input::make('user.phone')
                ->type('text')
                ->mask('+9(999)999-9999')
                ->required()
                ->title(__('Phone'))
                ->placeholder(__('Phone')),
            DateTimer::make('user.birthDate')
                ->allowInput()
                ->format('d.m.Y')
                ->title('дата рождения'),
            Input::make('user.address')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Адрес прописки'))
                ->placeholder(__('Адрес прописки')),
            Input::make('user.passpData')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Паспортные данные, кем выдан'))
                ->placeholder(__('Паспортные данные, кем выдан')),
            Input::make('user.passpNums')
                ->type('text')
                ->mask('9999 999999')
                ->required()
                ->title(__('серия и номер паспорта'))
                ->placeholder(__('серия и номер паспорта')),
            DateTimer::make('user.birthDate')
                ->allowInput()
                ->format('d.m.Y')
                ->required()
                ->title(__('Дата выдачи паспорта'))
                ->placeholder(__('Дата выдачи - паспорта')),

            Input::make('dataset.overprice')

                ->type('number')
                ->canSee(Auth::user()->inRole('admin'))
                ->value(0)
                ->max(100)
                ->title('Наценка')
                ->help('Наценка'),

            //Relation::make('user.person')
            //    ->title('Пользователь ')
            //    ->fromModel(Person::class, 'lastname')
            //    ->displayAppend('FIO')
            //   ->required()
            //     ->help('Выберете человека')
            //    ->placeholder('Выберете человеку'),
        ];
    }
}
