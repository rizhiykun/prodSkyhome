<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class DocumentTemplate extends Model
{
    use AsSource, Filterable, Attachable;
    protected $casts = [
        'docParams' => 'array'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'template',
        'mainTemplateId',
    ];
}
