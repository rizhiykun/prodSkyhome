<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Document extends Model
{
    protected $table = 'documents';
    use AsSource, Filterable, Attachable, HasFactory;

    protected $casts = [
        'fillableFields' => 'array',
        'data' => 'array',
        'templateId' => 'array'
    ];
    protected $fillable = [
        'status',
        'templateId',
        'number',
        'data'

    ];
    protected $allowedSorts = [
        'status',
        'id',
        'templateId',
        'number',
        'data',
        'created_at'
    ];
}
