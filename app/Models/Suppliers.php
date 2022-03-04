<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use AsSource, Filterable, Attachable;

    /**
     * @var array
     */
    protected $fillable = [
        'badge',
        'name',
        'email',
        'phone',
        'address',
        'addressj',
        'inn',
        'kpp',
        'ogrn',
        'okved',
        'additional'

    ];
    protected $allowedFilters  = [
        'badge',
        'name',
        'email',
        'phone',
        'address',
        'addressj',
        'inn',
        'kpp',
        'ogrn',
        'okved',
        'additional'
        ];
    protected $allowedSorts = [
        'badge',
        'name',
        'email',
        'phone',
        'address',
        'addressj',
        'inn',
        'kpp',
        'ogrn',
        'okved',
        'additional'
        ];

}
