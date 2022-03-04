<?php

namespace App\Orchid\Screens;

use App\Models\Pricelistitem;
use App\Orchid\Layouts\PriceListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class PriceListScreenTest extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Прайслистытест';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Страница отображает прайслистытест';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'Items' => Pricelistitem::paginate()
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
            Link::make('Добавить позициютест')
                ->icon('pencil')
                ->route('platform.price.edit')
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
            PriceListLayout::class
        ];
    }
}
