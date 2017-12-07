<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionStatus extends Model
{
    protected $fillable = [
        'name', 'class', 'slug',
    ];
}
