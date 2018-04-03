<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{
    public function state() {
        return $this->belongsTo('App\State', 'state_id');
    }
}
