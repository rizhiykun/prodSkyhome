<?php

namespace App\Orchid\Screens;

use App\Models\NormsList;
use App\Models\RepairBlock;
use App\Models\RepairPriceList;
use App\Models\Supply;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class NormsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование позиции';
    public $permission = [
        'platform.norms.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование позиции в нормах расхода материалов';


    /**
     * Query data.
     *
     * @param RepairPriceList $nlItem
     * @return array
     */
    public function query(NormsList $normsList): array
    {
        $this->exists = $normsList->exists;

        if($this->exists){
            $this->name = 'Редактирование позиции';
        }

        $supply = $normsList->supply;



        return [
            'normsList' => $normsList,
            'blocks' => RepairBlock::all(),
            'supply' => $supply
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
            Button::make('Создать позицию')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make('Обновить')
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
     * @return string[]|\Orchid\Support\Facades\Layout[]
     */

    public function layout(): array
    {

        return [
            Layout::rows([
                Select::make('normsList.WorkID')
                    ->required()
                    ->fromModel(RepairPriceList::class, 'workName'),
                Matrix::make('normsList.supply')
                    ->title('Прайсовые Работы')
                    ->columns(['Материалы' => 'Material', 'Количество материала' => 'quantity'])
                    ->fields([
                        'Material' => Select::make('Material')
                            ->required()
                            ->fromQuery(Supply::where('id', '!=', '0'),'name', 'name'),
                        'quantity' => Input::make('much')
                            ->type('text')
                            ->value(fn($value) => (float) $value)
                            ->mask([
                                'alias'          => 'currency',
                                'prefix'         => '',
                                'groupSeparator' => '',
                                'digitsOptional' => true,
                                'radixPoint'     => '.',])
                            ->required()

                    ]),
            ])
            ];

    }

    public function createOrUpdate(NormsList $normsList, Request $request)
    {
        $supply = collect($request->get('supply'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();

        $normsList->supply = $supply;

        $normsList
            ->fill($request->get('normsList'))
            ->save();

        Alert::info('Позиция успешно добавлена\обновлена');

        return redirect()->route('platform.norms.list');
    }


    public function remove(RepairPriceList $supply)
    {
        $supply->delete();

        Alert::info('Вы удалили позицию');

        return redirect()->route('platform.norms.list');
    }
}

