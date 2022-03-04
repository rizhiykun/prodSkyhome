<?php

namespace App\Orchid\Screens\Clients;

use App\Models\Client;
use App\Models\Suppliers;
use App\Orchid\Layouts\Clients\ClientAddEnt;
use App\Orchid\Layouts\Clients\ClientAddFiz;
use App\Orchid\Layouts\Clients\ClientListLayout;
use App\Orchid\Layouts\newSupplier;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ClientListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Клиенты';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = '';
    public $permission = ['platform.clients.list'];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Client $client): array
    {
        $this->exists = $client->exists;

        if($this->exists){
            $this->name = 'Редактирование клиента';
        }
        return [
            'client' => $client,
            'clients' => Client::filters()->paginate()
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
            ModalToggle::make('Создать физическое лицо')
                ->icon('pencil')
                ->modal('newFizClient')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
                //->route('platform.client_fiz.edit'),
            ModalToggle::make('Создать Юридическое лицо')
                ->icon('pencil')
                ->modal('newEntClient')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
                //->route('platform.client_ent.edit')
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
            ClientListLayout::class,
            Layout::modal('newFizClient', ClientAddFiz::class)
                ->title('Создать физическое лицо')
                ->applyButton('Создать'),
            Layout::modal('newEntClient', ClientAddEnt::class)
                ->title('Создать Юридическое лицо')
                ->applyButton('Создать'),
        ];
    }
    public function createOrUpdate(Client $client, Request $request)
    {
        $client->fill($request->get('client'))->save();

        Toast::info('Клиент "' .$client['name'].'" успешно добавлен\обновлен');

        return redirect()->route('platform.client.list');
    }


    public function remove(Client $client)
    {
        $client->delete();
        Toast::info('Вы удалили клиента ' .$client['name']);

        return redirect()->route('platform.client.list');
    }
}
