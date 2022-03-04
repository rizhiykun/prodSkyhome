<?php

namespace App\Orchid\Screens\Clients;

use App\Models\Client;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class ClientEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование клиента';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Экран редактирования клиента';

    public $exists = false;

    /**
     * Query data.
     *
     * @param Client $client
     * @return array
     */
    public function query(Client $client): array
    {
        $this->exists = $client->exists;

        if($this->exists){
            $this->name = 'Редактировать';
        }

        return [
            'client' => $client
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Добавить клиента')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Сохранить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                'Физическое лицо' => [
                    Layout::rows([
                        Input::make('client.name')
                            ->type('text')
                            ->title('Имя')
                            ->placeholder('Имя'),

                        Input::make('client.surname')
                            ->type('text')
                            ->title('Фамилия')
                            ->placeholder('Фамилия'),

                        Input::make('client.patronymic')
                            ->type('text')
                            ->title('Отчество')
                            ->placeholder('Отчество'),

                        Input::make('client.email')
                            ->type('email')
                            ->title('Email')
                            ->placeholder('Email'),

                        Input::make('client.phone')
                            ->mask('(999) 999-9999')
                            ->title('Номер телефона'),

                        Input::make('client.address')
                            ->type('text')
                            ->title('Адрес')
                            ->placeholder('Ул. Ленина дом 14 оф.162'),

                        Input::make('client.real_address')
                            ->type('text')
                            ->title('Адрес доставки')
                            ->placeholder('Ул. Ленина дом 14 оф.162'),

                        DateTimer::make('client.birthdate')
                            ->allowInput()
                            ->format('Y-m-d')
                            ->title('дата рождения'),

                        Input::make('client.passport')
                            ->type('text')
                            ->title('Паспорт')
                            ->placeholder('Паспорт'),


                    ]),
                ],
                'Юридическое лицо'      => [
                    Layout::rows([
                        Input::make('client.name')
                            ->type('text')
                            ->title('Название')
                            ->placeholder('Название'),

                        Input::make('client.surname')
                            ->type('text')
                            ->title('Полное название')
                            ->placeholder('Полное название'),

                        Input::make('client.email')
                            ->type('email')
                            ->title('Email')
                            ->placeholder('Email'),

                        Input::make('client.phone')
                            ->mask('(999) 999-9999')
                            ->title('Номер телефона'),

                        Input::make('client.address')
                            ->type('text')
                            ->title('Адрес')
                            ->placeholder('Ул. Ленина дом 14 оф.162'),

                        Input::make('client.real_address')
                            ->type('text')
                            ->title('Фактический Адрес')
                            ->placeholder('Ул. Ленина дом 14 оф.162'),

                        Input::make('client.inn')
                            ->type('number')
                            ->title('ИНН')
                            ->placeholder('ИНН'),

                        Input::make('client.kpp')
                            ->type('number')
                            ->title('КПП')
                            ->placeholder('КПП'),

                        Input::make('client.ogrn')
                            ->type('number')
                            ->title('ОГРН')
                            ->placeholder('ОГРН'),

                        Input::make('client.req')
                            ->type('text')
                            ->title('в лице')
                            ->placeholder('в лице: должность ____ фио _____на основании чего действует ______'),

                        Input::make('client.bank')
                            ->type('text')
                            ->title('Банковские реквзииты')
                            ->placeholder('Банковские реквзииты'),

                        Input::make('client.signer')
                            ->type('text')
                            ->title('Подписант')
                            ->placeholder('Подписант'),

                    ]),
                ]
            ]),
        ];
    }
    public function createOrUpdate(Client $client, Request $request)
    {
        $client->fill($request->get('client'))->save();

        Alert::info('Вы создали.');

        return redirect()->route('platform.client.list');
    }

    public function remove(Client $client)
    {
        $client->delete();

        Alert::info('Вы удалили');

        return redirect()->route('platform.client.list');
    }
}
