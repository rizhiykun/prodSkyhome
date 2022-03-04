<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Models\Design;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LCprojectsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Мои документы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Мои документы';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $client = Client::where('email', '=', Auth::user()->email)->first();
        $design = Design::where('person', '=', $client->id)->first();

        return [
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

    public function download (Request $request)
    {
        $fp = $request->get('fp');
        $name = $request->get('name');
        $pathToFile=storage_path()."/app/public/".$fp;
        return response()->download($pathToFile, $name);
    }

    public function getBlocks() {
        $retVal = array();
        $client = Client::where('email', '=', Auth::user()->email)->first();
        $design = Design::where('person', '=', $client->id)->first();
        $repair = Repair::where('person', '=', $client->id)->first();
        $signedDocs = Array();
        $unsignedDocsDesign = array();
        $unsignedDocsRepair = array();

        if (isset($design)) {
            $desAttach = $design->attachment()->get();
            if (isset($desAttach)) {
                foreach ($desAttach as $unsignedDoc) {
                    array_push($unsignedDocsDesign, [$unsignedDoc->group, $unsignedDoc->path.$unsignedDoc->name.'.'
                        .$unsignedDoc->extension,
                        $unsignedDoc->original_name]);
                }
            }
        }

        if (isset($repair)) {
            $repAttach = $repair->attachment()->get();
            if (isset($repAttach)) {
                foreach ($repair->attachment()->get() as $unsignedDoc) {
                    array_push($unsignedDocsRepair, [$unsignedDoc->group, $unsignedDoc->path.$unsignedDoc->name.'.'
                        .$unsignedDoc->extension,
                        $unsignedDoc->original_name]);
                }
            }
        }


        $genTabs = function (array $documents) {
            $docs = array();
            foreach ($documents as $doc) {
                $docs[$doc['2']] = [
                    Layout::rows([
                        Group::make([
                            Button::make(__('Скачать документ для подписи'))
                                ->method('download')
                                ->icon('cloud-download')
                                ->rawClick()
                                ->parameters([
                                    'fp' => $doc['1'],
                                    'name' => $doc['2'],
                                ]),
                            Upload::make('design.attachment')
                                ->title('Подписанный акт этапа 1')
                                ->groups('signed_' . $doc['0'])
                                ->maxFiles(1)
                                ->help('Загрузите подписанный документ - файл pdf')
                                ->acceptedFiles('application/pdf'),
                        ])
                    ])
                ];
            }
            return $docs;
        };

        if (count($unsignedDocsDesign) > 0 ) {
            $retVal['Неподписанные документы по Дизайну'] = [
                Layout::accordion($genTabs($unsignedDocsDesign)),
            ];
        }

        if (count($unsignedDocsRepair) > 0 ) {
            $retVal['Неподписанные документы по Ремонту'] = [
                Layout::accordion($genTabs($unsignedDocsRepair)),
            ];
        }

        return $retVal;
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs(
                $this->getBlocks()
            )
        ];
    }
}
