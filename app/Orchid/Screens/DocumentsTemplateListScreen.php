<?php

namespace App\Orchid\Screens;

use App\Models\DocumentTemplate;
use App\Orchid\Layouts\DocumentTemplateListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DocumentsTemplateListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Шаблоны документов';
    public $permission = [
        'platform.templates.list'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Экран для редактирования шаблонов документов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'DocumentTemplates' => DocumentTemplate::filters()->paginate()
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
            Link::make('Добавить шаблон')
                ->icon('pencil')
                ->route('platform.documentsTemplate.edit')
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
            DocumentTemplateListLayout::class
        ];
    }
}
