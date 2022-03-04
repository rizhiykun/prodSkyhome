<?php

namespace App\Orchid\Layouts\Estimates;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class EstimateBlock extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;
    public $findBlock = '';
    function block($findBlock) {
        return $findBlock;
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('estimate.text')
                ->type('text')
                ->value($this->block())
                ->title('Значения'),
        ];
    }
}
