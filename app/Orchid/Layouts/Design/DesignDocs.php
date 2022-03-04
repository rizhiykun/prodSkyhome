<?php

namespace App\Orchid\Layouts\Design;

use App\Models\Client;
use App\Models\Design;
use App\Models\Document;
use App\Models\Tariff;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class DesignDocs extends Rows
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
        $doc = Document::where('number', $this->query->get('design')->id)->first();
        $status =  isset($doc) ? $doc->status : 'none';
//        dd($status);
        return [
            Group::make([
                Button::make(__('Скачать шаблон договора для подписи сторонами'))
                    ->method('print')
                    ->icon('cloud-download')
                    ->canSee($status == 'approved')
                    ->rawClick()
                    ->parameters([
                        'id' => $this->query->get('design')->id,
                        'document_number' => $this->query->get('design')->id,
                        'data' => $this->query->get('design')->data,
                        'templateId' => $this->query->get('design')->templateId,

                        //'templateId' => $this->query->get('templateId')->templateId,
                    ]),
                Upload::make('design.attachment')
                    ->title('Подписанный договор')
                    ->canSee($status == 'approved')
                    ->groups('design_document')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'design_document'))
                    ->help('Загрузите подписанный Договор - файл pdf')
                    ->acceptedFiles('application/pdf'),
            ]),

        ];
    }
}
