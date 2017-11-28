<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile(){
        return $this->hasOne(UserProfile::class);
    }

    public function scopeAdmin($query){
        return $query->where('user_type_id', 1);
    }

    public function scopeUsers($query){
        return $query->whereIn('user_type_id', [
            2, 3, 4
        ]);
    }

    public function setPasswordAttribute($value){
        return $this->attributes['password'] = bcrypt($value);
    }

    public function userType(){
        return $this->belongsTo('App\UserType');
    }

    public function isActivated(){
        if(!$this->activated){
            return false;
        }
        return true;
    }

    public function isAdmin(){
        if(!in_array($this->user_type_id, [1, 4, 3])){
            return false;
        }
        return true;
    }

    public static function find($id, $field = null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }

    public static function hasEmail($field){
        $data = self::where('email','=',$field)->first();
        if($data){
            return true;
        }
        return false;
    }


    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name',$role);
        }

        foreach($role as $r){
            if($this->hasRole($r->name)){
                return true;
            }
        }

        return false;
    }

    public function assignRole($role){
        return $this->roles()->save(
            Role::whereId($role)->firstOrFail()
        );
    }
}
