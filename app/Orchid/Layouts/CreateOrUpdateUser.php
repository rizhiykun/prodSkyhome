<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Group;

class CreateOrUpdateUser extends Rows
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
        //$isClientExist = is_null($this->query->getContent('users')) === false;
        return [
            Input::make('user.name')
                ->required()
                ->type('text')
                ->title('ФИО')
                ->placeholder('Фамилия Имя Отчество'),
            Group::make([
            Input::make('user.email')
                ->required()
                ->type('email')
                ->title('Email')
                ->placeholder('Email'),
            Input::make('user.phone')
                ->required()
                ->mask('+7(999) 999-9999')
                //->disabled($isClientExist)
                ->title('Номер телефона'),
            ]),
            Input::make('user.password')
                ->required()
                ->type('password')
                ->title('Пароль пользователя')
                ->placeholder('Введите пароль пользователя'),

            Input::make('user.address')
                ->required()
                ->type('text')
                ->title('Адрес')
                ->placeholder('Ул. Ленина дом 14 оф.162'),
            DateTimer::make('user.birthDate')
                ->required()
                ->allowInput()
                ->format('d.m.Y')
                ->title('дата рождения'),
            TextArea::make('user.passpData')
                ->required()
                ->rows(2)
                ->title('Паспорт')
                ->placeholder('Паспорт'),
            Group::make([
            Input::make('user.passpNums')
                ->required()
                ->type('text')
                ->title('Серия и номер паспорта')
                ->mask('9999 999999')
                ->placeholder('Серия и номер паспорта'),
            DateTimer::make('user.passpIssued')
                ->required()
                ->allowInput()
                ->format('d.m.Y')
                ->title('Дата выдачи паспорта'),
            ]),
        ];
    }
}
