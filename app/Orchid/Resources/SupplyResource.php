<?php

namespace App\Orchid\Resources;

use App\Models\Measurement;
use App\Models\Post;
use App\Models\Supply;
use Illuminate\Support\Str;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;
use Orchid\Screen\Sight;

class SupplyResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Supply::class;

    public static function permission(): ?string
    {
        return 'Материалы';
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Материалы');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Материал');
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
                ->title('Наименование')
                ->horizontal()
                ->help('Введите название материала')
                ->placeholder('Введите наименование'),
            Select::make('type')
                ->title('Тип: ')
                ->horizontal()
                ->options([
                    '' => '',
                    'Прочее' => 'Прочее',
                    'Общестрой' => 'Общестрой',
                    'Электрика' => 'Электрика',
                    'Сантехника' => 'Сантехника'
                ])
                ->help('Выберите тип поставщика'),
            Input::make('charge')
                ->horizontal()
                ->title('Наценка %')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => ' ',
                    'groupSeparator' => ' ',
                    'digitsOptional' => true,
                ])
                ->help('Введите или выберете наценку для данного материала, в процентах'),
            Input::make('weight')
                ->horizontal()
                ->title('Вес (кг)')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => ' ',
                    'groupSeparator' => ' ',
                    'digitsOptional' => true,
                ])
                ->help('Введите вес товара в килограммах')
                ->placeholder('Введите вес товара'),
            Relation::make('measure')
                ->fromModel(Measurement::class, 'name')
                ->title('Еденица измерения')
                ->required()
                ->help('Укажите еденицу измерения'),
            Cropper::make('photo')
                ->horizontal()
                ->help('Фотография материала'),
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
            TD::make('photo','Фото')
                ->width(100)
                ->render(function ($model) {
                    $image=$model['photo'];
                    return "<img src='{$image}'
                              alt='sample'
                              class='mw-100 d-block img-fluid'>";
                }),
            TD::make('name', 'Наименование')->sort(),
            TD::make('type', 'Тип')->sort(),
            TD::make('unit', 'Ед. измерения')->sort(),
            TD::make('charge', 'Наценка в %')->sort(),
            TD::make('weight', 'Вес')->sort(),
            TD::make('used', 'Скрыт'),
 //           TD::make('created_at', 'Создан')
 //               ->render(function ($model) {
 //                   return $model->created_at->toDateTimeString();
 //               })
 //               ->defaultHidden(),
 //           TD::make('updated_at', 'Изменен')
 //               ->render(function ($model) {
 //                   return $model->updated_at->toDateTimeString();
 //               })
 //               ->defaultHidden(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    protected function iconNotFound(): string
    {
        return 'icon-table';
    }

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
