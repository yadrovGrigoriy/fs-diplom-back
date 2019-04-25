<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'price',
        'price_vip',
        'rows',
        'places',
        'schema'
    ];

    public $timestamps = false;
}
