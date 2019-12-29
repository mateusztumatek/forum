<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login', 'city', 'desc', 'avatar', 'street', 'postal', 'banned_to', 'first_login', 'birth_date', 'update_code',
    ];
    protected $dates = ['birth_date'];
    public function getAvatarAttribute($avatar){
        if($avatar){
            return $avatar;
        }else{
            return 'users/default.jpg';
        }
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function settings(){
        return $this->hasMany('App\Setting', 'foreign_id')->where('model', 'user');
    }
    public function posts(){
        return $this->hasMany('App\Post');
    }
}
