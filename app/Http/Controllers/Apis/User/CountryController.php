<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
class CountryController extends Controller
{
    public function get_countries(Request $request){
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar_name' : 'en_name' ;
        $countries = Country::select("id" , $name . " AS name")
                        ->where("active", "1")
                        ->get();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => trans("messages.success"), "countries" => $countries]);
    }
}
