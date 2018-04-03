<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    public function setNameAttribute($query) {
        return $this->attributes['name'] = ucwords($query);
    }

    public function setCodeAttribute($query) {
        return $this->attributes['code'] = strtoupper($query);
    }

    public function users() {
        return $this->hasMany('App\User', 'category_id');
    }
}
