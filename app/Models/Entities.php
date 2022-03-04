<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Entities extends Model
{
    protected $table = 'entities';
    use AsSource, Filterable, Attachable;
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'organizationNameFull',
        'organizationNameShort',
        'inn',
        'kpp',
        'ogrn',
        'legalAddress',
        'addressReal',
        'checkIfSame',
        'requisites',
        'bankDetails',
        'subscriber',
        'phone',
        'email'
    ];
}
