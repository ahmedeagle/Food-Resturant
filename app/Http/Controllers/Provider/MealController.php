<?php

namespace App\Http\Controllers\Provider;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use LaravelLocalization;
class MealController extends Controller
{
    public function get_food_menu_list(){
        $data['title'] = "- قائمة الطعام ";
        $data['class'] = "page-template food-menu";

        return view("Provider.pages.food-menu", $data);
    }

    public function get_add_meal(){

   //     App()->setLocale("ar");
        $data['title'] = " - صنف جديد";
        $data['class'] = "page-template food-menu";
        $data['cats']  = DB::table("mealcategories")
                                ->where("provider_id", auth("provider")->id())
                                ->select(
                                    "id AS id",
                                    LaravelLocalization::getCurrentLocale()."_name AS name"
                                )->get();

        if(count($data['cats']) == 0){
            return redirect("/restaurant/food-menu/categories")->with("warning", trans("provider.add_cat_first"));
        }


        $data['branches'] = DB::table("branches")
                            ->where("provider_id", auth("provider")->id())
                            ->select(
                                "id",
                                LaravelLocalization::getCurrentLocale()."_name AS name"
                            )
                            ->get();

        if(count($data['branches']) == 0){
            return redirect("/restaurant/branches/new-branch")->with("warning", trans("provider.add_branch_first"));
        }

        return view("Provider.pages.new-meal", $data);

    }

    public function post_add
            "ar_name"           =>_meal(Request $request){
       // App()->setLocale("ar");

        $rules = [ "required",
            "en_name"           => "required",
            "category"          => "required|exists:mealcategories,id",
            "component"         => "required",
            "available"         => "required|in:0,1",
            "spicy"             => "required|in:0,1",
            "vegetable"         => "required|in:0,1",
            "gluten"            => "required|in:0,1",
            "calorie"           => "required|numeric",
            "ar_description"    => "required",
            "en_description"    => "required",
            "size1"             => "required",
            "price1"            => "required|numeric",
            "recommended"       => "required|in:1,0",
        ];
        $messages = [
            "required"              => 1,
            "category.exists"       => 2,
            "in"                    => 3,
            "calorie.numeric"       => 4,
            "price1.numeric"        => 5,
        ];

        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.success"),
            3  => trans("messages.error"),
            4  => trans("provider.calorie_numeric"),
            5  => trans("provider.price_numeric"),
            6  => trans("messages.success"),
            7  => trans("messages.error"),
            8  => trans("messages.recommended_number")
        ];

        if($request->input("spicy") == "1"){
            $rules['spicy-degree'] = "required";
        }
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        if($request->input("recommended") == "1"){

            $recommend = DB::table("meals")
                ->where("mealCategory_id" , $request->input("category"))
                ->where("recommend", "1")
                ->where("branch_id", $request->input("branch"))
                ->get();

            if(count($recommend) >= 3){
                return response()->json(['status' => false, 'errNum' => 8, 'msg' => $msg[8]]);
            }

        }

        
        $data = [
            "ar_name"           => $request->input("ar_name"),
            "en_name"           => $request->input("en_name"),
            "ar_description"    => $request->input("ar_description"),
            "en_description"    => $request->input("en_description"),
            "calories"          => $request->input("calorie"),
            "mealCategory_id"   => $request->input("category"),
            "price"             => $request->input("price1"),
            "recommend"         => $request->input("recommended"),
            "available"         => $request->input("available"),
            "spicy"             => $request->input("spicy"),
            "vegetable"         => $request->input("vegetable"),
            "gluten"            => $request->input("gluten"),
        ];
        
        
         if($request->input("spicy") == "1"){
            $data["spicy_degree"]  = $request->input("spicy-degree");
        }

        if($request->input("branch") != 0){
            $data["branch_id"]  = $request->input("branch");
            $allBranches = false;
                // insert meal data
                $meal = DB::table("meals")
                                ->insertGetId(
                                    $data
                                );
                        
            $this -> storeMealData($meal,$request);
        }else{
              
           
            $allBranches = true;
             
            $branches = DB::table("branches")
                            ->where("provider_id", auth("provider")->id())
                            ->where("deleted", "0")
                            ->where("published", "1")
                            ->select('id')
                            ->get();
                            
            if(isset($branches) &&  $branches -> count() > 0)                
            {
                foreach($branches as $branch){
                    
                    $data["branch_id"]  = $branch -> id;
                    
                     // insert meal data
                    $meal = DB::table("meals")
                                    ->insertGetId(
                                        $data
                                    );
                                    
                                    
                                            
                             if($request->hasFile("0")){
            
                        for($i = 0; $i <= $request->input("count") -1; $i++){
            
                            $request->$i->store('meals', 'public');
            
                            $img_id = DB::table("images")
                                ->insertGetId([
                                    "name" => $request->$i->hashName()
                                ]);
            
                            DB::table("meal_images")
                                        ->insert([
                                            "meal_id" => $meal,
                                            "image" => $img_id
                                        ]);
                        }
            
                    }
                            
                    
                           
                                    
                                    
                    $this -> storeMealData($meal,$request);
                    
                } 
            }    
            
            
            
        }
       
         
        

        $componentArr = explode(",", $request->input("component"));

        foreach ($componentArr as $c){

            DB::table("meal_component")
                        ->insert([
                            "ar_name" => (string)$c,
                            "en_name" => (string)$c,
                            "meal_id" => $meal
                        ]);
        }




     if($request->input("branch") != 0){
             
             
              if($request->hasFile("0")){
    
                for($i = 0; $i <= $request->input("count") -1; $i++){
    
                    $request->$i->store('meals', 'public');
    
                    $img_id = DB::table("images")
                        ->insertGetId([
                            "name" => $request->$i->hashName()
                        ]);
    
                    DB::table("meal_images")
                                ->insert([
                                    "meal_id" => $meal,
                                    "image" => $img_id
                                ]);
                }
    
            }
            
              
            
        }
        
    
    
        return response()->json(["status" => true, "errNum" => 0, "msg" => trans("messages.success")]);
    }
    
    
    public function storeMealData($meal,$request){
        
        
        $this->add_meal_size($meal, $request->input("size1"),$request->input("size1_en"), $request->input("price1"));

        if($request->input("size2") && $request->input("price2")) {
            $this->add_meal_size($meal, $request->input("size2"),$request->input("size2_en"), $request->input("price2"));
        }
        if($request->input("size3") && $request->input("price3")) {
            $this->add_meal_size($meal, $request->input("size3"),$request->input("size3_en"), $request->input("price3"));
        }

        if($request->input("size4") && $request->input("price4")) {
            $this->add_meal_size($meal, $request->input("size4"),$request->input("size4_en"), $request->input("price4"));
        }

        if($request->input("size5") && $request->input("price5")) {
            $this->add_meal_size($meal, $request->input("size5"),$request->input("size5_en"), $request->input("price5"));
        }


        if($request->input("add1") && $request->input("add-price1")) {
            $this->add_meal_adds($meal, $request->input("add1"),$request->input("add1_en"), $request->input("add-price1"));
        }

        if($request->input("add2") && $request->input("add-price2")) {
            $this->add_meal_adds($meal, $request->input("add2"), $request->input("add2_en"), $request->input("add-price2"));
        }
        if($request->input("add3") && $request->input("add-price3")) {
            $this->add_meal_adds($meal, $request->input("add3"), $request->input("add3_en"), $request->input("add-price3"));
        }
        if($request->input("add4") && $request->input("add-price4")) {
            $this->add_meal_adds($meal, $request->input("add4"),$request->input("add4_en"), $request->input("add-price4"));
        }
        if($request->input("add5") && $request->input("add-price5")) {
            $this->add_meal_adds($meal, $request->input("add5"),$request->input("add5_en"), $request->input("add-price5"));
        }


        if($request->input("option1") && $request->input("option-price1")) {
            $this->add_meal_options($meal, $request->input("option1"),$request->input("option1_en"), $request->input("option-price1"));
        }

        if($request->input("option2") && $request->input("option-price2")) {
            $this->add_meal_options($meal, $request->input("option2"), $request->input("option2_en"),  $request->input("option-price2"));
        }
        if($request->input("option3") && $request->input("option-price3")) {
            $this->add_meal_options($meal, $request->input("option3"), $request->input("option3_en"), $request->input("option-price3"));
        }
        if($request->input("option4") && $request->input("option-price4")) {
            $this->add_meal_options($meal, $request->input("option4"),$request->input("option4_en"), $request->input("option-price4"));
        }
        if($request->input("option5") && $request->input("option-price5")) {
            $this->add_meal_options($meal, $request->input("option5"),$request->input("option5_en"), $request->input("option-price5"));
        }


    }

    public function get_meals(){

       // App()->setLocale("ar");

        $data['title'] = " - كل الأصناف";
        $data['class'] = "page-template food-menu all-kinds";

        // check authentication
        if(auth("provider")->check()){
            $filter = ["providers.id" => auth("provider")->id()];
        }elseif(auth("branch")->check()){
            $filter = ["branches.id" => auth("branch")->id()];
        }
        // get provider meal
        $data["meals"] = DB::table("meals")
                            ->join("branches", "branches.id", "meals.branch_id")
                            ->join("providers", "providers.id", "branches.provider_id")
                            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
                            ->where($filter)
                            ->where("meals.deleted", "0")
                            ->select(
                                "meals.id AS meal_id",
                                "meals.".LaravelLocalization::getCurrentLocale()."_name AS meal_name",
                                "mealcategories.".LaravelLocalization::getCurrentLocale()."_name AS cat_name",
                                "meals.published",
                                "branches.".LaravelLocalization::getCurrentLocale()."_name AS branch_name"
                            )->paginate(12);

        return view("Provider.pages.meals", $data);
    }

    public function get_edit_meal($id){

        if(!$this->check_id($id)){
            return redirect("/restaurant/dashboard");
        }

        $data['title'] = " - صنف جديد";
        $data['class'] = "page-template food-menu";

        $data["meal"] = DB::table("meals")
                                ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
                                ->where("meals.id", $id)
                                ->select(
                                    "meals.*",
                                    "mealcategories.id AS cat_id",
                                    "mealcategories.".LaravelLocalization::getCurrentLocale()."_name AS cat_name"
                                )->first();

        if(!$data['meal']){
            return redirect("/restaurant/dashboard");
        }
        $data["images"] = DB::table("meal_images")
                            ->join("images", "images.id", "meal_images.image")
                            ->where("meal_images.meal_id", $id)
                            ->select(
                                "images.id AS image_id",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                            )->get();

        $data['sizes'] = DB::table("meal_sizes")
                            ->where("meal_id", $id)
                            ->select(
                                "id AS size_id",
                           "ar_name AS size_name",
                                "price AS price"
                            )->get();


        $data['cats']  = DB::table("mealcategories")
                            ->select(
                                "id AS id",
                                LaravelLocalization::getCurrentLocale()."_name AS name"
                            )->get();

        $data['branches'] = DB::table("branches")
                            ->where("provider_id", auth("provider")->id())
                            ->select(
                                "id",
                                LaravelLocalization::getCurrentLocale()."_name AS name"
                            )
                            ->get();

        $component = DB::table("meal_component")
                                ->where("meal_id", $id)
                                ->select(
                                    LaravelLocalization::getCurrentLocale()."_name AS name"
                                )->get();

        $data['adds'] = DB::table("meal_adds")
                            ->where("meal_id", $id)
                            ->select(
                                "id AS add_id",
                                "ar_name AS name",
                                "added_price AS price"
                            )->get();


        $data['options'] = DB::table("meal_options")
                            ->where("meal_id", $id)
                            ->select(
                                "id AS option_id",
                                "ar_name AS name",
                                "added_price AS price"
                            )->get();

        $data['component'] = "";
        foreach ($component as $key => $c){

            $delimeter = ($key == "") ? "" : ",";
            $data["component"] .= $delimeter . $c->name;
        }
        // return edit meal view
        return view("Provider.pages.edit-meal", $data);
    }

    public function post_edit_meal(Request $request){
       // App()->setLocale("ar");

        $rules = [
            "ar_name"           => "required",
            "en_name"           => "required",
            "category"          => "required|exists:mealcategories,id",
            "component"         => "required",
            "available"         => "required|in:0,1",
            "spicy"             => "required|in:0,1",
            "vegetable"         => "required|in:0,1",
            "gluten"            => "required|in:0,1",
            "calorie"           => "required|numeric",
            "ar_description"    => "required",
            "en_description"    => "required",
            "size1"             => "required",
            "price1"            => "required|numeric",
            "recommended"       => "required|in:1,2",
        ];
        $messages = [
            "required"              => 1,
            "category.exists"       => 2,
            "in"                    => 3,
            "calorie.numeric"       => 4,
            "price1.numeric"        => 5,
        ];

        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.success"),
            3  => trans("messages.error"),
            4  => trans("provider.calorie_numeric"),
            5  => trans("provider.price_numeric"),
            6  => trans("messages.success"),
            7  => trans("messages.error"),
            8  => trans("messages.recommended_number")
        ];

        if($request->input("spicy") == "1"){
            $rules['spicy-degree'] = "required";
        }

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $meal = $request->input("meal_id");

        if($request->input("recommended") == "1"){

            $recommend = DB::table("meals")
                ->where("mealCategory_id" , $request->input("category"))
                ->where("recommend", "1")
                ->where("branch_id", $request->input("branch"))
                ->where("meals.id" , "!=" , $meal)
                ->get();

            if(count($recommend) >= 3){
                return response()->json(['status' => false, 'errNum' => 8, 'msg' => $msg[8]]);
            }

        }

        // insert meal data

        $data = [
            "ar_name"           => $request->input("ar_name"),
            "en_name"           => $request->input("en_name"),
            "ar_description"    => $request->input("ar_description"),
            "en_description"    => $request->input("en_description"),
            "calories"          => $request->input("calorie"),
            "mealCategory_id"   => $request->input("category"),
            "price"             => $request->input("price1"),
            "recommend"         => $request->input("recommended"),
            "branch_id"         => $request->input("branch"),
            "available"         => $request->input("available"),
            "spicy"             => $request->input("spicy"),
            "vegetable"         => $request->input("vegetable"),
            "gluten"            => $request->input("gluten"),
        ];

        if($request->input("spicy") == "1"){
            $data["spicy_degree"] = $request->input("spicy-degree");
        }else{
            $data['spicy_degree'] = 0;
        }

        DB::table("meals")
                    ->where("id", $meal)
                    ->update($data);


        // delete meal sizes
        DB::table("meal_sizes")
                    ->where("meal_id", $meal)
                    ->delete();

        $this->add_meal_size($meal, $request->input("size1"), $request->input("price1"));

        if($request->input("size2") && $request->input("price2")) {
            $this->add_meal_size($meal, $request->input("size2"), $request->input("price2"));
        }
        if($request->input("size3") && $request->input("price3")) {
            $this->add_meal_size($meal, $request->input("size3"), $request->input("price3"));
        }

        if($request->input("size4") && $request->input("price4")) {
            $this->add_meal_size($meal, $request->input("size4"), $request->input("price4"));
        }

        if($request->input("size5") && $request->input("price5")) {
            $this->add_meal_size($meal, $request->input("size5"), $request->input("price5"));
        }

        // delete meal adds
        DB::table("meal_adds")
            ->where("meal_id", $meal)
            ->delete();

        if($request->input("add1") && $request->input("add-price1")) {
            $this->add_meal_adds($meal, $request->input("add1"), $request->input("add-price1"));
        }

        if($request->input("add2") && $request->input("add-price2")) {
            $this->add_meal_adds($meal, $request->input("add2"), $request->input("add-price2"));
        }
        if($request->input("add3") && $request->input("add-price3")) {
            $this->add_meal_adds($meal, $request->input("add3"), $request->input("add-price3"));
        }
        if($request->input("add4") && $request->input("add-price4")) {
            $this->add_meal_adds($meal, $request->input("add4"), $request->input("add-price4"));
        }
        if($request->input("add5") && $request->input("add-price5")) {
            $this->add_meal_adds($meal, $request->input("add5"), $request->input("add-price5"));
        }


        // delete meal options
        DB::table("meal_options")
            ->where("meal_id", $meal)
            ->delete();

        if($request->input("option1") && $request->input("option-price1")) {
            $this->add_meal_options($meal, $request->input("option1"), $request->input("option-price1"));
        }

        if($request->input("option2") && $request->input("option-price2")) {
            $this->add_meal_options($meal, $request->input("option2"), $request->input("option-price2"));
        }
        if($request->input("option3") && $request->input("option-price3")) {
            $this->add_meal_options($meal, $request->input("option3"), $request->input("option-price3"));
        }
        if($request->input("option4") && $request->input("option-price4")) {
            $this->add_meal_options($meal, $request->input("option4"), $request->input("option-price4"));
        }
        if($request->input("option5") && $request->input("option-price5")) {
            $this->add_meal_options($meal, $request->input("option5"), $request->input("option-price5"));
        }

        DB::table("meal_component")
                ->where("meal_id", $meal)
                ->delete();

        $componentArr = explode(",", $request->input("component"));

        foreach ($componentArr as $c){

            DB::table("meal_component")
                ->insert([
                    "ar_name" => (string)$c,
                    "en_name" => (string)$c,
                    "meal_id" => $meal
                ]);
        }

        $deletedImages = explode(",", $request->input("deletedId"));
        foreach($deletedImages as $img){
            DB::table("meal_images")
                    ->where("image", $img)
                    ->where("meal_id", $meal)
                    ->delete();
            DB::table("images")
                        ->where("id", $img)
                        ->delete();

            // remove image from the storage folder
        }

        if($request->hasFile("0")){

            for($i = 0; $i <= $request->input("count") -1; $i++){

                $request->$i->store('meals', 'public');

                $img_id = DB::table("images")
                    ->insertGetId([
                        "name" => $request->$i->hashName()
                    ]);

                DB::table("meal_images")
                    ->insert([
                        "meal_id" => $meal,
                        "image" => $img_id
                    ]);
            }

        }

        return response()->json(["status" => true, "errNum" => 0, "msg" => trans("messages.success")]);
    }

    public function stop_meal($id){
       // App()->setLocale('ar');
        //App()->setLocale('ar');
        if(!$this->check_id($id)){
            return redirect("/restaurant/dashboard");
        }

        DB::table("meals")
                ->where("id", $id)
                ->update([
                    "published" => "0"
                ]);

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function activate_meal($id){
       // App()->setLocale('ar');

        if(!$this->check_id($id)){
            return redirect("/restaurant/dashboard");
        }

        DB::table("meals")
            ->where("id", $id)
            ->update([
                "published" => "1"
            ]);

        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function delete_meal($id){
       // App()->setLocale('ar');

        if(!$this->check_id($id)){
            return redirect("/restaurant/dashboard");
        }

        $filter = ["1", "2", "3"];

        $orders = DB::table("order_meals")
                    ->join("orders", "order_meals.order_id", "orders.id")
                    ->where("order_meals.meal_id", $id)
                    ->select(
                        "orders.order_status_id AS status_id"
                    )
                    ->get();

        if(count($orders) == 0){
            // remove the meal
            DB::table("meals")
                ->where("id", $id)
                ->delete();
            return redirect()->back()->with("success", trans("messages.success"));
        }
        foreach($orders as $order){
            if(in_array($order->status_id, $filter)){
                // return error
                return redirect()->back()->with("error", trans("provider.cannot_remove_meal"));
            }else{
                // update deleted column with value 1
                DB::table("meals")
                    ->where("id", $id)
                    ->update([
                        "deleted"  => "1"
                    ]);

                return redirect()->back()->with("success", trans("messages.success"));
            }
        }

    }

    public function get_meal_categories(){

       // App()->setLocale("ar");
        $data['title'] = " - التصنيفات";
        $data['class'] = "page-template food-menu category";

        $data['cats'] = DB::table("mealcategories")
                            ->where("provider_id", auth("provider")->id())
                            ->where("deleted", "0")
                            ->select(
                                "id AS cat_id",
                                LaravelLocalization::getCurrentLocale()."_name AS name",
                                "published"
                            )->get();

        foreach($data['cats'] as $c){
            $meals = DB::table("meals")
                            ->where("mealCategory_id", $c->cat_id)
                            ->count();
            $c->count = $meals;
        }


        return view("Provider.pages.meal-categories", $data);
    }



    public function get_edit_meal_cat($id){

        $cat = $this->check_cat($id);
        if($cat == false){
            return redirect("/restaurant/dashboard");
        }

        $data['title'] = " -تعديل التصنيف ";
        $data["class"] = "page-template food-menu";
        $data['cat'] = $cat;

        return view("Provider.pages.edit-cat", $data);
    }

    public function post_edit_meal_cat(Request $request){
       // App()->setLocale("ar");
        $rules = [

            "ar_name"   => "required",
            "en_name"   => "required",
            "id"        => "required"
        ];
        $messages = [
            "required"  => trans("messages.required"),
        ];


        $this->validate($request, $rules , $messages);

        $arName = $request->input('ar_name');
        $enName = $request->input('en_name');
        $id     = $request->input('id');

        DB::table("mealcategories")
                    ->where("id", $id)
                    ->update([
                        "ar_name" => $arName,
                        "en_name" => $enName
                    ]);

        return redirect("/restaurant/food-menu/categories")->with("success", trans("messages.success"));
    }

    public function post_new_cat(Request $request){
       // App()->setLocale("ar");
        $rules = [

            "ar_name"   => "required",

        ];
        $messages = [
            "required"  => trans("messages.required"),
        ];


        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect("/restaurant/food-menu/categories#add-meal-cat-form")->withErrors($validator)->withInput();
        }

        $arName = $request->input('ar_name');

        DB::table("mealcategories")
            ->insert([
                "ar_name" => $arName,
                "en_name" => "",
                "provider_id" => auth("provider")->id()
            ]);



        return redirect("/restaurant/food-menu/categories")->with("success", trans("messages.success"));
    }

    public function get_stop_meal_cat($id){
       // App()->setLocale("ar");
        $cat = $this->check_cat($id);
        if($cat == false){
            return redirect("/restaurant/dashboard");
        }

        DB::table("mealcategories")
                ->where("id", $cat->id)
                ->update([
                   "published" => "0"
                ]);
        return redirect("/restaurant/food-menu/categories")->with("success", trans("messages.success"));
    }

    public function get_activate_meal_cat($id){
        //App()->setLocale("ar");
        $cat = $this->check_cat($id);
        if($cat == false){
            return redirect("/restaurant/dashboard");
        }

        DB::table("mealcategories")
            ->where("id", $cat->id)
            ->update([
                "published" => "1"
            ]);
        return redirect("/restaurant/food-menu/categories")->with("success", trans("messages.success"));
    }
    public function get_delete_meal_cat($id){
       // App()->setLocale("ar");
        $cat = $this->check_cat($id);
        if($cat == false){
            return redirect("/restaurant/dashboard");
        }

        DB::table("mealcategories")
            ->where("id", $cat->id)
            ->update([
                "deleted" => "1"
            ]);
        return redirect("/restaurant/food-menu/categories")->with("success", trans("messages.success"));
    }

    protected function check_cat($id){
        $check = DB::table("mealcategories")
                    ->where("id", $id)
                    ->where("provider_id", auth("provider")->id())
                    ->first();

        if(!$check){
            return false;
        }else{
            return $check;
        }
    }
    protected function check_id($id){

        if(auth("provider")->check()){
            $filter = ["providers.id" => auth("provider")->id()];
        }elseif(auth("branch")->check()){
            $filter = ["branches.id" => auth("branch")->id()];
        }

        $data = DB::table("meals")
                    ->join("branches", "branches.id", "meals.branch_id")
                    ->join("providers", "providers.id", "branches.provider_id")
                    ->where("meals.id", $id)
                    ->where($filter)
                    ->first();

        $response =  (!$data) ? false : true;

        return $response;
    }

    protected function add_meal_size($meal_id, $ar_name,$en_name, $price){
        DB::table("meal_sizes")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "price"   => $price
            ]);
    }

    protected function add_meal_adds($meal_id, $ar_name,$en_name,$price){
        DB::table("meal_adds")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price"   => $price
            ]);
    }

    protected function add_meal_options($meal_id, $ar_name,$en_name, $price){
        DB::table("meal_options")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price"   => $price
            ]);
    }
}
