<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Projects extends Model
{
    protected $table = 'projects';
    use AsSource, Filterable, Attachable, HasFactory;

    protected $casts = [
        'data' => 'data'
    ];


    protected $fillable = [
        'id',
        'timestamps',
        'data',
        'disign',
        'repair',
        'yurlico',
        'fizlico',
        'team'

    ];

    /**
     * @var array
     */
    protected $allowedSorts = [

        'data'
    ];
}
