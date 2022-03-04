<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class NormsList extends Model
{
    protected $table = 'norms_list';
    use AsSource, Filterable, Attachable, HasFactory;

    protected $casts = [
        'supply' => 'array'
    ];


    protected $fillable = [
        'WorkID',
        'supply'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [

        'supply'
   ];
}
