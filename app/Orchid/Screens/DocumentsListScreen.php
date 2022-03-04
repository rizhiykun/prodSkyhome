<?php

namespace App\Orchid\Screens;

use App\Http\Controllers\InvoiceController;
use App\Models\Document;
use App\Orchid\Layouts\DocumentsListLayout;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class DocumentsListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Документы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Экран со списком документов';

    public $permission = [
        'platform.docs.list'
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'document' => Document::filters()->defaultSort('created_at','desc')->paginate()
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
            DocumentsListLayout::class
        ];
    }

    /**
     * @param Request $request
     */
    public function print(Request $request)
    {
        $stream = new InvoiceController;
        return $stream->makedoc($request);
    }

    /**
     * @param Request $request
     */
    public function approve(Request $request)
    {
        $docId = $request->get('id');
        $doc = Document::find($docId);
        $doc->status = 'approved';
        $doc->update();
        Toast::info('Документ согласован');
    }


    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        Document::findOrFail($request->get('id'))
            ->delete();

        Toast::info('Документ удален');
    }
}
