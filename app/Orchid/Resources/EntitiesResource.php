<?php

namespace App\Orchid\Resources;

use App\Models\Entities;
use App\Models\Person;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\TD;
use Orchid\Screen\Sight;

class EntitiesResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Entities::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('Наши Юр.Лица');
    }

    /**
     * Get the permission key for the resource.
     *
     * @return string|null
     */
    public static function permission(): ?string
    {
        return 'Наши Юр.Лица';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('Юр.Лицо');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [

            Input::make('organizationNameFull')
                ->title('Наименование организации ')
                ->horizontal()
                ->required()
                ->help('Введите полное наименование организации')
                ->placeholder('Наименование организации'),
            Input::make('organizationNameShort')
                ->title('Сокращенное наименование организации')
                ->horizontal()
                ->required()
                ->help('Введите сокращенное наименование организации')
                ->placeholder('Введите наименование организации'),
            Input::make('inn')->type('number')
                ->title('ИНН ')
                ->horizontal()
                ->required()
                ->help('Введите ИНН юрлица')
                ->placeholder('Введите ИНН'),
            Input::make('kpp')->type('number')
                ->title('КПП ')
                ->horizontal()
                ->required()
                ->help('Введите КПП юрлица')
                ->placeholder('Введите КПП'),
            Input::make('ogrn')->type('number')
                ->title('ОГРН ')
                ->horizontal()
                ->required()
                ->help('Введите ОГРН юрлица')
                ->placeholder('Введите ОГРН'),
            TextArea::make('legalAddress')
                ->title('Юридический адрес ')
                ->rows(3)
                ->horizontal()
                ->required()
                ->help('Введите юридический адрес')
                ->placeholder('Введите юридический адрес'),
            TextArea::make('addressReal')
                ->title('Фактический адрес ')
                ->rows(3)
                ->horizontal()
                ->required()
                ->help('Введите фактический адрес юрлица')
                ->placeholder('Введите фактический адрес'),
            CheckBox::make('checkIfSame')
                ->value(1)
                ->horizontal()
                //                ->placeholder('Адрес юридический совпадает с фактическим адресом')
//                ->title('Адрес юридический совпадает с фактическим адресом')
//                ->help('Если адрес юридический совпадает с фактическим адресом')
                ->hidden(),
            TextArea::make('requisites')
                ->title('В лице ')
                ->rows(2)
                ->horizontal()
                ->required()
                ->help('должность ____ фио _____на основании чего действует ______')
                ->placeholder('Введите на основании чего действует юрлицо'),
            TextArea::make('bankDetails')
                ->title('Банковские реквизиты ')
                ->rows(3)
                ->horizontal()
                ->required()
                ->help('Введите реквизиты банка юрлица')
                ->placeholder('Введите банковские реквизиты'),
            Relation::make('subscriber')
                ->title('Подписант ')
                ->fromModel(Person::class, 'lastname')
                ->displayAppend('FIO')
                ->horizontal()
                ->required()
                ->help('Введите подписанта юрлица')
                ->placeholder('Введите подписанта'),
            Input::make('phone')
                ->title('Телефон ')
                ->mask('(999) 999-9999')
                ->horizontal()
                ->required()
                ->help('Введите телефон в формате (999) 999-9999')
                ->placeholder('Введите телефон'),
            Input::make('email')->type('email')
                ->title('Электронная почта ')
                ->horizontal()
                ->required()
                ->help('Введите электронную почту')
                ->placeholder('Введите электронную почту'),
            Upload::make('data')->horizontal()->title('Файлы')->help('Документы')

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
            TD::make('id'),
            TD::make('organizationNameFull', 'Наименование')->sort(),
            TD::make('phone', 'Телефон')->render(fn($value) => $value->phone.'')->sort(),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                })->sort(),

            TD::make('updated_at', 'Update date')
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
