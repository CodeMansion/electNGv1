<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function Lgas() {
        return $this->hasMany('App\Lga', 'state_id');
    }

    public static function find($id, $field = null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }
}
