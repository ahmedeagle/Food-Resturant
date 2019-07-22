<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use guard;
class FavoritController extends Controller
{
    public function get_favorites(){
        $data['title'] = ' - المفضلة';
        $data['class'] = 'front-page page-template';
        
        
          $lat   = auth('web')  -> user() -> latitude;
         $long   = auth('web')  -> user() -> longitude;


        $branches  = DB::table("provider_favorits")
                                             ->join("branches" , "branches.id" ,"provider_favorits.provider_id")
                                            ->join("providers" , "providers.id" , "branches.provider_id")
                                            ->join('images' , 'images.id' , 'providers.image_id')
                                            ->where('provider_favorits.user_id' ,  auth('web')->id())
                                            ->where('branches.published' , "1")
                                            ->orderBy('branches.id' , 'DESC')
                                            ->select(
                                                     "branches.id AS branch_id",
                                                     "branches.ar_address AS address" ,
                                                     "branches.latitude" ,
                                                     "branches.longitude",
                                                      "branches.has_delivery",
                                                      "branches.has_booking",
                                                      "branches.average_price AS mealAveragePrice",
                                                      DB::raw("CONCAT(providers .ar_name,'-',branches .ar_name) AS name"),
                                                      DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                                     "providers.id AS provider_id"
                                                    )
                                            ->get();
                    
                    
                    
                    if(isset($branches) && $branches -> count() > 0){
                        
                        
                        foreach($branches as $branch){
                            
                            
                            $branch -> id  = $branch -> branch_id;
                        }

                        
                    }
                    
                       $request = new Request();
                       
                       (new \App\Http\Controllers\Apis\User\HomeController())->filter_providers_branches($request,'ar',$branches);
                        
        return view("User.pages.favorite.favorites", $data)-> with('branches',$branches);
    }

    public function remove($id){

       // App()->setLocale("ar");
        $check = DB::table("branches")
                    ->where("branches.id", $id)
                    ->select(
                        "branches.id"
                    )
                    ->first();

        if(!$check){
            return redirect("/user/dashboard");
        }

        DB::table("provider_favorits")
                ->where("user_id", auth('web')->id())
                ->where("provider_id", $check-> id)
                ->delete();

        return redirect()->back()->with("success", trans("messages.success"));

    }
    public function add($id){


        //App()->setLocale("ar");
        $check = DB::table("branches")
                    ->join("providers", "providers.id", "branches.provider_id")
                    ->where("branches.id", $id)
                    ->select(
                        "branches.id AS provider_id" 
                    )
                    ->first();

        if(!$check){
            return redirect("/user/dashboard");
        }

        $fav = DB::table("provider_favorits")
                    ->where("user_id", auth('web')->id())
                    ->where("provider_id", $check->provider_id)
                    ->first();

        if($fav){
            return redirect()->back()->with("error", trans("messages.error"));
        }
        DB::table("provider_favorits")
                    ->insert([
                        "user_id" => auth('web')->id(),
                        "provider_id" => $check->provider_id
                    ]);

        return redirect()->back()->with("success", trans("messages.success"));

    }
}

