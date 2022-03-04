<?php

namespace App\Orchid\Screens;

use App\Models\Document;
use App\Orchid\Layouts\DocumentEditTableLayout;
use App\Orchid\Layouts\DocumentsListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class DocumentsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Документ';

    public $permission = [
        'platform.docs.edit'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Просмотр документа';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Document $document): array
    {
//        dd($document);
        return ['document' => $document];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Согласовать')
                ->icon('pencil')
                ->method('update'),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove'),
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
            \Orchid\Support\Facades\Layout::rows([
                Matrix::make('document.data')
                    ->title('Данные'),
            ])
        ];

    }


    public function approve(Document $document) {

    }

    /**
     * @param Document $document
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Document $document): \Illuminate\Http\RedirectResponse
    {
        $document->delete();

        Alert::info('Документ удален');

        return redirect()->route('platform.documents.list');
    }
}
