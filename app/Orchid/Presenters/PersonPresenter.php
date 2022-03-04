<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class PersonPresenter extends Presenter
{
    public function fullName(): string
    {
        //return $this->name . ' ' . $this->lastname;
        return $this->name;
    }
}
