<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionParty extends Model
{
    public function election() {
        return $this->belongsTo('App\Election', 'election_id');
    }
}
