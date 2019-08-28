<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use GoogleTranslate;
use App\Http\Controllers\Apis\User\GeneralController;
class BranchController extends Controller
{


    public $translator ;


               
    public function _constract(){


      //  $this -> translator = new Dedicated\GoogleTranslate\Translator;

    }


    public function get_branch_page(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
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
            4  => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        
         $branch = DB::table("branches")
                    ->join("providers" ,"providers.id" , "branches.provider_id")
                    ->join("congestion_settings" , "congestion_settings.id" ,"branches.congestion_settings_id")
                    ->join("images" , "images.id" , "congestion_settings.image_id")
                    ->where("branches.id" , $id)
                    ->select(
                        "branches.id",
                        "providers.id AS provider_id",
                        "providers.".$name ."_name AS name",
                        "providers.".$name ."_description AS description",
                        "congestion_settings." .$name . "_name AS congestion_name",
                         DB::raw("CONCAT('". url('/') ."','/storage/app/public/settings/', images.name) AS congestion_image_url"),
                        "branches.ar_address AS address",
                        "branches.has_booking",
                        "branches.booking_status",
                        "branches.has_delivery",
                        "providers.accept_order",
                        "branches.delivery_price",
//                        "branches.start_working_time",
//                        "branches.end_working_time",
                        "branches.latitude",
                        "branches.longitude",
                        "branches.average_price AS menu_average_price"
                    )
                    ->first();
 

                   /* if($branch && $name == 'en'){

                         $branch -> address =   (new GoogleTranslate()) -> setSourceLang('ar')
                                 ->setTargetLang('en')
                                 ->translate($branch -> address );
                    }*/
 
                    
        $logo = DB::table("providers")
                        ->join("images" , "images.id", "providers.image_id")
                        ->where("providers.id",$branch->provider_id)
                        ->select(
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS logo_image")
                        )->first();
                        

        // start working hours
        $working_hours = DB::table("branch_working_hours")
                            ->where("branch_id", $id)
                            ->select(
                                
                         'saturday_start_work',
                         'saturday_end_work',
                         'sunday_start_work', 
                         'sunday_end_work', 
                          'monday_start_work', 
                          'monday_end_work', 
                          'tuesday_start_work', 
                          'tuesday_end_work', 
                          'wednesday_start_work', 
                         'wednesday_end_work', 
                         'thursday_start_work',
                         'thursday_end_work', 
                         'friday_start_work',
                         'friday_end_work'
                       // DB::raw((new GeneralController())->numberTranslator('friday_end_work',App()->getLocale() ))
   
                            )
                            ->first();

        foreach ($working_hours as $key => $working_hour) {
            if($working_hour == null){
                $empty  = (App()->getLocale() == 'ar') ? 'لا يعمل' : 'Not Working' ;
                $working_hours->$key = $empty;
            }else{
                $data = explode(":",$working_hour);
                $working_hours->$key = $data[0] . ":" . $data[1];
            }
        }

        $working_data = [
            [
                "start" =>$working_hours->saturday_start_work,
                "end"   => $working_hours->saturday_end_work,
            ],
            [
                "start" => $working_hours->sunday_start_work,
                "end"   =>$working_hours->sunday_end_work,
            ],
            [
                "start" => $working_hours->monday_start_work,
                "end"   =>$working_hours->monday_end_work,
            ],[
                "start" => $working_hours->tuesday_start_work,
                "end"   => $working_hours->tuesday_end_work,
            ],
            [
                "start" => $working_hours->wednesday_start_work,
                "end"   => $working_hours->wednesday_end_work, 
            ],
            [
                "start" => $working_hours->thursday_start_work,
                "end"   => $working_hours->thursday_end_work,
            ],[
                "start" => $working_hours->friday_start_work,
                "end"   => $working_hours->friday_end_work,
            ]
        ];
        $branch->working_time = $working_data;


        $branch->image_logo_url = $logo->logo_image;
        if($request->input("access_token")){
            $userData = DB::table("users")
                            ->where("token" , $request->input("access_token"))
                            ->first();
            if(!$userData){
                return response()->json(['status' => false, 'errNum' => 4, 'msg' => $msg[4]]);
            }
            $user  = DB::table("provider_favorits")
                        ->where("provider_id" , $branch-> id)
                        ->where("user_id" , (new GeneralController())->get_id($request))
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
        
        if($request->input("latitude") && $request->input("longitude")){
            $dis = (new BaseConroller())->getDistance($branch->latitude,$branch->longitude , $request->input("latitude") ,$request->input("longitude") , "KM");
        }else{
            $dis = -1;
        }
        
        $branch->distance = $dis;

        $meals = DB::table("meals")
                    ->where("branch_id" , $branch->id)
                    ->where("published" , "1")
                    ->where("deleted" , "0")
                    ->select(DB::raw("AVG(price) AS average_price"))
                    ->first();
 
        $branch->menu_average_price = ($meals->average_price == null) ? 0 : round((double) $meals->average_price);

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
                            "mealsubcategories." . $name . "_name AS cat_name"
                            )
                        ->get();

        $branch->categories_list = $cats;
        // features
        $options = DB::table("branch_options")
                        ->join("branches" , "branches.id" , "branch_options.branch_id")
                        ->join("options" , "options.id" , "branch_options.option_id")
                        ->join("images" , "images.id" , "options.image_id")
                        ->where("branches.id" , $branch->id)
                        ->select("options." . $name . "_name AS option_name",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/options/', images.name) AS option_image_url"))
                        ->get();
        $branch->options = $options;


        if($request->input("access_token")){
            $user = \App\User::where("token" , $request->input('access_token'))->first();
            if($user == null){
                return response()->json([
                        "status" => false,
                        "errNum" => 4,
                        "msg"  => $msg[4]
                ]);
            }
            $userRates = DB::table("rates")
                                ->where("user_id" , (new GeneralController())->get_id($request))
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
                    $branch->user_cleanliness_rate  = 0.0;
                    $branch->user_service_rate      = 0.0;
                    $branch->user_quality_rate      = 0.0;
            }else{
                    $branch->is_user_rate_branch    = true;

                    // check if the user can make rate
                    $user_id = (new GeneralController())->get_id($request);
                    $branch->is_user_can_rate  = $this->check_user_can_rate($user_id, $id);

                    $s = $userRates->service_sum / $userRates->count;
                    $q = $userRates->quality_sum / $userRates->count;
                    $c = $userRates->cleanliness_sum / $userRates->count;

                    $branch->user_service_rate   = round($s);
                    $branch->user_quality_rate     = round($q);
                    $branch->user_cleanliness_rate = round($c);

            }
        }else{
            $branch->is_user_rate_branch    = false;
            $branch->is_user_can_rate    = false;
            $branch->user_cleanliness_rate  = 0.0;
            $branch->user_service_rate      = 0.0;
            $branch->user_quality_rate      = 0.0;
        }
        
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "restaurant" => $branch]);
    }

    public function check_user_can_rate($user_id, $branch_id){

        // check if there is order with has_rate = 0
        $orders = DB::table("orders")
                    ->where("user_id", $user_id)
                    ->where("branch_id", $branch_id)
                    ->where("has_rate", "0")
                    ->get();
        if(count($orders) > 0){
            return true;
        }

        $rate = DB::table("rates")
                    ->where("user_id", $user_id)
                    ->where("branch_id", $branch_id)
                    ->orderBy("id", "DESC")
                    ->first();

        $to = \Carbon\Carbon::now()->format("Y-m-d H:i:s");


        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rate->created_at);

        $formatted_dt1 = \Carbon\Carbon::parse($to)->addHour(3);

        $formatted_dt2 = \Carbon\Carbon::parse($from);

        $diff_in_days = $formatted_dt1->diffInDays($formatted_dt2);


        if($diff_in_days == 0){

            return true;

        }else{
            return false;
        }
    }
}
