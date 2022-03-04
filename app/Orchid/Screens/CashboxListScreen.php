<?php

namespace App\Orchid\Screens;

use App\Models\Cashbox;
use App\Models\Documents;
use App\Orchid\Layouts\DocumentsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CashboxListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Кассы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список касс';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        {
            return [
                'documents' => Cashbox::filters()->defaultSort('id')->paginate()
            ];
        }
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить документ')
                ->icon('pencil')
                ->route('platform.documents.edit')
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
}
