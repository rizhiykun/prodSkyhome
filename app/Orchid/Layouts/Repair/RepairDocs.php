<?php

namespace App\Orchid\Layouts\Repair;

use App\Models\Document;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class RepairDocs extends Rows
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
        $doc = Document::where('number', $this->query->get('repair')->id)->first();
        return [
            Group::make([
                Button::make(__('Скачать шаблон договора для подписи сторонами'))
                    ->method('print')
                    ->icon('cloud-download')
                    ->rawClick()
                    ->parameters([
                        'id' => $this->query->get('repair')->id,
                        'document_number' => $this->query->get('repair')->id,
                        'data' => $this->query->get('repair')->data,
                        'templateId' => $this->query->get('repair')->templateId,
                    ]),

                Upload::make('repair.attachment')
                    ->title('Подписанный договор')
                    ->groups('act')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'act'))
                    ->help('Загрузите подписанный договор - файл pdf')
                    ->acceptedFiles('application/pdf'),
            ]),
            Group::make([
            ])
        ];
    }
}
