<?php

namespace App\Http\Controllers\Site;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
class BranchController extends Controller
{
    public function get_restaurant_page($id){

       // app()->setLocale("ar") ;
        $restaurant = DB::table("branches")
                        ->where("id", $id)
                        ->first();
                        
                        
                        
        if(!$restaurant){
            return redirect("/");
        }

        $data['title'] = " - صفحة المطعم";
        $data['class'] = "front-page page-template";
    

         $branch = DB::table("branches")
                    ->join("providers" ,"providers.id" , "branches.provider_id")
                    ->join("congestion_settings" , "congestion_settings.id" ,"branches.congestion_settings_id")
                    ->join("images" , "images.id" , "congestion_settings.image_id")
                    ->where("branches.id" , $id)
                    ->select(
                        "branches.id",
                        "providers.id AS provider_id",
                        "providers.ar_name AS name",
                        "providers.ar_description AS description",
                        "congestion_settings.ar_name AS congestion_name",
                         DB::raw("CONCAT('". url('/') ."','/storage/app/public/settings/', images.name) AS congestion_image_url"),
                        "branches.ar_address AS address",
                        "branches.has_booking",
                        "branches.booking_status",
                        "providers.accept_order",
                        "branches.has_delivery",
                        "branches.delivery_price",
                        "branches.start_working_time",
                        "branches.end_working_time",
                        "branches.latitude",
                        "branches.longitude",
                        "branches.average_price AS menu_average_price"
                    )
                    ->first();
                     
                    
        $branch_working_hours = DB::table("branch_working_hours")
                                    ->where("branch_id", $id)
                                    ->first();
                
        $exclude = ["id", "branch_id", "created_at", "updated_at"];
         
        

           
        $count = 0;
        
        foreach($branch_working_hours as $key => $time){
              
            if(in_array($key, $exclude))  continue;

            if($time == null){
                 continue;
            }
            $time_in_12_hour_format  = date("g:i a", strtotime($time));
            $dateArr = explode(" ", $time_in_12_hour_format);
           // $branch_working_hours->$key = $dateArr[0];
            $ext = $key . "_extention";
            $branch_working_hours -> $ext = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");
            $count++;

            if($count == 14){
                break;
            }
        }
        
        
         
          $data["branch_working_hours"] = $branch_working_hours;
          
           
          
        //  dd($branch_working_hours);
         
         
        $logo = DB::table("providers")
                        ->join("images" , "images.id", "providers.image_id")
                        ->where("providers.id",$branch->provider_id)
                        ->select(
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS logo_image")
                        )->first();
                        
                        
                         

        $meals = DB::table("meals")
            ->where("branch_id" , $branch->id)
            ->where("published" , "1")
            ->where("deleted" , "0")
            ->select(DB::raw("AVG(price) AS average_price"))
            ->first();
            
            
        $branch->menu_average_price = ($meals->average_price == null) ? 0 : round((double) $meals->average_price);


        $branch->image_logo_url = $logo->logo_image;
        
        if(auth()->user()){
            $userData = DB::table("users")
                            ->where("id" , auth()->id())
                            ->first();
            if(!$userData){
                return rdirect()->back()->with("error", trans("messages.error"));
            }
            
            $user  = DB::table("provider_favorits")
                        ->where("provider_id" , $branch-> id)
                        ->where("user_id" , auth()->id())
                        ->select("*")
                        ->first();
            if($user){
                $branch->is_favorite = true;
            }else{
                $branch->is_favorite = false;
            }
        }else{
            $branch->is_favorite = false;
        }
        
        $meals = DB::table("meals")
                    ->where("branch_id" , $branch->id)
                    ->where("published" , 1)
                    ->select(DB::raw("AVG(price) AS average_price"))
                    ->first();

        $rates = DB::table('rates')
                    ->where('branch_id' ,$branch->id)
                    ->select(
                        DB::raw("SUM(service) AS service_sum"),
                        DB::raw("SUM(quality) AS quality_sum"),
                        DB::raw("SUM(Cleanliness) AS cleanliness_sum"),
                        DB::raw("COUNT(id) AS count")
                    )->first();
                    
        if($rates->count != 0){

            $s = $rates->service_sum / $rates->count;
            $q = $rates->quality_sum / $rates->count;
            $c = $rates->cleanliness_sum / $rates->count;

            $branch->average_service_rate     = round($s);
            $branch->average_quality_rate     = round($q);
            $branch->average_cleanliness_rate = round($c);
            $branch->total_average_rate = round(($s + $q + $c) / 3);
        }else{
            $branch->average_service_rate     = 0.0;
            $branch->average_quality_rate     = 0.0;
            $branch->average_cleanliness_rate = 0.0;
            $branch->total_average_rate = 0.0;
        }

        //$branch->menu_average_price = ($meals->average_price == null) ? 0 : round($meals->average_price);

        // images
        $images = DB::table("branch_images")
                        ->join("images" , "images.id" , "branch_images.image_id")
                        ->where("branch_images.branch_id" , $branch->id)
                        ->select(
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/branches/', images.name) AS image_url")
                            )
                        ->get();
        $branch->images = $images;
        // food type
        $cats = DB::table("provider_mealsubcategories")
                        ->join("providers" , "providers.id" , "provider_mealsubcategories.provider_id")
                        ->join("branches" , "branches.provider_id" , "providers.id")
                        ->join("mealsubcategories" , "mealsubcategories.id" ,"provider_mealsubcategories.Mealsubcategory_id")
                        ->where("branches.id" , $branch->id)
                        ->select(
                            "mealsubcategories.id AS cat_id",
                            "mealsubcategories.ar_name AS cat_name"
                            )
                        ->get();
        
        $categoriesString = "";
        foreach($cats as $key => $cat){
            $seperate = ($key != 0) ? ", " : "";
            $categoriesString .= $seperate . $cat->cat_name;
        }
        $branch->categories_string = $categoriesString;
        // features
        $options = DB::table("branch_options")
                        ->join("branches" , "branches.id" , "branch_options.branch_id")
                        ->join("options" , "options.id" , "branch_options.option_id")
                        ->join("images" , "images.id" , "options.image_id")
                        ->where("branches.id" , $branch->id)
                        ->select("options.ar_name AS option_name",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/options/', images.name) AS option_image_url"))
                        ->get();
        $branch->options = $options;
        
//        if(auth()->user()){
//            $user = \App\User::where("id" , auth()->id())->first();
//            if($user == null){
//                return redirect()->back()->with("error", trans("messages.error"));
//            }
//            $userRates = DB::table("rates")
//                                ->where("user_id" , auth()->id())
//                                ->where("branch_id" , $id)
//                                ->select(
//                                    "rates.Cleanliness",
//                                    "rates.service",
//                                    "rates.quality"
//                                )->first();
//            if($userRates == null){
//                    $branch->is_user_rate_branch    = false;
//                    $branch->user_cleanliness_rate  = 0;
//                    $branch->user_service_rate      = 0;
//                    $branch->user_quality_rate      = 0;
//            }else{
//                    $branch->is_user_rate_branch    = true;
//                    $branch->user_cleanliness_rate  = (int)$userRates->Cleanliness;
//                    $branch->user_service_rate      = (int)$userRates->service;
//                    $branch->user_quality_rate      = (int)$userRates->quality;
//            }
//        }else{
//            $branch->is_user_rate_branch    = false;
//            $branch->user_cleanliness_rate  = 0;
//            $branch->user_service_rate      = 0;
//            $branch->user_quality_rate      = 0;
//        }





        if(auth()->user()){
            $user = \App\User::where("id" , auth()->id())->first();
            if($user == null){
                return redirect()->back()->with("error", trans("messages.error"));
            }
            $userRates = DB::table("rates")
                ->where("user_id" , auth()->id())
                ->where("branch_id" , $id)
                ->select(
                    DB::raw("SUM(service) AS service_sum"),
                    DB::raw("SUM(quality) AS quality_sum"),
                    DB::raw("SUM(Cleanliness) AS cleanliness_sum"),
                    DB::raw("COUNT(id) AS count")
                )->first();

            if($userRates->count == 0){
                $branch->is_user_rate_branch    = false;
                $branch->is_user_can_rate    = true;
                $branch->user_cleanliness_rate  = 0;
                $branch->user_service_rate      = 0;
                $branch->user_quality_rate      = 0;
            }else{
                $branch->is_user_rate_branch    = true;

                // check if the user can make rate
                $user_id = auth()->id();
                $branch->is_user_can_rate  = ( new \App\Http\Controllers\Apis\User\BranchController() )->check_user_can_rate($user_id, $id);

                $s = $userRates->service_sum / $userRates->count;
                $q = $userRates->quality_sum / $userRates->count;
                $c = $userRates->cleanliness_sum / $userRates->count;

                $branch->user_service_rate   = (int)round($s);
                $branch->user_quality_rate     = (int)round($q);
                $branch->user_cleanliness_rate = (int)round($c);

            }
        }else{
            $branch->is_user_rate_branch    = false;
            $branch->is_user_can_rate    = false;
            $branch->user_cleanliness_rate  = 0;
            $branch->user_service_rate      = 0;
            $branch->user_quality_rate      = 0;
        }





        // get provider meal categories
        
        
        
        // get the meals that belong to this branch inside this categories
           $mealCategories =    DB::table('branches') 
                                         ->join('providers','branches.provider_id','=','providers.id')
                                         -> where('branches.id',$id)
                                         ->join('mealcategories','mealcategories.provider_id','=','providers.id')
                                 
                            ->select(
                                "mealcategories.id AS cat_id",
                                "mealcategories.ar_name AS cat_name"
                             )
                            ->get();
        
        

        foreach($mealCategories as $key => $c){
            
            $meals = DB::table("meals")
                        ->where('meals.branch_id',$id)
                        ->where("mealCategory_id", $c->cat_id)
                        ->select(
                            "meals.id AS meal_id",
                            "meals.ar_name AS meal_name",
                            "meals.price"
                        )
                        ->get();
                        
            if(count($meals) == 0){
                unset($mealCategories[$key]);
                continue;
            }      
            
            foreach($meals as $meal){
                $img = DB::table("meal_images")
                        ->join("images", "images.id", "meal_images.image")
                        ->where("meal_images.meal_id", $meal->meal_id)
                        ->select(
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                        )->first();
                        
                $meal->image_url = $img->meal_image_url;
            }

            $c->meals = $meals;
        }
        
        $comments = DB::table("comments")
                        ->join("users", "users.id", "comments.user_id")
                        ->leftjoin("images", "images.id", "users.image_id")
                        ->where("comments.branch_id", $id)
                        ->where("comments.stopped", "0")
                        ->orderBy("comments.id", "DESC")
                        ->select(
                            "users.name AS username",
                            "comments.comment",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url")
                        )->get();
        
        $data['branch'] = $branch;        
        $data['mealCategories'] = $mealCategories;
        $data['comments'] = $comments;

        $userAverageRate = round((($branch->user_cleanliness_rate + $branch->user_service_rate + $branch->user_quality_rate) /3 ));
        $branch->userAverageRate = $userAverageRate;
        
        
        

        return view("Site.pages.restaurant-page", $data);
    }
}
