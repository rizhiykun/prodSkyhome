<?php

namespace App\Orchid\Layouts;

use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Estimate;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DocumentsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'document';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'Системный ID')
                ->sort(),
            TD::make('templateId', 'Из шаблона')
                ->render(
                    function (Document $document) {
                        $tpl = DocumentTemplate::find($document->templateId);
                        $name = $tpl->name;
                        if ($document->templateId == "11" or $document->templateId == "12"){
                            return Link::make($name)
                                ->route('platform.repair.edit', $document->number
                                );}
                        else {
                            return Link::make($name)
                                ->route('platform.design.edit', $document->number
                                );
                        }
                    }
                )->sort(),
            TD::make('number', 'Номер')
                ->render(function (Document $document) {

                    return Link::make($document->number)
                        ->route('platform.design.edit', $document->number
                        );

                })->sort(),
            TD::make('created_at', 'Создан')
                ->render(fn ($value) => date('d.m.Y h:i', strtotime($value->created_at)))->sort(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('50px')
                ->render(function (Document $document) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Button::make('Согласовать')
                                ->icon('like')
                                ->method('approve')
                                ->rawClick()
                                ->parameters([
                                    'id' => $document->id,
                                ]),

                            Button::make('Посмотреть')
                                ->icon('eye')
                                ->method('print')
                                ->rawClick()
                                ->parameters([
                                    'id' => $document->id,
                                    'data' => $document->data,
                                    'templateId' => $document->templateId
                                ]),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->method('remove')
                                ->confirm('Шаблон удален')
                                ->parameters([
                                    'id' => $document->id,
                                ]),
                        ]);
                }),
        ];
    }
}
