<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ReCaptcha\Response;
use Validator;
use DB;
use DateTime;
class ReservationController extends Controller
{
    public function add_reservation(Request $request){


 date_default_timezone_set('Asia/Riyadh');
        (new BaseConroller())->setLang($request);
        $rules      = [
            "id"           => "required|exists:branches,id",
            "status"       => "required|in:0,1",
            "date"         => 'required|date_format:Y-m-d|after_or_equal:'.date('Y-m-d'),
            "time"         => "required|date_format:H:i:s",
            "seats_number" => "required|numeric",
            "special"      => "required|in:0,1"
        ];
        if($request->input("special") == "1"){
            $rules["occasion_description"] = "required";
        }
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
            "status.in"            => 4,
            "date.date_format"     => 5,
            "time.date_format"     => 6,
            "seats_number.numeric" => 7,
            "special.in"           => 8,
            "after_or_equal"       =>12,
            
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.branch_id_exists"),
            3   => trans("messages.success"),
            4   => trans("messages.reservation.status.error"),
            5   => trans("messages.reservation.date.format.error"),
            6   => trans("messages.reservation.time.format.error"),
            7   => trans("messages.reservation.seats.error"),
            8   => trans("messages.reservation.special.error"),
            9   => trans("messages.branch.hasnot.booking"),
            10  => trans("messages.branch.out.of.date"),
            11  => trans("messages.error"),
            12  => trans("messages.dateMustAfterorEqualTodat"),
            13   => 'تم تحديد مواعيد العمل من قبل المطعم',
            14   => 'المطعم مغلق اليوم',
            15   => 'عفوا اتوقيت الطلب خارج اوقات  عمل المطعم '
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id      = $request->input("id");
        $status  = $request->input("status");
        $date    = $request->input("date");
        $time    = $request->input("time");
        $seats   = $request->input("seats_number");
        $special = $request->input("special");
        $special_decription = $request->input("occasion_description");
        $branch  = DB::table("branches")
                    ->where("id" , $id)
                    ->select("*")
                    ->first();
                
                    
                    
                    
                          //order time 
                  $order_time =  date('H:i:s',strtotime($time)) ;
                  $order_day = lcfirst(date('l', strtotime($date)));
                  
                 
                 //check if this date is open or closed
                $day =    DB::table('branch_working_hours') 
                          -> where('branch_id',$id) 
                          -> select(
                                       
                                      $order_day.'_start_work AS open' ,
                                      $order_day.'_end_work AS close' 
                                      
                                  ) 
                          -> first();
                         
                         
                      
                          
               if(!$day){
                        
                
                    return response()->json([
                    "status" => false,
                    "errNum" => 13,
                    "msg"    =>$msg[13]
                ]);
                 
                   
               }
               
               
               if(!$day -> open || !$day -> close){
                   
                   
                     return response()->json([
                    "status" => false,
                    "errNum" => 14,
                    "msg"    =>$msg[14]
                ]);
                  
                                         
               }
               
                 //branch open time 
                 $start =  $day -> open;    //09::00:00
                
                  //brach close time
                 $end   = $day -> close;   //02:00:00
             
	             
	             //check if the restaurant has shift an the next day to add this to current day
            	             
            	              if($end < $start){
            	                   
            	                     //must has shift 
            	                      
            	                     $startshift1 =  $start;   // start shift1    09:00:00 am
            	                     
            	                     $endshift1   = date('H:i:s',strtotime('23:59:59'));  //end shift one    11:59:59 pm
            	                     
            
            	                     $startshift2 =  date('H:i:s',strtotime('00:00:00'));   // start shift2 from    12am 
            	                     
            	                     $endshift2   = $day -> close;  //end time and shifts  2am 
            	                     
            	                     
            	                     //check if avaiable in shift 1  or shift2
            	                     
             	                        
            	                        if(!($startshift1 <=  $order_time  && $order_time  <= $endshift1) && !($startshift2 <=  $order_time  && $order_time  <= $endshift2) ){
            	                            
                                                       
                                                    return response()->json([
                                                        "status" => false,
                                                        "errNum" => 15,
                                                        "msg"    =>$msg[15]
                                                    ]);
                                             }
                                              
            	              }else{
            	                  
            	                      if(!($start <=  $order_time  && $order_time  <= $end)){
                                                      
                                                 return response()->json([
                                                        "status" => false,
                                                        "errNum" => 15,
                                                        "msg"    =>$msg[15]
                                                    ]);
                                         } 
                                  
            	              
                     }
         
         
            

              

 
        $code = (new GeneralController())->generate_random_number(4);

        DB::table("reservations")
                ->insert([
                    "reservation_code"     => $code,
                    "date"                 => $date,
                    "time"                 => $time,
                    "booking_status"       => $status,
                    "seats_number"         => $seats,
                    "special_reservation"  => $special,
                    "occasion_description" => $special_decription,
                    "branch_id"            => $id,
                    "user_id"              => (new GeneralController())->get_id($request),
                    "status_id"            => 1
                ]);
                
                
                /*
                 ************
                 ** Send Push Notification to Provider and branch
                 ************
                */
                
                
                $userobj = DB::table('users') -> whereId((new GeneralController())->get_id($request));
                
                if($userobj){
                    
                    $branch_id = $id;
                    
                         $notif_data = array();
                
                $content = "هناك حجز جديد من المسنخدم ".$userobj -> first()-> name;

                $notif_data['title']      = 'مجرب';
                $notif_data['body']       = $content;
                $notif_data['icon']       = env('APP_URL').'/assets/site/img/logo.png';
              
                 
                         //send firebase notify    to branch  and provider
              
                $branch_data = DB::table('branches') -> whereId($branch_id) ->select('provider_id','webtokenSubscribe') -> first();
                     
                if($branch_data  -> webtokenSubscribe){
                     
                     (new \App\Http\Controllers\Apis\User\PushNotificationController())->sendNotificationToWebBrowser($branch_data->webtokenSubscribe,$notif_data);
                     
                       $providerId =$branch_data -> provider_id ;
                
                $provData= DB::table('providers') -> whereId($providerId) ;
                
                
                if($provData){
                    
                       $providerWebtokenSubscribe = $provData -> select('webtokenSubscribe') -> first();
                         
                             if($providerWebtokenSubscribe  -> webtokenSubscribe){
                                
                                (new \App\Http\Controllers\Apis\User\PushNotificationController())->sendNotificationToWebBrowser($providerWebtokenSubscribe -> webtokenSubscribe,$notif_data);
                                }
                             
                        }
                }else{
                    
                    
                    
                       
                         $providerId =DB::table('branches') -> whereId($branch_id) -> select('provider_id') -> first();
                
                         $provData= DB::table('providers') -> whereId($providerId -> provider_id) ;
                
                
                if($provData){
                    
                       $providerWebtokenSubscribe = $provData -> select('webtokenSubscribe') -> first();
                         
                             if($providerWebtokenSubscribe  -> webtokenSubscribe){
                                
                                (new \App\Http\Controllers\Apis\User\PushNotificationController())->sendNotificationToWebBrowser($providerWebtokenSubscribe -> webtokenSubscribe,$notif_data);
                                }
                             
                        }
                    
                    
                    
                }
                
                
                
                
                }
                
                
                
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }

    public function cancel_reservation(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "id"           => "required|exists:reservations,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.reservations_id_exists"),
            3   => trans("messages.success"),
            4   => trans("messages.reservation_already_accepted"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        $res = DB::table("reservations")
                        ->where("id" , $id)
                        ->select("*")
                        ->first();

        if($res->status_id != "1"){
            return response()->json(['status' => false, 'errNum' => 4, 'msg' => $msg[4]]);
        }

        if($res->user_id != (new GeneralController())->get_id($request)){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5 ]]);
        }
        DB::table("reservations")
                ->where("id" , $id)
                ->update([
                    "status_id" => 3
                ]);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }

    public function get_Reservation(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "type"       => "required|in:0,1",
        ];
        $messages   = [
            "required"             => 1,
            "in"                   => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.type.in.0.1"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $type = $request->input("type");
        // 0 -> current
        // 1 -> Previous
        $arrValues = ($type == "0" || $type == 0) ? [1,2] : [3,4];

        $reservations = DB::table("reservations")
                            ->join("branches" , "branches.id" , "reservations.branch_id")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->join("images" , "images.id" , "providers.image_id")
                            ->join("reservation_statuses" , "reservation_statuses.id" , "reservations.status_id")
                            ->where("reservations.user_id" , (new GeneralController())->get_id($request))
                            ->whereIn("reservations.status_id" , $arrValues)
                            ->select(
                                "reservations.id AS reservation_id",
                                "branches.id AS restaurant_id",
                                "providers.".$name."_name AS name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                "reservations.date",
                                "reservations.time",
                                "reservations.seats_number",
                                "reservations.reservation_code",
                                "reservation_statuses.id AS status_id",
                                "reservation_statuses.". $name ."_name AS status",
                                "branches.latitude",
                                "branches.longitude",
                                "branches.director_phone AS phone"
                            )
                            ->orderBy("reservations.created_at" , "DESC")
                            ->paginate(10);
        foreach($reservations as $r){
            $rates = DB::table('rates')
                        ->where('branch_id' ,$r->restaurant_id)
                        ->select(
                            DB::raw("SUM(service) AS service_sum"),
                            DB::raw("SUM(quality) AS quality_sum"),
                            DB::raw("SUM(Cleanliness) AS cleanliness_sum"),
                            DB::raw("COUNT(id) AS count")
                        )->first();
    
            if($rates->count != 0){
                $service_rate     = $rates->service_sum / $rates->count;
                $quality_rate     = $rates->quality_sum / $rates->count;
                $cleanliness_rate = $rates->cleanliness_sum / $rates->count;
                $r->average_rate = ( ($service_rate) + ($quality_rate) + ($cleanliness_rate) ) / 3 ;
            }else{
                $r->average_rate = 0;
            }
            if($request->input('latitude') && $request->input('longitude') && $r->latitude && $r->longitude){
                $distance = round( (new BaseConroller())->getDistance(
                            $request->input('latitude'),
                            $request->input('longitude'),
                            $r->latitude,
                            $r->longitude,
                            "KM"
                    ) );
            }else{
                $distance = 0;
            }
            $r->distance = $distance;
        }
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "reservations" => $reservations]);
    }
}
