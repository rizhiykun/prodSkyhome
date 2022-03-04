<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class RepairBlock extends Model
{
    protected $table = 'resources_plr_job_blocks';
    use AsSource, Filterable;

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'name'
    ];

    protected $allowedFilters = [
        'id',
        'created_at',
        'deleted_at',
        'name'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'created_at',
        'deleted_at',
        'name'
    ];
}
