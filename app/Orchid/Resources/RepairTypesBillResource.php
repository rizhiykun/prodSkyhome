<?php

namespace App\Orchid\Resources;

use App\Models\RepairType;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Screen\Sight;

class RepairTypesBillResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = RepairType::class;
    /**
     * Get the permission key for the resource.
     *
     * @return string|null
     */
    public static function permission(): ?string
    {
        return 'Типы ремонта';
    }
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Типы ремонта');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Тип ремонта');
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
                ->title('Название Тип ремонта')
                ->horizontal()
                ->help('Введите Тип ремонта')
                ->placeholder('Введите Тип ремонта'),
            Input::make('markup')
                ->title('Наценка на прораба')
                ->horizontal()
                ->help('Введите наценку на прораба')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => ' ',
                    'groupSeparator' => ' ',
                    'digitsOptional' => true,
                ])
                ->placeholder('Введите наценку на прораба'),
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
            TD::make('markup', 'Наценка')->sort(),
            TD::make('created_at', 'Дата создания')
                ->defaultHidden()
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                })->sort(),

            TD::make('updated_at', 'Обновлено')
                ->defaultHidden()
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                })->sort(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
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
