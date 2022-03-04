<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'real_address',
        'name',
        'surname',
        'patronymic',
        'birthdate',
        'passport',
        'inn',
        'kpp',
        'ogrn',
        'req',
        'bank',
        'signer',
        'additional'
    ];

    protected $allowedFilters  = [
        'email',
        'phone',
        'address',
        'real_address',
        'name',
        'surname',
        'patronymic',
        'birthdate',
        'passport',
        'inn',
        'kpp',
        'ogrn',
        'req',
        'bank',
        'signer',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'email',
        'phone',
        'address',
        'real_address',
        'name',
        'surname',
        'patronymic',
        'birthdate',
        'passport',
        'inn',
        'kpp',
        'ogrn',
        'req',
        'bank',
        'signer',
    ];

    /**
     */
    public function getEstimate()
    {
        return $this->belongsTo(Estimate::class, 'clientID');
    }

}
