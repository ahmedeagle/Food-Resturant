<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\City;
use App\Http\Controllers\Controller;
use Validator;

class CityController extends Controller
{
    public function get_cities(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "country_id" => "required|exists:countries,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.country_id_exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $name = (App()->getLocale() == 'ar') ? 'ar_name' : 'en_name' ;
        $country_id = $request->input("country_id");
        $cities = City::where("country_id" , $country_id)
                    ->where("active", "1")
                    ->select("id" , $name . " AS name" , "country_id")
                    ->get();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => $msg[3] , "cities" => $cities]);
    }
}
