<?php

namespace App\Orchid\Screens;

use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Document;
use App\Models\Estimate;
use App\Models\Measurement;
use App\Models\Repair;
use App\Models\RepairBlock;
use App\Models\RepairPriceList;
use App\Models\RepairType;
use App\Orchid\Layouts\Estimates\EstimateBlock;
use App\Orchid\Layouts\Estimates\EstimateClientListener;
use App\Orchid\Layouts\Estimates\EstimateGeneral;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use phpDocumentor\Reflection\Types\This;

class EstimateEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Смета';
    public $permission = [
        'platform.estimate.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Экран создания и редактирования смет';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @param Estimate $estimate
     * @param RepairBlock $block
     * @return array
     */
    public function query(Estimate $estimate): array
    {
        $this->exists = $estimate->exists;

        if($this->exists){
            $this->name = 'Редактировать';
        }

        $works = $estimate->works;
        $additionalWorks = $estimate->additionalWorks;

        return [
            'estimate' => $estimate,
            'blocks' => RepairBlock::all(),
            'works' => $works,
            'additionalWorks' => $additionalWorks
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
            Button::make('Добавить')
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

    public function asyncEsimatesdata($estimateClientID)
    {
        $client = Client::find($estimateClientID);
        return [
            'estimate.clientID' => $estimateClientID,
            'estimate.objectAddress' => $client->address
        ];
    }

    public function getBlocks() {
        $retVal = array();
        $works = array();
        $retVal['Общая инфомарация'] = [
            Layout::rows([
                Group::make([
//                    Relation::make('estimate.objectType')
//                        ->title('Тип сметы')
//                        ->required()
//                        ->help('Выберите тип сметы(тип работ)')
//                        ->fromModel(RepairType::class, 'name')
//                        ->searchColumns( 'name'),
                    Select::make('estimate.Rationale')
                        ->required()
                        ->options([
                            ''   => '',
                            'Дизайн-проект'   => 'Дизайн-проект',
                            'Замер' => 'Замер',
                            'Технический проект' => 'Технический проект',
                            'Информация от заказчика' => 'Информация от заказчика',
                        ])
                        ->title('Основание')
                        ->help('Обоснование необходимости создания сметы'),
                ])
            ]),
            EstimateClientListener::class,
        ];
        foreach (RepairBlock::all() as $block) {
            $works[$block->name] = [
                Layout::rows([
                    Matrix::make('works.'.$block->name)
                        ->title('Прайсовые Работы')
                        ->columns(['Работы' => 'work','Еденица измерения' => 'measurement', 'Обьем' => 'volume'])
                        ->fields([
                            'work'   => Select::make('work')
                                ->required()
                                ->fromQuery(RepairPriceList::where('workBlock', '=', [$block->id]), 'workName', 'workName'),
                            'measurement' => Select::make('measurement')->fromQuery(Measurement::where('id', '>', 0), 'name')->required(),
                            'volume' => Input::make('volume')
                                ->type('text')
                                ->required()
                                ->value(fn($value) => (float) $value)
                                ->mask([
                                    'alias'          => 'currency',
                                    'prefix'         => '',
                                    'groupSeparator' => '',
                                    'digitsOptional' => true,
                                    'radixPoint'     => '.',]),
//                            'price' => TextArea::make('price')->value('work')
                        ]),
                    Matrix::make('additionalWorks.'.$block->name)

                        ->title('Работы которых нет в прайсе')

                        ->columns(['Название работы' => 'workName','Еденица измерения' => 'measurement','Цена мастера' =>
                            'masterPrice','Объем' => 'volume'])

                        ->fields([
                            'workName' => TextArea::make('workName')
                                ->required(),
                            'measurement' => Select::make('measurement')->fromQuery(Measurement::where('id', '>', 0), 'name')->required(),
                            'masterPrice' => TextArea::make('masterPrice')
                                ->required(),
                            'volume' => TextArea::make('volume')
                                ->required(),
//                            'Цена' => TextArea::make('price')->required(),
                        ])
                ])
            ];
        }
        $retVal['Работы'] = [
            Layout::accordion($works),
        ];
        $retVal['Хвост сметы'] = [
            Layout::rows([
                Input::make('estimate.discounts')
                    ->type('number')
                    ->required()
                    ->value(0)
                    ->max(100)
                    ->title('Скидка')
                    ->help('Скидка'),
//сделать мастера и прораба
                Button::make('Печать')
                    ->rawClick()
                    ->method('print'),
                Button::make('Печать сметы для мастера')
                    ->rawClick()
                    ->method('printMaster'),
                Button::make('Печать сметы для прораба')
                    ->rawClick()
                    ->method('printForeman'),
                Button::make('Согласовать')
                    ->rawClick()
                    ->method('approve'),
                Button::make('Отозвать с согласования')
                    ->rawClick()
                    ->method('disapprove'),
                ]),
        ];

        return $retVal;
    }

    /**
     * Views.
     *
     * @return string[]|Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs(
                $this->getBlocks()
            )
        ];
    }

    public function approve (Estimate $estimate) {
        $estimate->approval = 1;
        $estimate->update();
        Toast::info(__('Смета согласована'));
    }

    public function disapprove (Estimate $estimate) {
        $estimate->approval = 0;
        $estimate->update();
        Toast::info(__('Смета отозвана с согласования'));
    }

    public function print (Estimate $estimate, Request $request) {
        $works = collect($request->get('works'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $additionalWorks = collect($request->get('additionalWorks'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $summprice = 0;

        foreach ($works as &$block) {
            foreach ($block as &$row) {
                $elem = RepairPriceList::where('workName', '=', $row['work'])->first();
                $row['price'] = $elem->discountPrice * $row['volume'];
                $summprice = $summprice + $row['price'];
//                echo $row['work'];
            }
        }

        foreach ($additionalWorks as &$block) {
            foreach ($block as &$row) {
                $row['price'] = $row['masterPrice'] * $row['volume'];
                $summprice = $summprice + $row['price'];
            }
        }
        //dd($estimate);

        $data = array();
        $data['works'] = $works;
        //        Данные из документа по ремонту
        $repair = Repair::where('estimate','=', $estimate->id)->first();
        dd($repair);
        $data['d_number'] = $repair->id;
        $data['d_date'] = $repair->created_at;
        $data['manager'] = $repair->manager;
        $data['time'] = $repair->termContract;

        //        Данные из документа по ремонту
        $data['doc_number'] = $estimate->id;
        $data['date'] = $estimate->created_at;
        $data['Rationale'] = $estimate->Rationale;
        $data['estimate.clientID'] = Client::find($estimate->clientID)->name;
        $data['estimate.objectAddress'] = $estimate->objectAddress;
        $data['objectSquare'] = $estimate->floorArea.' м2';
        $data['estimate_summary'] = $estimate->summaryPrice;
        $request->merge(['data' => $data]);
        $request->merge(['templateId' => 10]);
        $stream = new InvoiceController;
        return $stream->makedoc($request);
    }
    public function printForeman (Estimate $estimate, Request $request) {
        $works = collect($request->get('works'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $additionalWorks = collect($request->get('additionalWorks'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $summprice = 0;

        foreach ($works as &$block) {
            foreach ($block as &$row) {
                $elem = RepairPriceList::where('workName', '=', $row['work'])->first();
                $row['price'] = $elem->foremanPrice * $row['volume'];
                $summprice = $summprice + $row['price'];
//                echo $row['work'];
            }
        }

        foreach ($additionalWorks as &$block) {
            foreach ($block as &$row) {
                $row['price'] = $row['masterPrice'] * $row['volume'];
                $summprice = $summprice + $row['price'];
            }
        }
//        dd($estimate);
        $data = array();
        $data['works'] = $works;
        //        Данные из документа по ремонту
        $repair = Repair::where('estimate', $estimate->id)->first();
        $data['d_number'] = $repair->id;
        $data['d_date'] = $repair->created_at;
        $data['manager'] = $repair->manager;
        $data['time'] = $repair->termContract;
        //        Данные из документа по ремонту
        $data['doc_number'] = $estimate->id;
        $data['date'] = $estimate->created_at;
        $data['Rationale'] = $estimate->Rationale;
        $data['estimate.clientID'] = Client::find($estimate->clientID)->name;
        $data['estimate.objectAddress'] = $estimate->objectAddress;
        $data['objectSquare'] = $estimate->floorArea.' м2';
        $data['estimate_summary'] = $estimate->summaryPrice;
        $request->merge(['data' => $data]);
        $request->merge(['templateId' => 10]);
        $stream = new InvoiceController;
        return $stream->makedoc($request);
    }

    public function printMaster (Estimate $estimate, Request $request) {
        $works = collect($request->get('works'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $additionalWorks = collect($request->get('additionalWorks'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $summprice = 0;

        foreach ($works as &$block) {
            foreach ($block as &$row) {
                $elem = RepairPriceList::where('workName', '=', $row['work'])->first();
                $row['price'] = $elem->masterPrice * $row['volume'];
                $summprice = $summprice + $row['price'];
//                echo $row['work'];
            }
        }

        foreach ($additionalWorks as &$block) {
            foreach ($block as &$row) {
                $row['price'] = $row['masterPrice'] * $row['volume'];
                $summprice = $summprice + $row['price'];
            }
        }
//        dd($estimate);
        $data = array();
        $data['works'] = $works;
        //        Данные из документа по ремонту
        $repair = Repair::where('estimate', $estimate->id)->first();
        $data['d_number'] = $repair->id;
        $data['d_date'] = $repair->created_at;
        $data['manager'] = $repair->manager;
        $data['time'] = $repair->termContract;
        //        Данные из документа по ремонту
        $data['doc_number'] = $estimate->id;
        $data['date'] = $estimate->created_at;
        $data['Rationale'] = $estimate->Rationale;
        $data['estimate.clientID'] = Client::find($estimate->clientID)->name;
        $data['estimate.objectAddress'] = $estimate->objectAddress;
        $data['objectSquare'] = $estimate->floorArea.' м2';
        $data['estimate_summary'] = $estimate->summaryPrice;
        $request->merge(['data' => $data]);
        $request->merge(['templateId' => 10]);
        $stream = new InvoiceController;
        return $stream->makedoc($request);
    }

    /**
     * @param Estimate $estimate
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Estimate $estimate, Request $request)
    {
        $works = collect($request->get('works'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $additionalWorks = collect($request->get('additionalWorks'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $summprice = 0;

        foreach ($works as &$block) {
            foreach ($block as &$row) {
                $elem = RepairPriceList::where('workName', '=', $row['work'])->first();
                $row['price'] = $elem->foremanPrice * $row['volume'];
                $summprice = $summprice + $row['price'];
            }
        }

        foreach ($additionalWorks as &$block) {
            foreach ($block as &$row) {
                $row['price'] = $row['masterPrice'] * $row['volume'];
                $summprice = $summprice + $row['price'];
            }
        }

        $estimate->summaryPrice = $summprice - ($summprice * $estimate->discounts / 100);

        $estimate->works = $works;
        $estimate->additionalWorks = $additionalWorks;



        $estimate
            ->fill($request->get('estimate'))
            ->save();
        if (!$estimate->wasRecentlyCreated) {
            $changes = $estimate->getChanges();
            $docData['d_number'] = $estimate->id;
            $docData['d_date'] = $estimate->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['works'] = $changes['works'];
            $docData['sumPrice'] = $changes['summaryPrice'];
            $doc = Document::firstOrCreate(
                ['number' => $estimate->id.'020'],
                ['templateId' => 10, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('ДС изменения работ создано'));
        }

        Alert::info('Смета готова');

        return redirect()->route('platform.estimate.list');
    }


    /**
     * @param Estimate $estimate
     * @return RedirectResponse
     * @throws Exception
     */
    public function remove(Estimate $estimate)
    {
        $estimate->delete();

        Alert::info('Смета удалена');

        return redirect()->route('platform.estimate.list');
    }
}
