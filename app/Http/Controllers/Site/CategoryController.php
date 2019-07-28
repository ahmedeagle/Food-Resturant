<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use LaravelLocalization;
class CategoryController extends Controller
{
    public function categories(){
        $data['title'] = " - التصنيفات";
        $data['class'] = "front-page page-template";

        $data['cats'] = DB::table("subcategories")
                            ->join("images", "subcategories.image_id", "images.id")
                            ->select(
                                "subcategories.id AS cat_id",
                                "subcategories.ar_name",
                                "subcategories.en_name",
                                "subcategories.created_at",
                                "subcategories.updated_at",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/subcategories/', images.name) AS image_url")
                            )
                            ->orderBy("order_level", "DESC")
                            ->groupBy("subcategories.id")
                            ->paginate(10);


        $request = new Request();
        //(new \App\Http\Controllers\Apis\User\HomeController())->filter_providers_branches_by_distance($request,"ar", $data['cats'],1);

        return view("Site.pages.categories", $data);
    }

    public function get_cat_providers($cat_id){

        // check if cat is exists
        $check = DB::table("subcategories")
                        ->where("id", $cat_id)
                        ->first();

        if(!$check){
            return redirect("/");
        }

        $data['cat_name'] = $check->ar_name;
         $data['providers'] =  DB::table("provider_subcategories")
                                ->join("providers" , "providers.id" , "provider_subcategories.provider_id")
                                ->join("images" , "images.id" ,"providers.image_id")
                                ->where("provider_subcategories.Subcategory_id" , $cat_id)
                                // ->where("providers.phoneactivated" , "1")
                                ->where("providers.accountactivated" , "1")
                                 ->join('branches','branches.provider_id','=','providers.id')
                                ->select(
                                        "branches.id AS id",
                                        "providers.id AS provider_id",
                                         "branches.has_delivery",
                                        "branches.has_booking",
                                        "branches.longitude",
                                        "branches.latitude",
                                        "branches.".LaravelLocalization::getCurrentLocale()."_address AS address",
                                        "branches.average_price AS mealAveragePrice",
                                   /* "providers." . $name . "_name AS name",*/
                                    DB::raw("CONCAT(providers .".LaravelLocalization::getCurrentLocale()."_name,'-',branches .".LaravelLocalization::getCurrentLocale()."_name) AS name"),
                                    
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                                )
                                ->groupBy("branches.id")
                                ->get();  
        $request = new Request();
        (new \App\Http\Controllers\Apis\User\HomeController())->filter_providers_branches($request,"ar", $data['providers'],1);
        
        
        

        $data['title'] = " - صفحة المطاعم";
        $data['class'] = "front-page page-template";

        return view("Site.pages.providers", $data);
    }
}
