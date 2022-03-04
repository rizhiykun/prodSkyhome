<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tariff extends Model
{
    use AsSource, Filterable, Attachable, HasFactory;

    protected $casts = [
        'additionalTemplatesId' => 'array',
        'data' => 'array',
        'mainTemplateId' => 'integer',
    ];


    protected $fillable = [
        'name',
        'type',
        'data',
        'price',
        'mainTemplateId',
        'additionalTemplatesId',
    ];
}
