<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class CashboxEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Кассы ';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование касс';
    public $exists = false;

    /**
     * Query data.
     *
     * @param $cash
     * @return array
     */
    public function query($cash): array
    {
        $this->exists = $cash->exists;

        if($this->exists){
            $this->name = 'Редактировать';
        }

        return [
            'cash' => cash
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Добавить')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Сохранить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
