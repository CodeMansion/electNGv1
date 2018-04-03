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

    public function setPasswordAttribute($value){
        return $this->attributes['password'] = bcrypt($value);
    }

    public function category(){
        return $this->belongsTo('App\UserCategory', 'user_category_id');
    }

    public function isActivated(){
        if(!$this->activated){
            return false;
        }
        return true;
    }

    public static function find($id, $field = null){
        if($field){
            return self::where($field,$id)->firstOrFail();
        }
        return self::where('id',$id)->firstOrFail();
    }

    public static function hasEmail($field){
        $check = self::where('email',$field)->first();
        return ($check);
    }

    public function elections() {
        return $this->belongsToMany('App\Election', 'user_elections');
    }


    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
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

    public function isAn($field) {
        $roles = \DB::table('role_user')->where([
            'user_id'   => $this->id,
        ])->get();

        foreach($roles as $role) {
            $check = Role::find($role->role_id);
            if(isset($check) && $check->name == $field){
                return true;
            }
        }

        return false;
    }
}
