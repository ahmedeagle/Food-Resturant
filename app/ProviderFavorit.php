<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderFavorit extends Model
{
    public function provider(){
        return $this->hasOne('App\Provider' , 'id' , 'provider_id');
    }
}
