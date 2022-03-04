<?php

namespace App\Orchid\Layouts\Design;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DesignDocE3 extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Group::make([
                Button::make(__('Скачать шаблон документа для подписи сторонами'))
                    ->method('print')
                    ->icon('cloud-download')
                    ->rawClick()
                    ->parameters([
                        'design_id' => $this->query->get('design')->id,
                        'document_number' => $this->query->get('design')->id.'03',
                        'type' => 'act3'
                    ]),
                Upload::make('design.attachment')
                    ->title('Подписанный акт этапа 3')
                    ->groups('e3_act')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_act'))
                    ->help('Загрузите подписанный акт - файл pdf')
                    ->acceptedFiles('application/pdf'),
            ]),

        ];
    }
}
