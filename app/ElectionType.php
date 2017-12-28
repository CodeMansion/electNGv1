<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionType extends Model
{
    protected $fillable = [
        'name', 'description', 'code', 'class',
    ];
}
