<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class HelperController extends Controller
{
    public static function get_provider_image_path($provider_id){
        $provider = DB::table("providers")
                        ->join("images", "images.id", "providers.image_id")
                        ->where("providers.id", $provider_id)
                        ->select(
                            "images.name"
                        )->first();

        return $provider->name;

    }
    
    
    public static function get_provider_image_path2($id,$guard){
        
        
        if($guard == 'providers'){
            
            
             $provider = DB::table("providers")
                        ->join("images", "images.id", "providers.image_id")
                        ->where("providers.id", $id)
                        ->select(
                            "images.name"
                        )->first();
 
                   return $provider->name;
        
            
            
        } 
        
        
                     $branche = DB::table("images")
                                   
                                                ->join('branch_images','images.id','=','branch_images.image_id')
                                                ->where('branch_images.branch_id',$id)
                                                ->select(
                                                    "images.name"
                                                )->first();
 
                   return $branche->name;
                   
          
    }
    
    
    
    public static function get_provider_balance($provider_id){
        $balance = DB::table("balances")
                        ->where("actor_id", $provider_id)
                        ->where("actor_type", "provider")
                        ->first();
                        
        if($balance){
            return $balance->balance;
        }else{
            return 0;
        }
    }
}
