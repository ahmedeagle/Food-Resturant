<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public function permissions(){
        return $this->hasOne("App\admin_permissions");
    }
}
