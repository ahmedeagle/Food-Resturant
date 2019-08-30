<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'date_of_birth',
        'gender',
        'country_id',
        'city_id',
        'device_reg_id',
        'password',
        'activate_phone_hash',
        'activate_mail_hash',
        'token',
        'is_social',
        'social_name',
        'social_token',
        'phoneactivated',
        'blocked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function country(){
        return $this->hasOne('App\Country' , 'id' , 'country_id');
    }

    public function city(){
        return $this->hasOne('App\City' , 'id' , 'city_id');
    }
    public function image(){
        return $this->hasOne('App\Image' , 'id' , 'image_id');
    }

    public function isActive(){
        if($this->phoneactivated == 0){
            return false;
        }else{
            return true;
        }
    }
}

