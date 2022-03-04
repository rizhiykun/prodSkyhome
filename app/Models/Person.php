<?php

namespace App\Models;

use App\Orchid\Presenters\PersonPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Person extends Model
{
    protected $table = 'persons';
    use AsSource, Filterable, Attachable, HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'lastname',
        'surname',
        'BirthDate',
        'passportInfo',
        'address',
        'addressReal',
        'phone',
        'email',
        'password',
        'checkIfSame',
        'data'
    ];

    public function getFIOAttribute(): string
    {
        return $this->attributes['lastname'] . ' (' . $this->attributes['name'] . ')' . ' (' .
            $this->attributes['email'] . ')';
    }

    public function presenter(): PersonPresenter
    {
        return new PersonPresenter($this);
    }

}
