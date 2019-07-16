<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class HelperController extends Controller
{
    public static function get_cities($country_id){

        return $cities = DB::table("cities")
                    ->where("country_id", $country_id)
                    ->get();

    }
}
