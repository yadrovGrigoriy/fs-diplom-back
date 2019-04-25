<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'poster',
        'description',
        'country'
      ];

      public $timestamps = false;
}
