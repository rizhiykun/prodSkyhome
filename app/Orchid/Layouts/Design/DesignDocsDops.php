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

class DesignDocsDops extends Rows
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
                Button::make(__('Скачать шаблон дс на изменение площади для подписи сторонами'))
                    ->method('print')
                    ->icon('cloud-download')
                    ->rawClick()
                    ->canSee(Document::where('number', '=', $this->query->get('design')->id.'09')->count() > 0)
                    ->parameters([
                        'design_id' => $this->query->get('design')->id,
                        'document_number' => $this->query->get('design')->id.'09',
                        'type' => 'dc'
                    ]),
                Upload::make('design.attachment')
                    ->title('Подписанные договор')
                    ->groups('design_document_dop')
                    ->maxFiles(1)
                    ->canSee(Document::where('number', '=', $this->query->get('design')->id.'09')->count() > 0)
                    ->value(fn($value = []) => collect($value)->where('group', 'design_document_dop'))
                    ->help('Загрузите подписанный Договор - файл pdf')
                    ->acceptedFiles('application/pdf'),
            ]),

            Group::make([
                Button::make(__('Скачать шаблон дс на изменение сроков для подписи сторонами'))
                    ->method('print')
                    ->icon('cloud-download')
                    ->rawClick()
                    ->canSee(Document::where('number', '=', $this->query->get('design')->id.'08')->count() > 0)
                    ->parameters([
                        'design_id' => $this->query->get('design')->id,
                        'document_number' => $this->query->get('design')->id.'08',
                        'type' => 'dc'
                    ]),
//                Button::make(__('Скачать шаблон дс на создание личного кабинета для подписи сторонами'))
//                    ->method('print')
//                    ->icon('cloud-download')
//                    ->parameters([
//                    ]),
                Upload::make('design.attachment')
                    ->title('Подписанные договор')
                    ->groups('design_document_dop_date')
                    ->canSee(Document::where('number', '=', $this->query->get('design')->id.'08')->count() > 0)
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'design_document_dop_date'))
                    ->help('Загрузите подписанный Договор - файл pdf')
                    ->acceptedFiles('application/pdf'),
            ]),

        ];
    }
}
