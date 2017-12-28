<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionOnetimePassword extends Model
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
}
