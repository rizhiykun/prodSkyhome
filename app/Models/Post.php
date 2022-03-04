<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
              'id',
              'name',
              'nameslug',
              'type',
              'deliverprice',
              'deliverytype',
              'email',
              'about',
              'flor',
              'florprice',
              'address',
              'phone',
              'comment',
              'timestamps'
    ];

}
