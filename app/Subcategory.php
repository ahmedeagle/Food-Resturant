<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function image(){
        return $this->hasOne("App\Image" , "id" , "image_id");
    }
}
