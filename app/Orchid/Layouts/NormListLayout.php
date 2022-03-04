<?php

namespace App\Orchid\Layouts;

use App\Models\NormsList;
use App\Models\RepairPriceList;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NormListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'NormsList';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', '№')
                ->width('20px')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (NormsList $NormsList) {
                    return Link::make($NormsList->id)
                        ->route('platform.norms.edit', $NormsList);
                }),
            TD::make('name', 'Работы')
                ->width('600px')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (NormsList $NormsList) {
                    return RepairPriceList::find($NormsList->WorkID)->workName;

                }),
            TD::make('supply', 'Материалы')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->width('400px')
                ->render(function (NormsList $NormsList) {
                    $string = "";
                    foreach ($NormsList->supply as $supply) {
                        foreach ($supply as $key => $value) {
                            if ($key == 'Material') { $string = $string.(" Материал - {$value}"."<br/>"); } //else {$string =
                        }
                    };
                    return $string;
                }),
            TD::make('supply', 'Кол-во')
                ->render(function (NormsList $NormsList) {
                    $string = "";
                    foreach ($NormsList->supply as $supply) {
                        foreach ($supply as $key => $value) {
                            if ($key == 'quantity') {
                                $string = $string . ("{$value}<br/>");
                            }
                        }
                    }

                    return $string;
                          }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (NormsList $NormsList) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.norms.edit', $NormsList->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm(__('Как только норма будет удалена, все ее ресурсы и данные будут удалены безвозвратно. Перед удалением вашей нормы, пожалуйста, загрузите любые данные или информацию, которые вы хотите сохранить.'))
                                ->parameters([
                                    'id' => $NormsList->id,
                                ]),
                        ]);
                }),
        ];
    }
    protected function striped(): bool
    {
        return true;
    }
}
