<?php

namespace App\Orchid\Layouts\Clients;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ClientAddEnt extends Rows
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
                ->title('Название')
                ->placeholder('Название'),
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
                ->placeholder('Ул. Ленина дом 1 оф.1'),
            Input::make('client.real_address')
                ->type('text')
                ->title('Фактический Адрес')
                ->placeholder('Ул. Ленина дом 1 оф.1'),
            Group::make([
                Input::make('client.inn')
                    ->mask("9999999999")
                    ->title('ИНН')
                    ->placeholder('ИНН'),
                Input::make('client.kpp')
                    ->mask("999999999")
                    ->title('КПП')
                    ->placeholder('КПП'),
            ]),
                Input::make('client.ogrn')
                    ->mask("9999999999999")
                    ->title('ОГРН')
                    ->placeholder('ОГРН'),
                Input::make('client.req')
                    ->type('text')
                    ->title('в лице')
                    ->placeholder('в лице: должность ____ фио _____на основании чего действует ______'),
            Input::make('client.bank')
                ->type('text')
                ->title('Другие Банковские реквизиты')
                ->placeholder('Другие Банковские реквизиты'),
            Input::make('client.signer')
                ->type('text')
                ->title('Подписант')
                ->placeholder('Подписант'),
        ];
    }
}
