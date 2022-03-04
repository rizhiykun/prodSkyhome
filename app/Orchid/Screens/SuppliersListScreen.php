<?php

namespace App\Orchid\Screens;

use App\Models\Suppliers;
use App\Orchid\Layouts\newSupplier;
use App\Orchid\Layouts\SuppliersListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SuppliersListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Поставщики';
    public $permission = [
        'platform.suppliers.list'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Страница отображает всех доступных поставщиков, для редактирования поставщика кликните по его(её) имени';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Suppliers $supplier): array
    {
        $this->exists = $supplier->exists;

        if($this->exists){
            $this->name = 'Редактирование поставщика';
        }
        return [
            'supplier' => $supplier,
            'Suppliers' => Suppliers::filters()->paginate()
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
            ModalToggle::make('Создать поставщика')
                ->icon('pencil')
                ->modal('newSupplier')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
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
            SuppliersListLayout::class,
            Layout::modal('newSupplier', newSupplier::class)
                ->title('Создать поставщика')
                ->applyButton('Создать'),
        ];
    }

    public function createOrUpdate(Suppliers $supplier, Request $request)
    {
        $supplier->fill($request->get('supplier'))->save();

        Toast::info('Поставщик "'.$supplier['name'].'" успешно добавлен\обновлен');

        return redirect()->route('platform.suppliers.list');
    }


    public function remove(Suppliers $supplier)
    {
        $supplier->delete();
        Toast::info('Вы удалили поставщика'.$supplier['name']);

        return redirect()->route('platform.suppliers.list');
    }
}
