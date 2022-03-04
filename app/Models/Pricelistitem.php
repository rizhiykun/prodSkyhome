<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Pricelistitem extends Model
{
    use AsSource, Filterable, Attachable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'type',
        'unit',
        'base_price',
        'manager_price',
        'master_price',
        'visible',
        'comment',
        'additional'
    ];
    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'type',
        'base_price',
        'manager_price',
        'master_price',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'type',
        'base_price',
        'manager_price',
        'master_price',
    ];
}
