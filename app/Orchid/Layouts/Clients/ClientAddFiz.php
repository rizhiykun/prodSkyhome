<?php

namespace App\Orchid\Layouts\Clients;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ClientAddFiz extends Rows
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
            Input::make('client.name')
                ->type('text')
                ->title('ФИО')
                ->placeholder('Фамилия Имя Отчество Клиента'),
            Group::make([
            Input::make('client.email')
                ->type('email')
                ->title('Email')
                ->placeholder('Email'),
            Input::make('client.phone')
                ->mask('+9(999)999-9999')
                ->title('Номер телефона')
                ->placeholder('Номер телефона'),
            ]),
            Input::make('client.address')
                ->type('text')
                ->title('Адрес')
                ->placeholder('Ул. Ленина дом 1 кв.1'),
            Input::make('client.real_address')
                ->type('text')
                ->title('Адрес Фактического проживания')
                ->placeholder('Ул. Ленина дом 1 кв.1'),
            DateTimer::make('client.birthdate')
                ->allowInput()
                ->format('d.m.Y')
                ->title('Дата Рождения')
                ->placeholder('Указать дату рождения'),
            TextArea::make('client.passport')
                ->rows(3)
                ->title('Паспорт')
                ->help('Введите все необходимые реквизиты паспорта, а именно СЕРИЯ НОМЕР Кем и Когда Выдан, Адрес по прописке')
                ->placeholder('Паспортные данные клиента'),
        ];
    }
}
