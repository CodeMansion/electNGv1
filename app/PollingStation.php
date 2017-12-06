<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollingStation extends Model
{
    public static function find($id, $field = null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function state(){
    	return $this->belongsTo(\App\State::class);
    }

    public function lga(){
    	return $this->belongsTo(\App\Lga::class);
    }

    public function ward(){
    	return $this->belongsTo(\App\Ward::class);
    }
}
