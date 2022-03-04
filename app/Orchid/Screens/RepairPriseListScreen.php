<?php

namespace App\Orchid\Screens;

use App\Models\Dataset;
use App\Models\RepairPriceList;
use App\Models\RepairType;
use App\Orchid\Layouts\RepairPriceListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class RepairPriseListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Прайс-лист Ремонт';
    public $permission = [
        'platform.repair_price_list.list'
    ];

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список позиций по ремонту';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'plItem' => RepairPriceList::paginate(50)
        ];
    }

    public function updatePrice()
    {
//        Get params
        $overprice = Dataset::find(1);
        $overprice = $overprice->overprice;

        foreach (RepairType::lazy() as $type) {
            $prices = RepairPriceList::where('workGroup', $type->id)->get();
            foreach ($prices as $price) {
                $price->foremanPrice = $price->masterPrice * ($type->markup / 100);
                $price->basePrice = $price->masterPrice * (1 + $overprice / 100);
                $price->discountPrice = $price->basePrice * (1 - $price->discount / 100);
                $price->save();
            }
        }

    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить позицию')
                ->icon('pencil')
                ->route('platform.repPrice.edit'),
            Button::make('Пересчитать цены')
                ->icon('brush')
                ->method('updatePrice')
                ->canSee(Auth::user()->inRole('admin')),
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
            RepairPriceListLayout::class
        ];
    }
}
