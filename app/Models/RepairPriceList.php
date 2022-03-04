<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class RepairPriceList extends Model
{
    protected $table = 'prise_list_repair';
    use AsSource, Filterable;

    protected $casts = [
        'data' => 'array',
        'options' => 'array'
    ];

    protected $fillable = [
        'workGroup',
        'workBlock',
        'workName',
        'options' => 'array',
        'additionalWorks',
        'plVisible',
        'measurement',
        'basePrice',
        'discount',
        'discountPrice',
        'masterPrice',
        'foremanPrice',
        'data' => 'array'
    ];

    protected $allowedFilters = [
        'workGroup',
        'workBlock',
        'workName',
        'additionalWorks',
        'plVisible',
        'measurement',
        'basePrice',
        'discount',
        'discountPrice',
        'masterPrice',
        'foremanPrice'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'workGroup',
        'workBlock',
        'workName',
        'additionalWorks',
        'plVisible',
        'measurement',
        'basePrice',
        'discount',
        'discountPrice',
        'masterPrice',
        'foremanPrice'
    ];
}
