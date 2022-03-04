<?php

namespace App\Orchid\Screens\Design;

use App\Models\Design;
use App\Orchid\Layouts\Design\DesignsListTableLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class DesingListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Дизайн';

    public $permission = [
        'platform.design.list'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Проектные работы - дизайну';

    public $exists = false;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'designs' => Design::filters()->defaultSort('id')->paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать договор на разработку дизайн проекта')
                ->icon('pencil')
                ->route('platform.design.edit')
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
            DesignsListTableLayout::class
        ];
    }



}
