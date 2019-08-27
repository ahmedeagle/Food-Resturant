<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
class MealController extends Controller
{
    public function get_list_of_meals_inside_branch(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $recommend  = (App()->getLocale() == 'ar') ? 'ينصح بها' : 'Recommended' ;
        $rules      = [
            "id" => "required|exists:branches,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.branch_id_exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");

        $meals = DB::table("meals")
                    // ->where("meals.mealCategory_id" ,$cat->cat_id)
                    ->where("meals.published" , "1")
                    ->where("meals.recommend" , "1")
                    ->where("meals.branch_id" , $id)
                    ->select("meals.id AS meal_id",
                            "meals." . $name . "_name AS meal_name",
                            "meals.price AS meal_price")
                    ->orderBy("meals.id" , "DESC")
                    ->get();
    
        foreach($meals as $meal){

          $meal ->  meal_price = 
            (new GeneralController())->numberTranslator($meal -> meal_price,App()->getLocale());

            $data = DB::table("meal_images")
                        ->join("images" , "images.id" , "meal_images.image")
                        ->where("meal_images.meal_id" , $meal->meal_id)
                        ->select(
                              DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                            )
                        ->first();
            if($data){
                $meal->meal_image_url = $data->meal_image_url;   
            }else{
                $meal->meal_image_url = "";
            }
        }

        $add_cat = [
                "cat_id"    => "0",
                "cat_name"  => $recommend,
                "meals"     => $meals
        ];
        $cats =  DB::table("mealcategories")
                    ->join("meals" , "meals.mealCategory_id" , "mealcategories.id")
                    ->where("meals.branch_id" , $id)
                    ->where("meals.published" , 1)
                    ->groupBy("mealcategories.id")
                    ->select(
                        "mealcategories.id AS cat_id",
                        "mealcategories." . $name . "_name AS cat_name"
                    )
                    //->groupBy("mealcategories.id")
                    ->orderBy("mealcategories.id" , "DESC")
                    ->get()
                    ->prepend($add_cat);


        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "cats" => $cats]);
    }
    public function get_meals_cat(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "branch_id" => "required|exists:branches,id"
        ];
        
        if($request->input('id') == 0){
            $rules['id'] = "required";
        }else{
            $rules['id'] = "required|exists:mealcategories,id";
        }
        $messages   = [
            "required"     => 1,
            "id.exists"     => 2,
            "branch_id.exists" => 4
            
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.subCategory_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.branch_id_exists")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        $brnach_id = $request->input("branch_id");
        
        if($id != 0){
            $filter = [
                "meals.mealCategory_id" => $id
            ];
        }else{
            $filter = [
                "meals.recommend" => "1"
            ];
        }
        
        $meals = DB::table("meals")
                    ->where($filter)
                    ->where("meals.published" , "1")
                    ->where("meals.branch_id" , $brnach_id)
                    ->select("meals.id AS meal_id",
                        "meals." . $name . "_name AS meal_name",
                        "meals.price AS meal_price")
                    ->orderBy("meals.id" , "DESC")
                    ->get();
                
        foreach($meals as $meal){
            $data = DB::table("meal_images")
                    ->join("images" , "images.id" , "meal_images.image")
                    ->where("meal_images.meal_id" , $meal->meal_id)
                    ->select(
                      DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                    )->first();
            if($data){
                $meal->meal_image_url = $data->meal_image_url;
            }else{
                $meal->meal_image_url = "";
            }
        }
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "meals" => $meals]);
    }
    public function get_meal_details(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "id" => "required|exists:meals,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.meal_id_exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input('id');
        $meal = DB::table("meals")
                    ->where("meals.id" , $id)
                    ->select(
                        "meals.id AS meal_id",
                        "meals." . $name . "_name AS name",
                        "meals." . $name . "_description AS description",
                        "meals.recommend",
                        "meals.spicy",
                        "meals.spicy_degree",
                        "meals.vegetable",
                        "meals.gluten",
                        "meals.price",
                        "meals.calories"
                    )->first();


        // add meal images
        $images = DB::table("meal_images")
                ->join("meals" , "meals.id" , "meal_images.meal_id")
                ->join("images" , "images.id" , "meal_images.image")
                ->where("meal_images.meal_id" , $id)
                ->select(
                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                )->get();
        $meal->images = $images;

        // add meal options
        $options = DB::table("meal_options")
                    ->where("meal_id" ,$meal->meal_id)
                    ->select(
                        "meal_options.id AS option_id",
                        "meal_options.ar_name AS option_name",
                        "meal_options.added_price AS option_added_price"
                    )->get();
        $meal->options = $options;

        // add meal adds
        $adds = DB::table("meal_adds")
                ->where("meal_id" ,$meal->meal_id)
                ->select(
                    "meal_adds.id AS adds_id",
                    "meal_adds.ar_name AS adds_name",
                    "meal_adds.added_price AS adds_added_price"
                )->get();
        $meal->adds = $adds;

        // add meal sizes //
        $sizes = DB::table("meal_sizes")
                ->where("meal_id" ,$meal->meal_id)
                ->select(
                    "meal_sizes.id AS size_id",
                    "meal_sizes.ar_name AS size_name",
                    "meal_sizes.price AS size.added_price"
                )->orderBy('meal_sizes.price' , "ASC")->get();
        $meal->sizes = $sizes;

        if(count($sizes) != 0){
                $meal->price = "";
        }
    
        return response()->json([
                                "status" => true, 
                                "errNum" => 0 , 
                                "msg" => trans('messages.success') , 
                                "meal" => $meal
                                ]);
    }
}
