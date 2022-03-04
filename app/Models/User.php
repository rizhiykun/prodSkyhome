<?php

namespace App\Models;

use Orchid\Platform\Models\User as Authenticatable;
use PhpParser\Builder;
use Psy\Command\BufferCommand;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'birthDate',
        'passpData',
        'passpNums',
        'passIssued',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'passpData',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'passpData',
        'updated_at',
        'created_at',
    ];



    public function scopeDesigners(Builder $query)
    {
        $users = User::with( ['roles', 'role_users'])->get();
        return $users;
    }
}
