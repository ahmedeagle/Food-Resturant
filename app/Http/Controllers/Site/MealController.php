<?php

namespace App\Http\Controllers\Site;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
class MealController extends Controller
{
    public function get_meal_page($id){

      //  app()->setLocale("ar") ;
        
        $meal = DB::table("meals")
                        ->join("branches", "branches.id", "meals.branch_id")
                        ->join("providers", "providers.id", "branches.provider_id")
                        ->where("meals.id", $id)
                        ->where("meals.published", "1")
                        ->where("meals.deleted", "0")
                        ->select(
                            "meals.*",
                            "providers.accept_order"
                        )
                        ->first();
                        
                        
         if(!$meal){
            return redirect("/");
        }

         $images = DB::table("meal_images")
                    ->join("images", "meal_images.image", "images.id")
                    ->where("meal_images.meal_id", $id)
                    ->select(
                        DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                    )->get();
        
        $sizes = DB::table("meal_sizes")
                            ->where("meal_sizes.meal_id", $id)
                            ->orderBy("price", "ASEC")
                            ->get();
                            
          $options = DB::table("meal_options")
                        ->where("meal_options.meal_id", $id)
                        ->get();
                
         $adds = DB::table("meal_adds")
                        ->where("meal_adds.meal_id", $id)
                        ->get();
        

        $meal_sizes_check = [];
        $meal_options_check = [];
        $meal_adds_check = [];
        foreach($sizes as $size){
            $meal_sizes_check[] = $size->id;
        }

        foreach($options as $option){
            $meal_options_check[] = $option->id;
        }

        foreach($adds as $add){
            $meal_adds_check[] = $add->id;
        }

        $meal->images = $images;
        $meal->sizes = $sizes;
        $meal->options = $options;
        $meal->adds = $adds;
        
        $data['meal'] = $meal;


         // check if cart contain this meal
        $cardData = [];
        $cart = Session::get("basket");
         
        $data['clearing_cart_content_warning'] = 0;
        
        
        
        

         if($cart){
           foreach((array)$cart as $key => $item){

            $meal_branch = DB::table("meals")
                ->where("id", $item['meal_id'])
                ->first();

            if($meal_branch->branch_id != $meal->branch_id){
                $data['clearing_cart_content_warning'] = 1;
            }

            if($item['meal_id'] == $id){

                $optionCheck = $this->check_cart_options($meal_options_check, (array)$item['options']);
                $addCheck = $this->check_cart_adds($meal_adds_check, (array)$item['adds']);
                $sizeCheck = $this->check_cart_size($meal_sizes_check, $item['size']);

                if($optionCheck && $addCheck && $sizeCheck){


                    $cardData['key'] = $key;
                    $cardData['qty'] = $item['qty'];
                    $cardData['size'] = $item['size'];
                    $cardData['options'] = $item['options'];
                    $cardData['adds'] = $item['adds'];

                    $cardData['optionsPrice'] = 0;
                    $cardData['addsPrice'] = 0;

                    foreach($cardData['options'] as $option){
                        $options = DB::table("meal_options")
                                    ->where("id", $option)
                                    ->first();
                        $cardData['optionsPrice'] = $cardData['optionsPrice'] + (int)$options->added_price;
                    }

                    foreach($cardData['adds'] as $add){
                        $adds = DB::table("meal_adds")
                                    ->where("id", $add)
                                    ->first();
                        $cardData['addsPrice'] = $cardData['addsPrice'] + (int)$adds->added_price;
                    }

                    if($item['size'] == 0){
                       $cardData['price'] = ((int)$item["qty"]) * ((int)$meal->price + $cardData['optionsPrice'] + $cardData['addsPrice']);
                    }else{
                        $sizePrice = DB::table("meal_sizes")
                                            ->where("meal_id", $id)
                                            ->where("id", $item['size'])
                                            ->first();

                        $cardData['price'] =  ((int)$item["qty"]) * ((int)$sizePrice->price + $cardData['optionsPrice'] + $cardData['addsPrice']);
                    }
                    break;

                }

            }

        }
         }
        

        $data['title'] = "- صفحة الوجبة";
        $data['class'] = "page-template profile edit";

        $data['cartData'] = $cardData;

        return view("Site.pages.meal-page", $data);
    }

    public function check_cart_options($meal_options, $cart_options){

        foreach($cart_options as $option){

            if(!in_array($option, (array)$meal_options)){
                return false;
            }

        }
        return true;
    }

    public function check_cart_adds($meal_adds, $cart_adds){

        foreach($cart_adds as $add){

            if(!in_array($add, (array)$meal_adds)){
                return false;
            }
        }
        return true;

    }
    public function check_cart_size($meal_sizes, $cart_size){


        if(!in_array($cart_size, (array)$meal_sizes)){

            return false;

        }

        return true;

    }

}
