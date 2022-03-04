<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Repair extends Model
{
    use AsSource, Filterable, Attachable;

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'data' => 'array',
        'objectType',
        'estimate',
        'person',
        'disignCoast',
        'checkPresent',
        'discount',
        'termContract',
        'objectSquare',
        'totalAmount',
        'paySchedule',
        'tariff',
        'company'
    ];


}
