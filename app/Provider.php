<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends Authenticatable
{
    
     protected $table = 'providers';
     
      protected $fillable = ['id','ar_name','en_name','en_description','ar_description','email','phone','password','country_id','city_id','city_id','category_id','online_list','accept_order','accept_online_payment','device_reg_id','phoneactivated','accountactivated','activation_date','activate_phone_hash','order_app_percentage','has_subscriptions','	subscriptions_period','subscriptions_amount','longitude','latitude'];
      
     
    public function branches()
    {
        return $this->hasMany('App\Branch' ,'provider_id' ,'id');
    }

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
}
