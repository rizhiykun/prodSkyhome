<?php

namespace App\Orchid\Screens\Repair;

use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Entities;
use App\Models\Estimate;
use App\Models\Repair;
use App\Models\Tariff;
use Orchid\Screen\Fields\Input;
use App\Orchid\Layouts\Clients\ClientAddEnt;
use App\Orchid\Layouts\CreateOrUpdateUser;
use App\Orchid\Layouts\EstimateUpdateResources;
use App\Orchid\Layouts\Repair\RepairDocFinish;
use App\Orchid\Layouts\Repair\RepairDocs;
use App\Orchid\Layouts\Repair\RepairDocDops;
use App\Orchid\Layouts\RepairListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use App\Orchid\Layouts\Repair\RepairCreate;
use Orchid\Support\Facades\Toast;

class RepairScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новый ремонт';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Новый проект по ремонту';
    public $exists = false;

    public $permission = [
        'platform.repair.edit'
    ];
    private $docs;

    /**
     * Query data.
     *
     * @param Repair $repair
     * @return array
     */
    public function query(Repair $repair): array
    {
        $this->exists = $repair->exists;
        $repair->load('attachment');
        $data = $repair->data;


        //Create accordion tabs in "Documents" tab
        if($this->exists) {
            $this->name = 'Редактировать';
            $this->tariff = Tariff::find($repair->objectTariff);
            $docs = array(
                'Договор' => [RepairDocs::class],
                'Дополнительные Соглашения' => [RepairDocDops::class],
                'Акты' => [RepairDocFinish::class]


            );
            $this->docs = $docs;
        }

        return [
            'repair' => $repair,
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
               // RepairListener::class,
               Layout::modal('client_edit', [ClientAddEnt::class])
                    ->title('Клиент')
                    ->async('asyncGetClient')
                    ->applyButton('Сохранить')
                    ->closeButton('Закрыть'),
                //Layout::modal('estimate_edit', [EstimateUpdateResources::class])
                //   ->title('Ресурсы')
                //    ->async('asyncGetEstimate')
                //    ->applyButton('Сохранить')
                //    ->closeButton('Закрыть'),
                !$this->exists ? RepairCreate::class :
                //!$this->exists ? RepairListener::class :
                    Layout::tabs([
                        'Основные  Данные' => [RepairCreate::class],
                        'Документы' => [Layout::accordion($this->docs)],


                 ]),

                ];
    }

    /**
     * @param Repair $repair
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Repair $repair, Request $request)
    {
        $original = clone $repair;
        $data = collect($request->get('data'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();
        $repair->data = $data;
        $repair
            ->fill($request->get('repair'))
            ->save();

        //Harvest client and our company data
        $client = Client::find($repair->person);
        $company = Entities::find($repair->company);
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
            "E-mail: ".$client->mail;
        $docData['company'] = $company->organizationNameFull.'<br>'.
            "Адрес: ".$company->addressReal.'<br>'.
            "ИНН: ".$company->inn.'<br>'.
            "КПП: ".$company->kpp.'<br>'.
            "ОГРН: ".$company->ogrn.'<br>'.
            "р/сч: ".$company->requisites.'<br>'.
            "Банк: ".$company->bankDetails.'<br>';


        //Harvest data to main contract
        if (!$this->exists) {
            $tarrif = Tariff::find($repair->tariff);
            $tpl = DocumentTemplate::find($tarrif->mainTemplateId);
            $client = Client::find($repair->person);
            $estimate = Estimate::find($repair->estimate);
            $docData['number'] = $repair->id;
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $docData['obj_address'] = $estimate->objectAddress;
            $docData['workdays'] = $repair->termContract;
            $docData['obj_square'] = $repair->objectSquare;
            $docData['tariff'] = $repair->tarrif;
            $docData['price'] = $repair->objectSquare * $tarrif->price;
            $docData['deposit'] = $repair->deposit;

            $doc = Document::firstOrCreate(
                ['number' => $repair->id],
                ['templateId' => $tpl->id, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );

        }
        $repair->attachment()->syncWithoutDetaching(
            $request->input('repair.attachment', [])
        );

        //Harvest data for transfer acceptance certificate
        if (!$this->exists) {
            $the_date = strtotime($repair->updated_at);
            $tarrif = Tariff::find($repair->tariff);
            $client = Client::find($repair->person);
            $estimate = Estimate::find($repair->estimate);
            $docData['number'] = $repair->id;
            $docData['date'] = date("m.d.Y",$the_date);
            $docData['creation_date'] = date("m.d.Y");
            $docData['client_name'] = $client->name;
            $docData['address'] = $estimate->objectAddress;
            $docData['client_payments'] = $repair->objectSquare * $tarrif->price;

            $doc = Document::firstOrCreate(
                ['number' => $repair->id.'13'],
                ['templateId' => 13, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );

        }
        //Harvest data for additional agreement to change the area size
        if ($repair->wasChanged('objectSquare')) {
            $docData['d_number'] = $repair->id;
            $docData['doc_number'] = '1';
            $docData['d_date'] = $repair->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.y");
            $docData['clientName'] = $client->name;
            $docData['add_square'] = $repair->objectSquare-$original->objectSquare;
            $docData['square'] = $repair->objectSquare;
            $docData['add_cost'] = ($repair->objectSquare-$original->objectSquare)*$tarrif->price;
            $docData['cost'] = ($repair->objectSquare)*$tarrif->price;
            $doc = Document::firstOrCreate(
                ['number' => $repair->id.'09'],
                ['templateId' => 9, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Дс на изменение площади создан'));
        }
        //Harvest data for additional agreement to changing finish dates
        if ($repair->wasChanged('termContract')) {
            $docData['d_number'] = $repair->id;
            $docData['doc_number'] = '1';
            $docData['d_date'] = $repair->created_at->format('m.d.Y');
            $docData['date'] = date("m.d.Y");
            $docData['clientName'] = $client->name;
            $docData['additional_days'] = $repair->objectData-$original->objectData;
            $doc = Document::firstOrCreate(
                ['number' => $repair->id.'08'],
                ['templateId' => 8, 'status' => 'created', 'data' => $docData, 'creatorId' => ''.Auth::id()]
            );
            Toast::info(__('Дс на изменение сроков создан'));
        }

        Alert::info('Ремонт создан');
        if ($repair->wasChanged('objectSquare')) {
            Alert::info(__('Площадь изменилась'));
        };

        return redirect()->route('platform.repair.list');
    }

    public function asyncSumRepair($disignCoast, $objectSquare)
    {
        return[
            'repair.disignCoast' => $disignCoast,
            'repair.objectSquare' => $objectSquare,
            'sum' => $disignCoast + $objectSquare
        ];
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

    public function asyncGetEstimate(Estimate $estimate) {
        return [
            'estimate' => $estimate
        ];
    }
    public function asyncSaveEstimate(Estimate $estimate, Request $request) {
        $estimate
            ->fill($request->input('estimate'))
            ->save();
        Toast::info(__('Ресурс обновлен'));

    }



    public function print(Request $request)
    {
        $stream = new InvoiceController;
        return $stream->printDocument($request);
    }

    /**
     * @param Repair $repair
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Repair $repair)
    {
        $repair->delete();

        Alert::info('Ремонт удален');

        return redirect()->route('platform.repair.list');
    }

}
