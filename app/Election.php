<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date',
    ];

    public static function isElectionExists($field){
        $data = self::where('name','=',$field)->first();
        if($data){
            return true;
        }
        return false;
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucfirst($value);
    }

    public static function find($id, $field = null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function fnAssignParties(){
        return $this->belongsToMany('App\PoliticalParty', 'pivot_election_party')
                ->where("state_id", "=", 1)
                ->orderBy("code")
                ->select(["political_parties.*"]);
    }
}
