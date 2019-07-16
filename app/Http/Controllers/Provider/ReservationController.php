<?php

namespace App\Http\Controllers\Provider;

use App\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ReservationController extends Controller
{
    public function __construct()
    {
        App()->setLocale("ar");
        if(!(auth("provider")->check() || auth("branch")->check())){
            return redirect("/login");
        }
    }

    public function get_reservations($type){
        $data['title'] = " - الحجوزات";
        $data['class'] = "page-template reservation";

 
        if(auth("provider")->check()){
            $filter = ["providers.id" => auth("provider")->id()];
        }else if(auth("branch")->check()){
            $filter = ["branches.id" => auth("branch")->id()];
        }

        // get list of reservations
        $data['reservations'] = DB::table("reservations")
                                        ->join("branches", "branches.id", "reservations.branch_id")
                                        ->join("providers", "providers.id", "branches.provider_id")
                                        ->join("users", "users.id", "reservations.user_id")
                                        ->leftjoin("images", "images.id", "users.image_id")
                                        ->join("reservation_statuses", "reservation_statuses.id", "reservations.status_id")
                                        ->where($filter)
                                        ->orderBy("reservations.id", "DESC")
                                        ->select(
                                            "reservations.id AS reservation_id",
                                            "branches.ar_name AS branch_name",
                                            "reservations.reservation_code",
                                            "reservations.date AS reservation_date",
                                            "reservations.time AS reservation_time",
                                            "reservations.seats_number",
                                            "users.name AS username",
                                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                                            "reservation_statuses.ar_name AS status_name",
                                            "reservation_statuses.id AS status_id"
                                        )
                                        ->paginate(25);

        foreach($data['reservations'] as $r){
            $time_in_12_hour_format  = date("g:i a", strtotime($r->reservation_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $r->reservation_time = $dateArr[0];
            $r->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");

            $dateFormate = (new GeneralController())->get_time_params($r->reservation_date);
            $r->reservation_date = $dateFormate;
        }

        return view("Provider.pages.reservation", $data);
    }

    public function get_reservation($id){

        $reservation = Reservation::find($id);
        if(!$reservation){
            return redirect("/restaurant/dashboard");
        }

        if(auth('provider')->check()){
            $provider_id = (new GeneralController())->get_reservation_provider_id($reservation->id);
            if($provider_id != auth("provider")->id()){
                return redirect("restaurant/dashboard");
            }
        }
        if(auth('branch')->check()){

            if($reservation->branch_id != auth("branch")->id()){
                return redirect("restaurant/dashboard");
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
                                            "branches.ar_name AS branch_name",
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



        $dateFormate = (new GeneralController())->get_time_params($data['reservationDetails']->reservation_date);
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

        return view("Provider.pages." . $view, $data);
    }


    public function accept_reservation($id){

        DB::table("reservations")
                ->where("id", $id)
                ->update([
                    "status_id" => "2"
                ]);

        $user = DB::table("reservations")
            ->join("users", "users.id", "reservations.user_id")
            ->where("reservations.id", $id)
            ->select(
                "users.id as user_id",
                "users.device_reg_id",
                "reservations.reservation_code as code"
            )->first();

        $push_notif_title = "تعديل حالة الححز";
        $post_id          = $id;
        $post_title       = "لقد تم قبول طلب الحجز المقدم برقم {$user->code}, برجاء الدخول لحسابك لاستعراض تفاصيل الحجز";


        $notif_data = array();

        $notif_data['title']   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 2;
        // get users device reg token


        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);

        DB::table("notifications")
            ->insert([
                "en_title" => "Change Reservation status",
                "ar_title" => $push_notif_title,
                "en_content" => "The Service Provider Accepted the Reservation With Code {$user->code}, Please Login To Your Account To See More detais",
                "ar_content"  => $post_title,
                "notification_type"  => 2,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function decline_reservation($id){

        DB::table("reservations")
            ->where("id", $id)
            ->update([
                "status_id" => "3"
            ]);


        // get users device reg token
        $user = DB::table("reservations")
                    ->join("users", "users.id", "reservations.user_id")
                    ->where("reservations.id", $id)
                    ->select(
                        "users.id as user_id",
                        "users.device_reg_id",
                        "reservations.reservation_code as code"
                    )->first();

        $push_notif_title = "تعديل حالة الححز";
        $post_id          = $id;
        $post_title       = "للأسف تم رفض طلب الحجز المقدم برقم {$user->code}, برجاء الدخول لحسابك لاستعراض تفاصيل الحجز وإجراء طلب جديد";

        $notif_data = array();

        $notif_data["title"]   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 2;


        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);

        DB::table("notifications")
            ->insert([
                "en_title" => "Change Reservation status",
                "ar_title" => $push_notif_title,
                "en_content" => "The Service Provider Decline the Reservation With Code {$user->code}, Please Login To Your Account To See More detais",
                "ar_content"  => $post_title,
                "notification_type"  => 2,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function finish_reservation($id){
        DB::table("reservations")
            ->where("id", $id)
            ->update([
                "status_id" => "4"
            ]);

        // send user notification

        $user = DB::table("reservations")
                    ->join("users", "users.id", "reservations.user_id")
                    ->where("reservations.id", $id)
                    ->select(
                        "users.device_reg_id",
                        "users.id as user_id",
                        "reservations.branch_id AS branch_id",
                        "reservations.reservation_code as code"
                    )->first();

        $push_notif_title = "تقييم المطعم";
        $post_id          = $user->branch_id;
        $post_title       = "لقد قام مقدم الخدمة بإنهاء الحجز المقدم برقم {$user->code}, برجاء تقييم المطعم حتى نتمكن من الاستمرار فى تقديم خدمة متميزة دائما";

        $notif_data = array();

        $notif_data['title']   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 3;


        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
        DB::table("notifications")
                ->insert([
                   "en_title" => "rate the restaurant",
                   "ar_title" => $push_notif_title,
                   "en_content" => "The Service Provider Finish the Reservation With Code {$user->code}, Please Rate the Restaurant To Help Us Provider Excellent Service",
                    "ar_content"  => $post_title,
                   "notification_type"  => 3,
                   "actor_id" => $user->user_id,
                   "actor_type" => "user",
                   "action_id" => $post_id

                ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }
}
