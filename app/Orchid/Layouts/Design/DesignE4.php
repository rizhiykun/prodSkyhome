<?php

namespace App\Orchid\Layouts\Design;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DesignE4 extends Rows
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
                ->title('Спецификация выбранных элементов мебели и декора')
                ->maxFiles(1)
                ->value(fn($value = []) => collect($value)->where('group', 'e4_specification'))
                ->groups('e4_specification')
                ->help('Загрузите файлы изображений')
                ->acceptedFiles('image/*,application/pdf,.psd'),
            Group::make([
                DateTimer::make('data.e4_date')
                    ->title('Плановая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
                DateTimer::make('data.e4_fact_date')
                    ->title('Фактическиая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
            ]),
            Upload::make('design.attachment')
                ->title('Альбом Дизайн-проекта')
                ->maxFiles(10)
                ->value(fn($value = []) => collect($value)->where('group', 'e4_collage'))
                ->groups('e4_collage')
                ->help('Загрузите файлы изображений')
                ->acceptedFiles('image/*,application/pdf,.psd'),
            Matrix::make('data.works')
                ->title('Заполните итоговую таблицу этапов и даты выполнения работ')
                ->columns(['Наименование этапа', 'Плановая дата выполнения', 'Фактическая дата выполнения'])
                ->fields([
                    'Плановая дата выполнения' => DateTimer::make()->allowInput()->format('Y-m-d'),
                    'Фактическая дата выполнения' => DateTimer::make()->allowInput()->format('Y-m-d'),
                ])
                ->maxRows(4)
        ];
    }
}
