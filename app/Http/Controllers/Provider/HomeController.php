<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
class HomeController extends Controller
{

    public function get_cities(Request $request){
        
        


        $rules = [
            "country" => "required|exists:countries,id",
        ];
        $messages = [
            "required"        => 1,
            "country.exists"  => 2,
        ];
        $msg = [
            1  => trans("messages.required"),
            2  => trans("site.country-exists"),
            3  => trans("messages.success"),
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $cities = DB::table("cities")
                    ->where("country_id" , $request->input("country"))
                    ->where("active" , "1")
                    ->select(
                        "id",
                        "ar_name AS name"
                    )->get();

        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "cities" => $cities]);
    }

    public function get_food_select(){
        // get the main subcategories
        $data['cats'] = DB::table("mealsubcategories")
                            ->select(
                                "id",
                                "ar_name AS name"
                            )
                            ->get();
        $data['title'] = " - تحديد نوع الطعام المقدم";
        $data['class']  = "page-template password change";
        return view("Provider.pages.register-food" , $data);

    }

    public function post_food_select(Request $request){
       // App()->setLocale("ar");
        $food = explode(",", $request->input('food'));

        foreach($food as $f){

            DB::table("provider_mealsubcategories")
                ->insert([
                    "provider_id" => auth('provider')->id(),
                    "Mealsubcategory_id" => $f
                ]);
        }

        return response()->json(['status' => true, "errNum" => 0, "msg" => trans("messages.success"), "final" => "0"]);
    }

    public function get_map_page(){
        $data['class'] = "page-template register address";
        $data['title'] = " - تحديد موقع المطعم";

        return view("Provider.pages.register-map", $data);
    }

    public function post_map_page(Request $request){
        
        // App()->setLocale("ar");
        $rules = [
            "lat" => "required",
            "lng" => "required"
        ];

        $messages = [
            "required" => trans("site.register-map-select")
        ];

        $this->validate($request, $rules , $messages);

        // update provider location
        DB::table("providers")
            ->where("id" , auth('provider')->id())
            ->update([
                "latitude" => $request->input('lat'),
                "longitude" => $request->input('lng')
            ]);

        return redirect("/restaurant/complete-profile/food");

    }

    public function get_cat_select(){
        // get the main subcategories
        $data['cats'] = DB::table("subcategories")
                            ->select(
                                "id",
                                "ar_name AS name"
                            )
                            ->get();
        $data['title'] = " - تحديد التصنيف";
        $data['class']  = "page-template password change";
        return view("Provider.pages.register-sub-cat" , $data);

    }

    public function post_cat_select(Request $request){
       // App()->setLocale("ar");
        $food = explode(",", $request->input('food'));

        foreach($food as $f){

            DB::table("provider_subcategories")
                ->insert([
                    "provider_id" => auth('provider')->id(),
                    "Subcategory_id" => $f
                ]);
        }

        return response()->json(['status' => true, "errNum" => 0, "msg" => trans("messages.success"), "final" => "1"]);
    }
}
