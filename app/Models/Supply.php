<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Supply extends Model
{
    use AsSource, Filterable, Attachable;
    protected $fillable = [
        'name',
        'type',
        'unit',
        'charge',
        'weight',
        'photo',
    ];
    protected $allowedFilters = [
        'type',
        ];
    protected $allowedSorts = [
        'type',
    ];


}
