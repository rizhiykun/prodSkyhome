<?php

namespace App\Orchid\Layouts\Design;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DesignE2 extends Rows
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
            Upload::make('design.attachment')
                ->title('3d - Визуализация')
                ->value(fn($value = []) => collect($value)->where('group', 'e2_pictures'))
                ->groups('e2_pictures')
                ->help('Загрузите файлы изображений')
                ->acceptedFiles('image/*,application/pdf,.psd'),
            Group::make([
                DateTimer::make('data.e2_date')
                    ->title('Плановая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
                DateTimer::make('data.e2_fact_date')
                    ->title('Фактическиая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
            ]),
        ];
    }
}
