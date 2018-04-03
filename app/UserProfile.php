<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'surname', 'other_names', 'gender_id', 'email', 'phone', 'state_id', 'address'
    ];

    public function setSurnameAttribute($query) {
        return $this->attributes['surname'] = ucfirst($query);
    }

    public function setOtherNamesAttribute($query) {
        return $this->attributes['other_names'] = ucwords($query);
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function hasEmail($query) {
        $check = self::where('email', $query)->first();
        return ($check);
    }
}