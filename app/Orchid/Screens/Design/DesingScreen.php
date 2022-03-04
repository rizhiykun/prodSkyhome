<?php /** @noinspection ALL */

namespace App\Orchid\Screens\Design;

use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Design;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Entities;
use App\Models\Tariff;
use App\Models\User;
use App\Orchid\Layouts\Design\DesignDocs;
use App\Orchid\Layouts\Design\DesignDocsDops;
use Auth;
use App\Orchid\Layouts\Clients\ClientAddEnt;
use App\Orchid\Layouts\Clients\ClientAddFiz;
use App\Orchid\Layouts\Design\DesignClient;
use App\Orchid\Layouts\Design\DesignDocE1;
use App\Orchid\Layouts\Design\DesignDocE2;
use App\Orchid\Layouts\Design\DesignDocE3;
use App\Orchid\Layouts\Design\DesignDocE4;
use App\Orchid\Layouts\Design\DesignE1;
use App\Orchid\Layouts\Design\DesignE2;
use App\Orchid\Layouts\Design\DesignE3;
use App\Orchid\Layouts\Design\DesignE4;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Array_;

class DesingScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новый Дизайн';

    public $permission = [
        'platform.design.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Новый Проект по дизайну';


    /**
     * @var bool
     */
    public $exists = false;


    /**
     * Query data.
     *
     * @param Design $design
     * @return array
     */
    public function query(Design $design): array
    {
        $this->exists = $design->exists;
        $design->load('attachment');
        $data = $design->data;


        if($this->exists){
            $this->name = 'Редактировать';
            $this->tariff = Tariff::find($design->objectTariff);

            $docs = array(
                'Договор' => [DesignDocs::class],
                'Документы по Этапу 1' => [DesignDocE1::class],
                'Документы по Этапу 2' => [DesignDocE2::class],
                'Документы по Этапу 3' => [DesignDocE3::class],
                'Документы по Этапу 4' => [DesignDocE4::class],
                'Дополнительные Соглашения' => [DesignDocsDops::class]
            );

            if (!isset($data['e1_fact_date'])) { unset($docs['Документы по Этапу 1']); };
            if (!isset($data['e2_fact_date'])) { unset($docs['Документы по Этапу 2']); };
            if (!isset($data['e3_fact_date'])) { unset($docs['Документы по Этапу 3']); };
            if (!isset($data['e4_fact_date'])) { unset($docs['Документы по Этапу 4']); };



            $taps = array(
                'Этап 1' => [DesignE1::class],
                'Этап 2' => [DesignE2::class],
                'Этап 3' => [DesignE3::class],
                'Этап 4' => [DesignE4::class],
            );

            if (!isset($data['e1_fact_date'])) { unset($taps['Этап 2']); };
            if (!isset($data['e2_fact_date'])) { unset($taps['Этап 3']); };
            if (!isset($data['e3_fact_date'])) { unset($taps['Этап 4']); };

            $this->docs = $docs;
            $this->taps = $taps;
        }



        return [
            'design' => $design,
            'data' => $data,
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
//            Button::make('Тестировочная кнопка')
//                ->icon('edit')
//                ->method('test'),

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

    /**
     * Views.
     *
     * @return string[]|Layout[]
     */
    public function layout(): array
    {
        return
            [
                Layout::modal('client_edit_ent', ClientAddEnt::class)
                    ->title('Клиент')
                    ->async('asyncGetClient')
                    ->applyButton('Сохранить')
                    ->closeButton('Закрыть'),
                Layout::modal('client_edit_fiz', ClientAddFiz::class)
                    ->title('Клиент ФизЛицо')
                    ->async('asyncGetClient')
                    ->applyButton('Сохранить')
                    ->closeButton('Закрыть'),
                !$this->exists ? DesignClient::class :
                    Layout::tabs([
                        'Основные  Данные' => [
                            DesignClient::class
                        ],
                        'Документы' => [
                            Layout::accordion($this->docs),
                        ],
                        'Дизайн' => [
                            Layout::accordion($this->taps),
                        ],
                    ]),
            ];
    }


    /**
     * @param Design $design
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Design $design, Client $client, Request $request)
    {
        $original = clone $design;
        $data = collect($request->get('data'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $design->data = $data;


        $design
            ->fill($request->get('design'))
            ->save();

        $client = Client::find($design->person);
        $company = Entities::find($design->ourCompany);
        $docData['client'] = strlen($client->inn) > 0 ? $client->name.'<br>'.
            "Адрес: ".$client->inn.'<br>'.
            "ИНН: ".$client->inn.'<br>'.
            "КПП: ".$client->kpp.'<br>'.
            "ОГРН: ".$client->ogrn.'<br>'.
            "р/сч: ".$client->req.'<br>'.
            "Банк: ".$client->bank.'<br>'.
            $client->real_address.'<br>' :
            "Паспорт: ".$client->passport.'<br>'.
            "Адрес: ".$client->real_address.'<br>'.
            "Телефон: ".$client->phone.'<br>'.
            "E-mail: ".$client->email;

        $docData['company'] = $company->organizationNameFull.'<br>'.
            "Адрес: ".$company->addressReal.'<br>'.
            "ИНН: ".$company->inn.'<br>'.
            "КПП: ".$company->kpp.'<br>'.
            "ОГРН: ".$company->ogrn.'<br>'.
//            "р/сч: ".$company->requisites.'<br>'.
            "Банк: ".$company->bankDetails.'<br>';

        if (!$this->exists) {
            $tarrif = Tariff::find($design->objectTariff);
            $tpl = DocumentTemplate::find($tarrif->mainTemplateId);
            $client = Client::find($design->person);
            $docData['number'] = $design->id;
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $docData['address'] = $design->objectAddress;
            $docData['daysToWork'] = $design->objectData;
            $docData['square'] = $design->objectSquare;
            $docData['price'] = $design->objectSquare * $tarrif->price;

            $doc = Document::firstOrCreate(
                ['number' => $design->id],
                ['templateId' => $tpl->id, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );

        }

        $design->attachment()->syncWithoutDetaching(
            $request->input('design.attachment', [])
        );

        if (isset($data['e1_fact_date']) and Document::where('number', '=', $design->id.'01')->count() == 0) {
            $docData['d_number'] = $design->id;
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'01'],
                ['templateId' => 4, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Акт 1 создан\обновлен'));
        }

        if (isset($data['e2_fact_date']) and Document::where('number', '=', $design->id.'02')->count() == 0) {
            $docData['d_number'] = $design->id;
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'02'],
                ['templateId' => 5, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Акт 2 создан\обновлен'));
        }

        if (isset($data['e3_fact_date']) and Document::where('number', '=', $design->id.'03')->count() == 0) {
            $docData['d_number'] = $design->id;
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'03'],
                ['templateId' => 6, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Акт 3 создан\обновлен'));
        }

        if (isset($data['e4_fact_date']) > 0 and Document::where('number', '=', $design->id.'04')->count() == 0) {
            $docData['d_number'] = $design->id;
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'04'],
                ['templateId' => 7, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Акт 4 создан\обновлен'));
        }

        if ($design->wasChanged('objectSquare')) {
            $docData['d_number'] = $design->id;
            $docData['doc_number'] = '1';
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $docData['add_square'] = $design->objectSquare-$original->objectSquare;
            $docData['square'] = $design->objectSquare;
            $docData['add_cost'] = ($design->objectSquare-$original->objectSquare)*$tarrif->price;
            $docData['cost'] = ($design->objectSquare)*$tarrif->price;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'09'],
                ['templateId' => 9, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Дс на изменение площади создан'));
        }

        if ($design->wasChanged('objectData')) {
            $docData['d_number'] = $design->id;
            $docData['doc_number'] = '1';
            $docData['d_date'] = $design->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $docData['additional_days'] = $design->objectData-$original->objectData;
            $doc = Document::firstOrCreate(
                ['number' => $design->id.'08'],
                ['templateId' => 8, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Дс на изменение сроков создан'));
        }


        Alert::info('Дизайн создан');
        if ($design->wasChanged('objectSquare')) {
            Toast::info(__('Площадь изменилась'));
        };

        return redirect()->route('platform.design.list');
    }

    public function asyncGetClient(Client $client) {
        return [
            'client' => $client
        ];
    }

    public function asyncSaveClient(Client $client, Request $request) {
        $client
            ->fill($request->input('client'))
            ->save();
        Toast::info(__('Клиент обновлен'));

    }

    public function test(Request $request) {
        ddd(User::with(['roles'])->whereHas('roles', function (Builder $query) {
            $query->where('slug', 'designer');
        })->get());
    }

    /**
     * @param Request $request
     */
    public function print(Request $request)
    {
        $stream = new InvoiceController;
        return $stream->printDocument($request);
    }

    /**
     * @param Design $design
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Design $design)
    {
        $design->delete();

        Alert::info('Дизайн удален');

        return redirect()->route('platform.design.list');
    }
}
