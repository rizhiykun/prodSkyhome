<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Estimate extends Model
{
    use AsSource, Filterable, Attachable, HasFactory;

    protected $casts = [
        'data' => 'array',
        'works' => 'array',
        'additionalWorks' => 'array'
    ];

    protected $fillable = [
        'objectType',
        'Rationale',
        'clientID',
        'objectAddress',
        'floorArea',
        'ceilingHeight',
        'discounts',
        'works',
        '$additionalWorks'
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('approval', true);
    }

}
