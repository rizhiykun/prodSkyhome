<?php

namespace App\Orchid\Layouts\Design;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DesignE1 extends Rows
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
                    ->title('Обмерный план')
                    ->groups('e1_size_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_size_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План демонтажа')
                    ->groups('e1_demontage_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_demontage_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),

            Group::make([
                Upload::make('design.attachment')
                    ->title('План монтажа')
                    ->groups('e1_montazh_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_montazh_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('План сантехнического оборудования')
                    ->groups('e1_so_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_so_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),

            Group::make([
                Upload::make('design.attachment')
                    ->title('План расстановки мебели и оборудования')
                    ->groups('e1_rmo_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_rmo_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('Развертка стен с раскладкой плитки и привязкой сантехники в санузле')
                    ->groups('e1_rsrppss_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_rsrppss_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),


            Group::make([
                Upload::make('design.attachment')
                    ->title('Развертка по кухонной мебели (с привязкой электрики)')
                    ->groups('e1_rspkmel_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_rspkmel_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('Предварительный план электрики и расстановки осветительных приборов')
                    ->groups('e1_ppersp_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_ppersp_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),

            //План теплого пола
            //
            //Спецификация выбранного материала (сантехнические приборы и плитка)

            Group::make([
                Upload::make('design.attachment')
                    ->title('План теплого пола')
                    ->groups('e1_ptp_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_ptp_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
                Upload::make('design.attachment')
                    ->title('Спецификация выбранного материала (сантехнические приборы и плитка)')
                    ->groups('e1_svmspp_plan')
                    ->maxFiles(1)
                    ->value(fn($value = []) => collect($value)->where('group', 'e1_svmspp_plan'))
                    ->help('Загрузите файл pdf или dwg')
                    ->acceptedFiles('application/pdf,.psd,.dwg,.pln'),
            ]),
//3Д-визуализация санузла/ванной комнаты
            Upload::make('design.attachment')
                ->title('3Д-визуализация санузла/ванной комнаты')
                ->value(fn($value = []) => collect($value)->where('group', 'e1_3dvsvk'))
                ->groups('e1_3dvsvk')
                ->help('Загрузите файлы изображений')
                ->acceptedFiles('image/*,application/pdf,.psd'),
            Group::make([
                DateTimer::make('data.e1_date')
                    ->title('Плановая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
                DateTimer::make('data.e1_fact_date')
                    ->title('Фактическиая дата выполнения')
                    ->allowInput()
                    ->format('Y-m-d'),
            ]),
        ];
    }
}
