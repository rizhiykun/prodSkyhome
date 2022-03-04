<?php

namespace App\Orchid\Screens\Repair;

use App\Models\Client;
use App\Models\Repair;
use App\Orchid\Layouts\Clients\ClientAddFiz;
use App\Orchid\Layouts\Repair\RepairCreate;
use App\Orchid\Layouts\RepairListener;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\RepairListTableLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;


class RepairListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Ремонт';
    public $permission = [
        'platform.repair.list'
    ];


    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список проектов по ремонту';


    /**
     * Query data.
     *
     * @param Repair $repair
     * @return array
     */



    public function query(Repair $repair): array
    {

        return [

            'repair' => Repair::paginate()
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
            ModalToggle::make('Создать ремонтный проект')
                ->icon('pencil')
                ->modal('newRepair')
                ->method('createOrUpdate')
                //->canSee(!$this->exists),
//            Link::make('Создать ремонтный проект')
//                ->icon('pencil')
//                ->route('platform.repair.edit')
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

            //
                RepairListTableLayout::Class,
                //RepairListener::class,
                Layout::modal('newRepair', RepairCreate::class)
                    ->title('Создать ремонтный проект')
                    ->applyButton('Создать')
                    ->size(Modal::SIZE_LG),


        ];
    }
    public function createOrUpdate(Repair $repair, Request $request)
    {
        $repair->fill($request->get('repair'))->save();

        Toast::info('Ремонт "' .$repair['name'].'" успешно добавлен\обновлен');

        return redirect()->route('platform.repair.list');
    }
    public function remove(Repair $repair)
    {
        $repair->delete();
        Toast::info('Вы удалили клиента ' .$repair['name']);

        return redirect()->route('platform.repair.list');
    }
}

