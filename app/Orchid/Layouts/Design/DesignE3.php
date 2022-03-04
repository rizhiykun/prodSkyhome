<?php

namespace App\Orchid\Layouts\Design;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DesignE3 extends Rows
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
                Upload::make('design.attachment')
                    ->title('План полов')
                    ->groups('e3_remount_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_remount_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План потолков')
                    ->groups('e3_mount_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_mount_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План расстановки светильников (финальный план)')
                    ->groups('e3_bath_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_bath_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План светильников по группам  (финальный план)')
                    ->groups('e3_floor_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_floor_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),
            Group::make([
                Upload::make('design.attachment')
                    ->title('План электрики (финальный план)')
                    ->groups('e3_ceiling_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_ceiling_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План Развертки стен')
                    ->groups('e3_light_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_light_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('Спецификация выбранных отделочных материалов')
                    ->groups('e3_light_group_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e3_light_group_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),
            Group::make([
                DateTimer::make('data.e3_date')
                    ->title('Плановая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
                DateTimer::make('data.e3_fact_date')
                    ->title('Фактическиая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
            ]),
        ];
    }
}
