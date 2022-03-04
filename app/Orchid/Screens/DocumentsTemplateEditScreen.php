<?php

namespace App\Orchid\Screens;

use App\Models\DocumentTemplate;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\App;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Barryvdh\DomPDF\Facade as PDF;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;

class DocumentsTemplateEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Шаблоны документов';
    public $permission = [
        'platform.templates.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Создание и редактирование шаблонов документов';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(DocumentTemplate $documentTemplate): array
    {
        $this->exists = $documentTemplate->exists;

        if($this->exists){
            $this->name = 'Редактировать';
        }

        $docParams = $documentTemplate->docParams;


        return [
            'documentTemplate' => $documentTemplate,
            'docParams' => $docParams
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
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

            Button::make('Сгенерировать документ')
                ->icon('printer')
                ->rawClick()
                ->method('print')
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
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('documentTemplate.name')
                    ->title('Название')
                    ->required()
                    ->placeholder('Название для шаблона'),

                Quill::make('documentTemplate.template')
//                    ->toolbar(["text", "color", "header", "list", "format", "media"])
                    ->required()
                    ->title('Шаблон'),

                Matrix::make('docParams')
                    ->columns([
                        'Атрибут' => 'attr',
                        'Тестовое значение' => 'testVal',
                    ])
            ])
        ];
    }

    public function createOrUpdate(DocumentTemplate $documentTemplate, Request $request)
    {
        $docParams = collect($request->get('docParams'))
            ->map(function ($value, $key) {
                return [$key => $value];
            })
            ->collapse()
            ->toArray();

        $documentTemplate->docParams = $docParams;


        $documentTemplate
            ->fill($request->get('documentTemplate'))
            ->save();

        $file = base_path('resources/views/templates/'.$documentTemplate->id.'.blade.php');
        $header = '<!DOCTYPE html><html>
                    <head>
                        <title>'.$documentTemplate->id.'</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <style>
                        body {
                                font-family: DejaVu Sans;
                                font-size: 18px;
                        }
                    </style>
                    </head>
                    <body><div style="width: 100%; max-width: 960px; margin: auto">';
        $footer = '<table style="page-break-before: always;" width=100%>
        <tr>
            <td style="padding-bottom: 30px" width="50%" align=center>Заказчик</td>
            <td style="padding-bottom: 30px" width="50%" align=center>Исполнитель</td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <div style="padding-left: 10px;">{!! $data[\'client\'] !!}</div>
            </td>
            <td valign="top" width="50%">
                <div style="padding-left: 10px;">{!! $data[\'company\'] !!}</div>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding-top: 30px;">___________________/_____________/</td>
            <td width="50%" style="padding-top: 30px;">___________________/_____________/</td>
        </tr>
    </table></div></body></html>';
        file_put_contents($file, $header.$documentTemplate->template.$footer);

        Alert::info('Шаблон обновлен');

        return redirect()->route('platform.documentsTemplate.list');
    }


    /**
     * @param DocumentTemplate $documentTemplate
     */
    public function remove(DocumentTemplate $documentTemplate)
    {
        $documentTemplate->delete();

        Alert::info('Шаблон документа удален');

        return redirect()->route('platform.documentsTemplate.list');
    }

    /**
     * @param DocumentTemplate $documentTemplate
     */
    public function print(DocumentTemplate $documentTemplate) {
        $data = array_column($documentTemplate->docParams, 'testVal', 'attr');
        return $pdf = PDF::loadView('templates.'.$documentTemplate->id, compact('data'))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'dejavu sans'])
            ->stream($documentTemplate->id . '.pdf');
//        Alert::info('Тестовый шаблон '.$documentTemplate->id . '.pdf создан');
    }
}
