<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use LaravelLocalization;

class HomeController extends Controller
{
    public function index(){
        
 
        $data['offers']  = $this->get_home_page_offers();

        $data['cats'] = $this->get_home_page_cats();
        $data['settings'] = DB::table("app_settings")->first();

 
        $data['class']  = "front-page page-template";
        $data['title']  = " - الرئيسية";

        return view("Site.pages.index", $data);
    }


//cron job function

 public function check_subscription(){
        
         date_default_timezone_set('Asia/Riyadh');
          $now =  date("H:i:s", time());
          $now = strtotime($now);
          
          
            //one month subscription 
            
            
          $time_in_min = 30 * 24 *  60; 
          
          
          
         
          $providers = DB::table('providers')
                                 ->where('has_subscriptions',1)
                                ->whereIn('subscriptions_period',[1,2])
                              //  ->where(DB::raw($now), '<=', DB::raw('created_at + INTERVAL'.' '.$time_in_min.' '.'MINUTE'))
                                ->select('id', 'has_subscriptions','accountactivated','created_at','subscriptions_period')
                                ->get();
               
            if(isset($providers) && $providers ->count() > 0 ){
                
                    foreach($providers AS $provider){
                        
                           $created_at = strtotime($provider->created_at);
                           $diff = round(abs($now - $created_at) / 60,2);
                            
                            
                           $expire = ($provider -> subscriptions_period) == 1 ?   $time_in_min :  ($time_in_min * 12) ;
                           
                           if($diff >=  $expire){
                                  
                                  
                                   DB::table("providers")->where('id', $provider -> id)
                                  ->update([
                                      
                                             'has_subscriptions' => "0",
                                             'accountactivated'  => "0",
                                             
                                         ]);
                                   
                                }
                          
                                
                        }
                         
            }
            
            
        } 
    public function register(){

        // get categories list
        $data['cats'] = DB::table("categories")->get();

        // get countries list
        $data['countries'] = DB::table("countries")->where("active", "1")->get();

        $data['title'] = " - حساب جديد";
        $data['class'] = "page-template register";

        return view("Site.pages.register", $data);
    }
    
    public function login(){

        $data['title'] = " - تسجيل الدخول";
        $data['class'] = "page-template login";

        return view("Site.pages.login", $data);
    }

    public function get_home_page_offers(){

        $request = new Request();
        
         $offers = DB::table("offers")
                ->join("images", "images.id" , "offers.image_id")
                ->join("providers", "providers.id" , "offers.provider_id")
                ->join("branches", "providers.id" , "branches.provider_id")
                ->where("offers.approved" , "1")
                ->select(
                        "branches.id AS branch_id",
                        "branches.longitude",
                        "branches.latitude",
                        "branches.ar_address AS address",
                        "offers.provider_id",
                        "offers.provider_id.lft",
                        "offers.".LaravelLocalization::getCurrentLocale()."_title AS title",
                    
                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/offers/', images.name) AS image_url"),
                    "providers.accept_order"
                )
                    ->orderBy("offers.lft")
                    ->get();
                    
        
        (new \App\Http\Controllers\Apis\User\HomeController())->filter_offers_branches($request,LaravelLocalization::getCurrentLocale(), $offers);
        
        return $offers;

    }
    

    public function get_home_page_cats($paginate = false){

        $request = new Request();

        if(!$paginate) {


            $cats = DB::table("subcategories")
                    ->join("images", "subcategories.image_id", "images.id")
                    ->select(
                        "subcategories.*",
                        DB::raw("CONCAT('" . url('/') . "','/storage/app/public/subcategories/', images.name) AS image_url")
                    )
                    ->orderBy("order_level", "DESC")
                    ->take(8)
                    ->get();

        }else{
            $cats = DB::table("subcategories")
                    ->join("images", "subcategories.image_id", "images.id")
                    ->select(
                        "subcategories.*",
                        DB::raw("CONCAT('" . url('/') . "','/storage/app/public/subcategories/', images.name) AS image_url")
                    )
                    ->paginate(8);
        }
        //(new \App\Http\Controllers\Apis\User\HomeController())->filter_providers_branches_by_distance($request,"ar", $cats,1);

        return $cats;
    }
    

}
