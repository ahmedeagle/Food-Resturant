<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use Validator;
use Illuminate\Pagination\Paginator;

class ReservationController extends Controller
{
    public function get_reservations(){

        App()->setLocale("ar");
        // get list of reservations
        $data['currentReservations'] = $this->select_reservation(true);
        $data['previousReservations'] = $this->select_reservation(false);

        $data['title'] = ' - الحجوزات';
        $data['class'] = 'page-template reservation';

        return view("User.pages.reservation.reservations", $data);

    }

    public function select_reservation($current){

        if($current){
            $filter = [1,2];
            $page = "currentReservation";
        }else{
            $filter = [3,4];
            $page = "previousReservation";
        }

        $reservations = DB::table("reservations")
                            ->join("branches", "branches.id", "reservations.branch_id")
                            ->join("providers", "providers.id", "branches.provider_id")
                            ->join("users", "users.id", "reservations.user_id")
                            ->leftjoin("images", "images.id", "users.image_id")
                            ->join("reservation_statuses", "reservation_statuses.id", "reservations.status_id")
                            ->where("reservations.user_id", auth()->id())
                            ->whereIn("reservations.status_id", $filter)
                            ->orderBy("reservations.id", "DESC")
                            ->select(
                                "reservations.id AS reservation_id",
                                "reservations.reservation_code",
                                "reservations.date AS reservation_date",
                                "reservations.time AS reservation_time",
                                "reservations.seats_number",
                                "users.name AS username",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                                "reservation_statuses.ar_name AS status_name",
                                "reservation_statuses.id AS status_id"
                            )
                            ->paginate(10,['*'], $page);

        foreach($reservations as $r){

            $time_in_12_hour_format  = date("g:i a", strtotime($r->reservation_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $r->reservation_time = $dateArr[0];
            $r->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");

            $dateFormate = (new \App\Http\Controllers\Provider\GeneralController())->get_time_params($r->reservation_date);
            $r->reservation_date = $dateFormate;

        }

        return $reservations;
    }

    public function get_reservation($id){

        App()->setLocale("ar");
        $reservation = \App\Reservation::find($id);
        if(!$reservation){
            return redirect("/user/dashboard");
        }

        if(auth()->check()){
            $user_id = (new \App\Http\Controllers\Provider\GeneralController())->get_reservation_provider_id($reservation->id,true);
            if($user_id != auth()->id()){
                return redirect("user/dashboard");
            }
        }

        $data['reservationDetails'] = DB::table("reservations")
                                        ->join("branches", "branches.id", "reservations.branch_id")
                                        ->join("providers", "providers.id", "branches.provider_id")
                                        ->join("users", "users.id", "reservations.user_id")
                                        ->leftjoin("images", "images.id", "users.image_id")
                                        ->join("reservation_statuses", "reservation_statuses.id", "reservations.status_id")
                                        ->where("reservations.id", $id)
                                        ->orderBy("reservations.id", "DESC")
                                        ->take(5)
                                        ->select(
                                            "reservations.id AS reservation_id",
                                            "reservations.reservation_code",
                                            "reservations.date AS reservation_date",
                                            "reservations.time AS reservation_time",
                                            "reservations.seats_number",
                                            "users.name AS username",
                                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                                            "reservation_statuses.ar_name AS status_name",
                                            "reservation_statuses.id AS status_id"
                                        )
                                        ->first();



        $dateFormate = (new \App\Http\Controllers\Provider\GeneralController())->get_time_params($data['reservationDetails']->reservation_date);
        $data['reservationDetails']->reservation_date = $dateFormate;



        $time_in_12_hour_format  = date("g:i a", strtotime($data['reservationDetails']->reservation_time));
        $dateArr = explode(" ", $time_in_12_hour_format);
        $data['reservationDetails']->reservation_time = $dateArr[0];
        $data['reservationDetails']->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");


        if($data['reservationDetails']->status_id == "1"){
            $view = "reservation-pending";
        }elseif($data['reservationDetails']->status_id == "2"){
            $view = "reservation-confirmed";
        }elseif($data['reservationDetails']->status_id == "3"){
            $view = "reservation-canceled";
        }elseif($data['reservationDetails']->status_id == "4"){
            $view = "reservation-expired";
        }


        $data['title'] = " - الحجوزات";
        $data['class'] = "page-template reservation expired";

        return view("User.pages.reservation." . $view, $data);
    }



    public function add_reservation($id, $type){

        $branch = DB::table("branches")
                        ->where("id", $id)
                        ->first();

        if(!$branch){

            return redirect("/user/dashboard");

        }

        if(!($type == "0" || $type == "1")){

            return redirect("/user/dashboard");

        }

        $data['title'] = " -الحجز";
        $data['class'] = "front-page page-template";
        $data['type'] = $type;
        $data['id'] = $id;

        return view("User.pages.reservation.add-reservation", $data);

    }

    public function post_add_reservation(Request $request){

        // 0 individuals
        // 1 families

        App()->setLocale("ar");
        $rules      = [
            "id"           => "required|exists:branches,id",
            "status"       => "required|in:0,1",
            "date"         => 'required|date_format:Y-m-d|after_or_equal:'.date('Y-m-d'),
            "time"         => "required|date_format:H:i",
            "seats_number" => "required|numeric",
            "special"      => "required|in:0,1"
        ];
        if($request->input("special") == "1"){
            $rules["occasion_description"] = "required";
        }
        $messages   = [
            "required"             => trans("messages.required"),
            "exists"               => trans("messages.branch_id_exists"),
            "status.in"            => trans("messages.reservation.status.error"),
            "date.date_format"     => trans("messages.reservation.date.format.error"),
            "time.date_format"     => trans("messages.reservation.time.format.error"),
            "seats_number.numeric" => trans("messages.reservation.seats.error"),
            "special.in"           => trans("messages.reservation.special.error"),
            "after_or_equal"       => trans("messages.dateMustAfterorEqualTodat")
        ];


        $this->validate($request, $rules , $messages);

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

        if($branch->published == "0"){
            return redirect("/user/dashboard");
        }

        if($branch->has_booking == "0"){
            return redirect("/user/dashboard");
        }
 
                
                  
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
                    
                 
                
                return redirect() -> back()->with('closed' , "عفوا اليوم خارج عمل المطعم من فضلك قم بزيارة المطعم في وقت اخر");
                
                   
               }
               
               
               if(!$day -> open || !$day -> close){
                   
                   
                   return redirect() -> back()->with('closed' , "عفوا اليوم خارج عمل المطعم من فضلك قم بزيارة المطعم في وقت اخر");
                  
                                         
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
            	                            
                                                       
                                                        return redirect() -> back()->with('outWork' , "  الطلب خارج مواعيد العمل الرسمية للمطعم من فضلك حاول في وقت اخر");
                                             }
                                              
            	              }else{
            	                  
            	                      if(!($start <=  $order_time  && $order_time  <= $end)){
                                                      
                                                return redirect() -> back()->with('outWork' , "  الطلب خارج مواعيد العمل الرسمية للمطعم من فضلك حاول في وقت اخر");
                                         } 
                                  
            	              
                     }
         
         
            

              
              
        $code = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);

        DB::table("reservations")
            ->insert([
                "reservation_code"     => $code,
                "date"                 => $order_day,
                "time"                 => $order_time,
                "booking_status"       => $status,
                "seats_number"         => $seats,
                "special_reservation"  => $special,
                "occasion_description" => $special_decription,
                "branch_id"            => $id,
                "user_id"              => auth()->id(),
                "status_id"            => 1
            ]);

        // send notification to provider

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function decline_reservation($id){

        App()->setLocale("ar");
        $check = DB::table("reservations")->where("id", $id)->first();

        if(!$check){
            return redirect("/user/dashboard");
        }

        if($check->user_id != auth()->id()){
            return redirect("/user/dashboard");
        }

        DB::table("reservations")
            ->where("id", $id)
            ->update([
                "status_id" => "3"
            ]);

        // send notification to provider

        return redirect()->back()->with("success", trans("messages.success"));
    }

}

