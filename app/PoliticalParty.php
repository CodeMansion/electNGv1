<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoliticalParty extends Model
{
    protected $fillable = [
        'code', 'name', 'description',
    ];
    
    public static function find($id, $field = null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function setCodeAttribute($value){
        return $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucwords($value);
    }

    //function to check for same political party code
    public static function hasCode($field){
        $data = self::where('code','=',$field)->first();
        if($data){
            return true;
        }
        return false;
    }
}
