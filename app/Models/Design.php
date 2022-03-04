<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Design extends Model
{
    use AsSource, Filterable, Attachable;

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'data' => 'array',
        'person',
        'manager',
        'designer',
        'ourCompany',
        'objectAddress',
        'objectSquare',
        'objectTariff',
        'objectData'
    ];

    protected $allowedFilters = [
        'id',
        'created_at',
        'deleted_at',
        'person',
        'ourCompany',
        'objectAddress',
        'objectSquare',
        'objectTariff',
        'objectData'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'created_at',
        'deleted_at',
        'person',
        'ourCompany',
        'objectAddress',
        'objectSquare',
        'objectTariff',
        'objectData'
    ];

}
