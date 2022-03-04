<?php

namespace App\Orchid\Screens\Clients;

use App\Models\Client;
use App\Orchid\Layouts\Clients\ClientAddFiz;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class ClientFizEditScreen extends Screen
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
    public $permission = ['platform.clients.edit'];

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
        return [ClientAddFiz::class];
    }

    public function createOrUpdate(Client $client, Request $request)
    {
        $client->fill($request->get('client'))->save();

        Alert::info('Вы создали клиента');

        return redirect()->route('platform.client.list');
    }

    public function remove(Client $client)
    {
        $client->delete();

        Alert::info('Вы удалили клиента');

        return redirect()->route('platform.client.list');
    }
}
