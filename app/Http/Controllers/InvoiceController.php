<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\DocumentTemplate;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class
InvoiceController extends Controller
{

    public function makedoc(Request $request)
    {
        $data = $request->get('data');
        return $pdf = PDF::loadView('templates.' .$request->get('templateId'), compact('data'))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'dejavu sans'])
            ->stream($request->get('templateId').'_document.pdf');
    }

    public function printDocument(Request $request)
    {
        $designId = $request->get('design_id' or 'id');
        $type = $request->get('type');
        $document_number = $request->get('document_number');
        $document = Document::where('number', '=', $document_number)->first();
        //dd($document);
        $data = $document->data;
        $tplId = $document->templateId;
        $tpl = DocumentTemplate::find($tplId);
        return $pdf = PDF::loadView('templates.'.$tplId, compact('data'))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'dejavu sans'])
            ->download($tpl->name.'.pdf');
    }

}
