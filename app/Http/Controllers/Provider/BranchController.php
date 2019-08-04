<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Validator;
use LaravelLocalization;
class BranchController extends Controller
{
    public function get_branches(){

      //  App()->setLocale("ar");
        $data['branches'] = DB::table("branches")
                            ->where("branches.provider_id", auth("provider")->id())
                            ->where("branches.deleted", "0")
                            ->select(
                                "branches.id AS branch_id",
                                "branches.".LaravelLocalization::getCurrentLocale()."_name AS branch_name",
                                "branches.".LaravelLocalization::getCurrentLocale()."_address AS branch_address",
                                "branches.published"
                            )->get();

        $data['title'] = " - الفروع";
        $data['class'] = "page-template food-menu branches";

        return view("Provider.pages.branches", $data);
    }

    public function add_branch(){
        $data['title'] = " - إضافة فرع جديد";
        $data['class'] = "page-template food-menu";

        $data['cats'] = DB::table("categories")->get();
        $data['congestion'] = DB::table("congestion_settings")
                                ->select(
                                    "id",
                                    LaravelLocalization::getCurrentLocale()."_name AS name"
                                )->get();

        $data['options'] = DB::table("options")
                                ->select(
                                    "id",
                                    LaravelLocalization::getCurrentLocale()."_name AS name"
                                )->get();

        $data['week_days'] = [
            "saturday"  => 'السبت',
            "sunday"    => 'الأحد',
            "monday"    => 'الاثنين',
            "tuesday"   => 'الثلاثاء',
            "wednesday" => 'الأربعاء',
            "thursday"  => 'الخميس',
            "friday"    => 'الجمعة',
        ];
        
        $data['branches'] = DB::table('branches') -> where('branches.provider_id',auth('provider') -> id()) -> get() ;
        
        $data['meals'] = DB::table("meals")
                            ->join("branches", "branches.id", "meals.branch_id")
                            ->join("providers", "providers.id", "branches.provider_id")
                            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
                            ->where("providers.id", auth("provider")->id())
                            ->select(
                                "meals.id AS meal_id",
                                "meals.".LaravelLocalization::getCurrentLocale()."_name as meal_name",
                                "mealcategories.".LaravelLocalization::getCurrentLocale()."_name as cat_name"
                            )->get();
        return view("Provider.pages.new-branch", $data);
    }

    public function post_add_branch(Request $request){
        
        
         //App()->setLocale("ar");



        $rules = [
            "ar_name"            => "required",
            "en_name"            => "required",
            "service-provider"   => "required|exists:categories,id",
            "has-booking"        => "required|in:0,1",
            "has-delivery"       => "required|in:0,1",
            "has_payment"        => "required|in:0,1",
            "delivery-price"     => "required|numeric",
            "booking-features"   => "required",
            "congestion-status"  => "required|exists:congestion_settings,id",
            "average-price"      => "required|numeric",
            "address-text"       => "required",
            "lat"                => "required",
            "lng"                => "required",
            "phone-number"       => array('required','regex:/^(05|5)([0-9]{8})$/','unique:branches,phone'),
            "password"           => "required|min:6",


        ];
        $messages = [
            "required"                      => 1,
            "in"                            => 2,
            "min"                           => 3,
            "numeric"                       => 4,
            "exists"                        => 5,
            "phone-number.unique"           => 7,
            "phone-number.regex"            => 8,
        ];

        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.error"),
            3  => trans("messages.pasword_min"),
            4  => trans("messages.error"),
            5  => trans("messages.error"),
            6 => trans("messages.success"),
            7 => trans("messages.phone_unique"),
            8 => trans("messages.phonenotcorrect")
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
//return              $error = $validator->errors();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' =>   'dfkdfjfj']);
        }



        $data = [

            "ar_name" => $request->input("ar_name"),
            "en_name" => $request->input("en_name"),
            "has_booking" => $request->input("has-booking"),
            "has_delivery" => $request->input("has-delivery"),
            "has_payment" => $request->input("has_payment"),
            "booking_status" => $request->input("booking-features"),
            "delivery_price" => $request->input("delivery-price"),
            "ar_address" => $request->input("address-text"),
            "en_address" => "",
            "longitude" => $request->input("lng"),
            "latitude" => $request->input("lat"),
            'category_id'               => $request->input("service-provider"),
//            "start_working_time" => $request->input("start") . ":00:00",
//            "end_working_time" => $request->input("end") . ":00:00",
            "phone" => $request->input("phone-number"),
            "password" => bcrypt($request->input("password")),
            "provider_id"   => auth("provider")->id(),
            "congestion_settings_id" => $request->input("congestion-status"),
            "average_price" => $request->input("average-price"),
            "token"         => (new \App\Http\Controllers\Apis\User\GeneralController())->getRandomString(128),

        ];

        $id = DB::table("branches")
                        ->insertGetId($data);

        // working time
        $sat_start = ($request->input("saturday-start-working-hours-select")) ? $request->input("saturday-start-working-hours-select") . ":00:00" : null;
        $sat_end   = ($request->input("saturday-end-working-hours-select")) ? $request->input("saturday-end-working-hours-select") . ":00:00" : null;

        $sun_start = ($request->input("sunday-start-working-hours-select"))?$request->input("sunday-start-working-hours-select") . ":00:00" : null;
        $sun_end   = ($request->input("sunday-end-working-hours-select")) ? $request->input("sunday-end-working-hours-select") . ":00:00":null;

        $mon_start = ($request->input("monday-start-working-hours-select")) ? $request->input("monday-start-working-hours-select") . ":00:00":null;
        $mon_end   = ($request->input("monday-end-working-hours-select")) ? $request->input("monday-end-working-hours-select") . ":00:00":null;

        $tues_start = ($request->input("tuesday-start-working-hours-select")) ? $request->input("tuesday-start-working-hours-select") . ":00:00":null;
        $tues_end   = ($request->input("tuesday-end-working-hours-select")) ? $request->input("tuesday-end-working-hours-select") . ":00:00" : null;

        $wed_start = ($request->input("wednesday-start-working-hours-select")) ? $request->input("wednesday-start-working-hours-select") . ":00:00": null;
        $wed_end   = ($request->input("wednesday-end-working-hours-select")) ? $request->input("wednesday-end-working-hours-select") . ":00:00": null;

        $th_start = ($request->input("thursday-start-working-hours-select")) ? $request->input("thursday-start-working-hours-select") . ":00:00": null;
        $th_end   = ($request->input("thursday-end-working-hours-select")) ? $request->input("thursday-end-working-hours-select") . ":00:00": null;

        $fri_start = ($request->input("friday-start-working-hours-select")) ? $request->input("friday-start-working-hours-select") . ":00:00": null;
        $fri_end   = ($request->input("friday-end-working-hours-select"))? $request->input("friday-end-working-hours-select") . ":00:00": null;
        
        DB::table("branch_working_hours")
                ->insert([
                    "branch_id" => $id,
                    "saturday_start_work" => $sat_start,
                    "saturday_end_work" => $sat_end,
                    "sunday_start_work" => $sun_start,
                    "sunday_end_work" => $sun_end,
                    "monday_start_work" => $mon_start,
                    "monday_end_work" => $mon_end,
                    "tuesday_start_work" => $tues_start,
                    "tuesday_end_work" => $tues_end,
                    "wednesday_start_work" => $wed_start,
                    "wednesday_end_work" => $wed_end,
                    "thursday_start_work" => $th_start,
                    "thursday_end_work" => $th_end,
                    "friday_start_work" => $fri_start,
                    "friday_end_work" => $fri_end,
                ]);
        // images
        if($request->hasFile("0")){

            for($i = 0; $i <= $request->input("count") -1; $i++){

                $request->$i->store('branches', 'public');

                $img_id = DB::table("images")
                    ->insertGetId([
                        "name" => $request->$i->hashName()
                    ]);

                DB::table("branch_images")
                    ->insert([
                        "branch_id" => $id,
                        "image_id"  => $img_id
                    ]);
            }

        }

        // options
        $optionsArr = explode(",", $request->input("options"));
        foreach ($optionsArr as $option){
            DB::table("branch_options")
                    ->insert([
                        "branch_id" => $id,
                        "option_id" => $option
                    ]);
        }



        // meals
        $mealsArr = explode(",", $request->input("meals"));
        if(count($mealsArr) > 0){
            foreach ($mealsArr as $meal){
                DB::table("branch_meals")
                    ->insert([
                        "branch_id" => $id,
                        "meal_id" => $meal
                    ]);
            }
        }

        return response()->json(["status" => true, "errNum" => 0, "msg" => $msg[6]]);
    }

    public function edit_branch($id){
        
        $check = $this->check_branch_id($id);
        if(!$check){
            return redirect("/restaurant/dashboard");
        }

        $data['branch'] = DB::table("branches")
                            ->where("id", $id)
                            ->select(
                                "branches.*"
                            )->first();
                            
        $data['branches'] = DB::table('branches') -> where('branches.provider_id',auth('provider') -> id()) -> get() ;                    
                            
                            
 
        $data['congestion'] = DB::table("congestion_settings")
                                ->select(
                                    "id",
                                LaravelLocalization::getCurrentLocale()."_name AS name"
                                )->get();

        $data['images'] = DB::table("branch_images")
                            ->join("images", "images.id", "branch_images.image_id")
                            ->where("branch_id", $id)
                            ->select(
                                "images.id AS image_id",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/branches/', images.name) AS branch_image_url")
                            )->get();

        $data['options'] = DB::table("options")
                            ->select(
                                "id",
                                LaravelLocalization::getCurrentLocale()."_name as name"
                            )->get();

        $data['cats'] = DB::table("categories")
                                ->get();

        $data['week_days'] = [
            "saturday"  => 'السبت',
            "sunday"    => 'الأحد',
            "monday"    => 'الاثنين',
            "tuesday"   => 'الثلاثاء',
            "wednesday" => 'الأربعاء',
            "thursday"  => 'الخميس',
            "friday"    => 'الجمعة',
        ];


        $data['working_hours'] = DB::table("branch_working_hours")
            ->where("branch_id", $id)
            ->select(
            //DB::raw("IF(Saturday, Saturday,'') AS saturday")
                "saturday_start_work",
                "saturday_end_work",
                "sunday_start_work",
                "sunday_end_work",
                "monday_start_work",
                "monday_end_work",
                "tuesday_start_work",
                "tuesday_end_work",
                "wednesday_start_work",
                "wednesday_end_work",
                "thursday_start_work",
                "thursday_end_work",
                "friday_start_work",
                "friday_end_work"
            )
            ->first();

        foreach($data['working_hours'] as $key => $value){

            if($value == null){
                continue;
            }
            $val = explode(":", $value);
            $data['working_hours']->$key = $val[0];

        }

        foreach($data['options'] as $option){
            $check = DB::table("branch_options")
                        ->where("branch_id", $id)
                        ->where("option_id", $option->id)
                        ->first();
            if($check){
                $option->selected = "1";
            }else{
                $option->selected = "0";
            }
        }

         $data['meals'] = DB::table("meals")
                            ->join("branches", "branches.id", "meals.branch_id")
                            ->join("providers", "providers.id", "branches.provider_id")
                            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
                            ->where("providers.id", auth("provider")->id())
                            ->select(
                                "meals.id AS meal_id",
                                "meals.".LaravelLocalization::getCurrentLocale()."_name as meal_name",
                                "mealcategories.".LaravelLocalization::getCurrentLocale()."_name as cat_name"
                            )->get();

        foreach ($data['meals'] as $meal){
            $check = DB::table("branch_meals")
                        ->where("meal_id", $meal->meal_id)
                        ->where("branch_id", $id)
                        ->first();
            if($check){
                $meal->selected = "1";
            }else{
                $meal->selected = "0";
            }
        }

        $data['title'] = " - تعديل الفرع";
        $data['class'] = "page-template food-menu new-branch";
        return view("Provider.pages.edit-branch", $data);
    }

    public function post_edit_branch(Request $request){
        
         
 
        //App()->setLocale("ar");

        $rules = [
            "ar_name"            => "required",
            "en_name"            => "required",
            "has-booking"        => "required|in:0,1",
            "service-provider"   => "required|exists:categories,id",
            "has-delivery"       => "required|in:0,1",
             "has_payment"        => "required|in:0,1",
            "delivery-price"     => "required|numeric",
            "booking-features"   => "required",
            "congestion-status"  => "required|exists:congestion_settings,id",
            "average-price"      => "required|numeric",
            "address-text"       => "required",
            "lat"                => "required",
            "lng"                => "required",
            "phone-number"       => array('required','regex:/^(05|5)([0-9]{8})$/'),
            
        ];
        $messages = [
            "required"            => 1,
            "in"                  => 2,
            "min"                 => 3,
            "numeric"             => 4,
            "exists"              => 5,
            "phone-number.regex"  => 7
            
        ];

        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.error"),
            3  => trans("messages.error"),
            4  => trans("messages.error"),
            5  => trans("messages.error"),
            6 => trans("messages.success"),
            7 => trans("messages.phonenotcorrect"),
            8 => trans("messages.pasword_min"),
            
        ];
        
        $changePassword = false;
        if($request -> has('password')){
            
            if($request -> password !="" && $request -> password !=" " && $request -> password !=null){
                
                $rules['password'] = 'required|min:6';
                
                 $changePassword = true;
                
            }
            
             
        }

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }


     
      
        $data = [

            "ar_name" => $request->input("ar_name"),
            "en_name" => $request->input("en_name"),
            "has_booking" => $request->input("has-booking"),
            "has_delivery" => $request->input("has-delivery"),
            "booking_status" => $request->input("booking-features"),
            "delivery_price" => $request->input("delivery-price"),
            "has_payment"    => $request->input("has_payment"),
            "ar_address" => $request->input("address-text"),
            "en_address" => "",
            "longitude" => $request->input("lng"),
            "latitude" => $request->input("lat"),
//            "start_working_time" => $request->input("start") . ":00:00",
//            "end_working_time" => $request->input("end") . ":00:00",
            "phone" => $request->input("phone-number"),
            "provider_id"   => auth("provider")->id(),
            'category_id'   => $request->input("service-provider"),
            "congestion_settings_id" => $request->input("congestion-status"),
            "average_price" => $request->input("average-price"),

        ];
        
        if($changePassword){
            
            $data['password'] = bcrypt($request -> password);
        }
        

        $id = DB::table("branches")
                ->where("id", $request->input("branch_id"))
                ->update($data);


        $sat_start = ($request->input("saturday-start-working-hours-select")) ? $request->input("saturday-start-working-hours-select") . ":00:00" : null;
        $sat_end   = ($request->input("saturday-end-working-hours-select")) ? $request->input("saturday-end-working-hours-select") . ":00:00" : null;

        $sun_start = ($request->input("sunday-start-working-hours-select"))?$request->input("sunday-start-working-hours-select") . ":00:00" : null;
        $sun_end   = ($request->input("sunday-end-working-hours-select")) ? $request->input("sunday-end-working-hours-select") . ":00:00":null;

        $mon_start = ($request->input("monday-start-working-hours-select")) ? $request->input("monday-start-working-hours-select") . ":00:00":null;
        $mon_end   = ($request->input("monday-end-working-hours-select")) ? $request->input("monday-end-working-hours-select") . ":00:00":null;

        $tues_start = ($request->input("tuesday-start-working-hours-select")) ? $request->input("tuesday-start-working-hours-select") . ":00:00":null;
        $tues_end   = ($request->input("tuesday-end-working-hours-select")) ? $request->input("tuesday-end-working-hours-select") . ":00:00" : null;

        $wed_start = ($request->input("wednesday-start-working-hours-select")) ? $request->input("wednesday-start-working-hours-select") . ":00:00": null;
        $wed_end   = ($request->input("wednesday-end-working-hours-select")) ? $request->input("wednesday-end-working-hours-select") . ":00:00": null;

        $th_start = ($request->input("thursday-start-working-hours-select")) ? $request->input("thursday-start-working-hours-select") . ":00:00": null;
        $th_end   = ($request->input("thursday-end-working-hours-select")) ? $request->input("thursday-end-working-hours-select") . ":00:00": null;

        $fri_start = ($request->input("friday-start-working-hours-select")) ? $request->input("friday-start-working-hours-select") . ":00:00": null;
        $fri_end   = ($request->input("friday-end-working-hours-select"))? $request->input("friday-end-working-hours-select") . ":00:00": null;

        DB::table("branch_working_hours")
            ->where("branch_id", $request->input("branch_id"))
            ->update([
                "branch_id" => $request->input("branch_id"),
                "saturday_start_work" => $sat_start,
                "saturday_end_work" => $sat_end,
                "sunday_start_work" => $sun_start,
                "sunday_end_work" => $sun_end,
                "monday_start_work" => $mon_start,
                "monday_end_work" => $mon_end,
                "tuesday_start_work" => $tues_start,
                "tuesday_end_work" => $tues_end,
                "wednesday_start_work" => $wed_start,
                "wednesday_end_work" => $wed_end,
                "thursday_start_work" => $th_start,
                "thursday_end_work" => $th_end,
                "friday_start_work" => $fri_start,
                "friday_end_work" => $fri_end,
            ]);
        // images
        if($request->hasFile("0")){

            for($i = 0; $i <= $request->input("count") -1; $i++){

                $request->$i->store('branches', 'public');

                $img_id = DB::table("images")
                    ->insertGetId([
                        "name" => $request->$i->hashName()
                    ]);

                DB::table("branch_images")
                    ->insert([
                        "branch_id" => $request->input("branch_id"),
                        "image_id"  => $img_id
                    ]);
            }

        }

        $deletedImages = explode(",", $request->input("deletedId"));
        foreach($deletedImages as $img){
                    DB::table("branch_images")
                        ->where("image_id", $img)
                        ->where("branch_id", $request->input("branch_id"))
                        ->delete();

                    DB::table("images")
                        ->where("id", $img)
                        ->delete();

            // remove image from the storage folder
        }

        // options

        DB::table("branch_options")
                    ->where("branch_id", $request->input("branch_id"))
                    ->delete();

        $optionsArr = explode(",", $request->input("options"));
        foreach ($optionsArr as $option){
            DB::table("branch_options")
                ->insert([
                    "branch_id" => $request->input("branch_id"),
                    "option_id" => $option
                ]);
        }



        // meals
        DB::table("branch_meals")
                    ->where("branch_id", $request->input("branch_id"))
                    ->delete();

        $mealsArr = explode(",", $request->input("meals"));
        foreach ($mealsArr as $meal){
            DB::table("branch_meals")
                ->insert([
                    "branch_id" => $request->input("branch_id"),
                    "meal_id" => $meal
                ]);
        }

        return response()->json(["status" => true, "errNum" => 0, "msg" => $msg[6]]);

    }

    public function stop_branch($id){
        //App()->setLocale("ar");
        $check = $this->check_branch_id($id);
        if(!$check){
            return redirect("/restaurant/dashboard");
        }

        DB::table("branches")
                    ->where("id", $id)
                    ->update([
                        "published" => "0"
                    ]);

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function activate_branch($id){
        //App()->setLocale("ar");
        $check = $this->check_branch_id($id);
        if(!$check){
            return redirect("/restaurant/dashboard");
        }

        DB::table("branches")
            ->where("id", $id)
            ->update([
                "published" => "1"
            ]);

        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function delete_branch($id){
        //App()->setLocale("ar");
        $check = $this->check_branch_id($id);
        if(!$check){
            return redirect("/restaurant/dashboard");
        }

        $filter = ["1", "2", "3"];

        $orders = DB::table("order_meals")
                    ->join("orders", "order_meals.order_id", "orders.id")
                    ->join("branch_meals", "branch_meals.meal_id", "order_meals.meal_id")
                    ->where("branch_meals.branch_id", $id)
                    ->select(
                        "orders.order_status_id AS status_id"
                    )
                    ->get();

        if(count($orders) == 0){
            // remove the meal
            DB::table("branches")
                    ->where("id", $id)
                    ->delete();
            return redirect()->back()->with("success", trans("messages.success"));
        }
        foreach($orders as $order){
            if(in_array($order->status_id, $filter)){
                // return error
                return redirect()->back()->with("error", trans("provider.cannot_remove_branch"));
            }else{
                // update deleted column with value 1
                DB::table("branches")
                    ->where("id", $id)
                    ->update([
                        "deleted"  => "1"
                    ]);

                return redirect()->back()->with("success", trans("messages.success"));
            }
        }

    }

    protected function check_branch_id($id){
        $branch = DB::table("branches")
                    ->where("provider_id", auth("provider")->id())
                    ->where("id", $id)
                    ->first();
        if(!$branch){
            return false;
        }else{
            return true;
        }
    }
    
    
    
      public function getTimesFromOtherBranch($id ,Request $request){



          $data=[];
          
          
          if(!DB::table('branches') -> whereId($id)){
              
              
                        return response()->json([
                           'content' => null,   
                         ]);
                 
                 
          }
          
        $data['week_days'] = [
            "saturday"  => 'السبت',
            "sunday"    => 'الأحد',
            "monday"    => 'الاثنين',
            "tuesday"   => 'الثلاثاء',
            "wednesday" => 'الأربعاء',
            "thursday"  => 'الخميس',
            "friday"    => 'الجمعة',
        ];


          
            $data['working_hours'] = DB::table("branch_working_hours")
            ->where("branch_id", $id)
            ->select(
                 "saturday_start_work",
                "saturday_end_work",
                "sunday_start_work",
                "sunday_end_work",
                "monday_start_work",
                "monday_end_work",
                "tuesday_start_work",
                "tuesday_end_work",
                "wednesday_start_work",
                "wednesday_end_work",
                "thursday_start_work",
                "thursday_end_work",
                "friday_start_work",
                "friday_end_work"
            )
            ->first();

        foreach($data['working_hours'] as $key => $value){

            if($value == null){
                continue;
            }
            $val = explode(":", $value);
            $data['working_hours']->$key = $val[0];

        }

       $data['type']= $request -> type;
 
    $view =  view('Provider.pages.loadBranchTime',$data)->renderSections();
 
 
 
       return response()->json([
           'content' => $view['main'],   
         ]);
         
       
      }
      
}
