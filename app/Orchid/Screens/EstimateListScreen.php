<?php

namespace App\Orchid\Screens;

use App\Models\Estimate;
use App\Orchid\Layouts\EstimateListTable;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class EstimateListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Сметы';
    public $permission = [
        'platform.estimate.list'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Экран со списком смет';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'estimates' => Estimate::filters()->defaultSort('id')->paginate()
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
            Link::make('Добавить смету')
                ->icon('pencil')
                ->route('platform.estimate.edit')
        ];
    }

    /**
     * Views.
     *
     * @return string[]|Layout[]
     */
    public function layout(): array
    {
        return [
            EstimateListTable::class
        ];
    }
}
