<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;

class ReusableEditLayout extends Rows
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $prefix;

    /**
     * ReusableEditLayout constructor.
     *
     * @param string $prefix
     * @param string $title
     */
    public function __construct(string $prefix, string $title)
    {
        $this->prefix = $prefix;
        $this->title = $title;
    }

    /**
     * Views.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Label::make('label')
                ->title($this->title),

            Input::make($this->prefix . '.address')
                ->required()
                ->title('Address')
                ->placeholder('177A Bleecker Street'),
        ];
    }
}
