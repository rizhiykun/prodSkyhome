<?php

namespace App\Orchid\Screens;

use App\Models\NormsList;
use App\Orchid\Layouts\editNorm;
use App\Orchid\Layouts\NormListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class NormsListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Нормы списания';

    public $permission = [
        'platform.norms.list'
    ];
    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Нормы списания материалов';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(NormsList $normsList): array
    {
        $this->exists = $normsList->exists;

        if($this->exists){
            $this->name = 'Редактирование норм';
        }
        return [
            'normsList' => $normsList,
            'NormsList' => NormsList::paginate()
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
            ModalToggle::make('Добавить материал')
                ->icon('pencil')
                ->modal('editNorm')
                ->method('createOrUpdate')
                //->canSee(!$this->exists),
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
            NormListLayout::class,
            Layout::modal('editNorm', editNorm::class)
                ->title('Создать норму')
                ->applyButton('Создать'),
        ];
    }
    public function createOrUpdate(NormsList $normsList, Request $request)
    {
        $normsList->fill($request->get('normsList'))->save();

        Toast::info('Норма "'.$normsList['name'].'" успешно добавлен\обновлен');

        return redirect()->route('platform.norms.list');
    }


    public function remove(NormsList $normsList)
    {
        $normsList->delete();
        Toast::info('Вы удалили норму'.$normsList['name']);

        return redirect()->route('platform.norms.list');
    }
}
