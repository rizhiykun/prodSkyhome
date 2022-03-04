<?php

namespace App\Orchid\Layouts;

use App\Models\DocumentTemplate;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DocumentTemplateListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'DocumentTemplates';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Название')
                ->width(100)
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (DocumentTemplate $documentTemplate) {
                    return Link::make($documentTemplate->name)
                        ->route('platform.documentsTemplate.edit', $documentTemplate);
                })
                ->cantHide(),
             TD::make('created_at', 'Создан'),
             TD::make('updated_at', 'Изменен'),
        ];
    }
}
