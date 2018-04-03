<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionPasscode extends Model
{
    protected $fillable = [
        'api_token', 'otp',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public static function isValid($field) {
        $check = self::where('otp','=',$field)->first();
        if($check){
            return true;
        }
        return false;
    }

    public function election() {
        return $this->belongsTo('App\Election', 'election_id');
    }
}
