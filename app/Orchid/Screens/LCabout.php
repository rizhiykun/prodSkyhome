<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Orchid\Layouts\Clients\ClientAddEnt;
use App\Orchid\Layouts\Clients\ClientAddFiz;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class LCabout extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Мои данные';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Мои данные';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {


        $client = Client::where('email', '=', Auth::user()->email)->first();

        return [
            'client' => $client
        ];
    }

    public $permission = [
//        'platform.lc'
    ];


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $client = Client::where('email', '=', Auth::user()->email)->first();
        if (strlen($client->inn) < 3) {
            return [
                ClientAddFiz::class
            ];
        }
        else {
            return [
                ClientAddEnt::class
            ];
        }

    }
}
