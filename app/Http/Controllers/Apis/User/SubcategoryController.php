<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subcategory;
use App\Mealsubcategories;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use DB;
use LaravelLocalization;
class SubcategoryController extends Controller
{
    /*
     * ******************
     * main SubCategories
     * ******************
     */

    /*
     * this main subCategories List Will Return In the Main Screen
     * each provider Can Choose More Than One MAin Sub Categories
     */
    public function get_main_sub_categories(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        $cats = (new HomeController())->getSubCategoriesList($name);
        return response()->json([
                            "status"      => true ,
                            "errNum" => 0,
                            "msg"     => trans("messages.success"),
                            "cats"        => $cats
        ]);
    }
    
        // modified  get nearst branches not provider 
    public function get_nearest_providers_inside_main_sub_categories(Request $request){
        
         (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        // type 0 -> distance , 1 -> rate
        $rules      = [
            "cat_id" => "required|exists:subcategories,id",
            "type"   => "required|in:0,1"
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2,
            "in"         => 4
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.subCategory_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.type.in.0.1")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $type = $request->input("type");

          $pagianted_branches =    DB::table("provider_subcategories")
                                ->join("providers" , "providers.id" , "provider_subcategories.provider_id")
                                ->join("images" , "images.id" ,"providers.image_id")
                                ->where("provider_subcategories.Subcategory_id" , $request->input("cat_id"))
                                // ->where("providers.phoneactivated" , "1")
                                ->where("providers.accountactivated" , "1")
                                 ->join('branches','branches.provider_id','=','providers.id')
                                ->select(
                                        "branches.id AS id",
                                        "providers.id AS provider_id",
                                        "branches.id AS id",
                                        "branches.has_delivery",
                                        "branches.has_booking",
                                        "branches.longitude",
                                        "branches.latitude",
                                        "branches." .$name ."_address AS address",
                                        "branches.average_price AS mealAveragePrice",
                                   /* "providers." . $name . "_name AS name",*/
                                    DB::raw("CONCAT(providers .".LaravelLocalization::getCurrentLocale()."name,'-',branches .".LaravelLocalization::getCurrentLocale()."name) AS name"),
                                    
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                                )
                                ->groupBy("branches.id")
                                ->paginate(10);  
                                
                                

            //orderby distance 
        (new HomeController())->filter_providers_branches($request,$name,$pagianted_branches ,$type);
 
        if($type == 0){
            // filter based on distance
            $branches = $pagianted_branches->sortBy(function($item){
                return $item->distance;
            })->values();
        }else{
            // filter by rate
            $branches = $pagianted_branches->sortByDesc(function($item){
                return $item->averageRate;
            })->values();
        }

        $branches = new LengthAwarePaginator(
                                $branches,
                                $pagianted_branches->total(),
                                $pagianted_branches->perPage(),
                                $request->input("page"),
                                ["path" => url()->current()]

        );

        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "providers" => $branches]);
    }
    
    public function filter_providers_branches_by_rate(Request $request ,$name,$providers){
        
    }
    /*
     * ******************
     * Meal SubCategories
     * ******************
     */

    /*
     * provider choose more than one in register
     * user choose more than one in register
     * refer to meal subCategories Table
    */
    public function get_meal_sub_categories(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar_name' : 'en_name' ;
        $mealSubCategories = Mealsubcategories::select("id" , $name . " AS name")
                                ->get();
        return response()->json(["status" => true , "errNum" => 0 , "msg" => trans("messages.success") , "categories" => $mealSubCategories]);
    }
}
