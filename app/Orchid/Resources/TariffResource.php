<?php

namespace App\Orchid\Resources;

use App\Models\DocumentTemplate;
use App\Models\Tariff;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;
use Orchid\Screen\Sight;

class TariffResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Tariff::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Тарифы');
    }

    public static function permission(): ?string
    {
        return 'Тарифы';
    }
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Тариф');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Название тарифа')
                ->horizontal()
                ->help('Введите название тарифа')
                ->placeholder('Введите название тарифа'),
            Select::make('type')
                ->title('Тип: ')
                ->horizontal()
                ->options([
                    'Дизайн' => 'Дизайн',
                    'Ремонт' => 'Ремонт',
                    'Архив Дизайн' => 'Архив Дизайн',
                    'Архив Ремонт' => 'Архив Ремонт'
                ])
                ->help('Выберите тип тарифа (будет появляться в соотвествующем разделе Дизайн или Ремонт)'),
           Input::make('price')
                ->horizontal()
                ->title('Цена за м2')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                ])
                ->help('Введите цену в рублях за квадратный метр')
                ->placeholder('Введите цену в рублях за квадратный метр'),

           Select::make('mainTemplateId')
                ->title('Шаблон договора: ')
                ->horizontal()
                ->fromQuery(DocumentTemplate::where('id', '>', '0'), 'name', 'id')
                ->help('Выберите тип шаблона договора'),

            Matrix::make('data.templates')
                ->title('Дополнительные шаблоны')
                ->columns(['Название' => 'name', 'Шаблон' => 'template'])
                ->fields([
                    'name' => TextArea::make('text'),
                    'template' => Select::make('tpl')
                        ->required()
                        ->fromQuery(DocumentTemplate::where('id', '>', '0'), 'name', 'id')]),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'Номер')->defaultHidden(),
            TD::make('name', 'Название')->sort(),
            TD::make('type', 'Тип')->sort(),
            TD::make('price', 'Цена за квадратный метр')->sort(),
   //         TD::make('created_at', 'Создан')
  //              ->render(function ($model) {
    //                return $model->created_at->toDateTimeString();
    //            })
    //            ->defaultHidden(),
    //        TD::make('updated_at', 'Изменен')
    //            ->render(function ($model) {
    //                return $model->updated_at->toDateTimeString();
    //            })
    //            ->defaultHidden(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [

        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
        ];
    }

}
