<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
class IndexController extends Controller
{
    public function index(){
        
         date_default_timezone_set('Asia/Riyadh');
         
         App()->setLocale("ar");
        $data['title'] = " - الرئيسية - لوحة التحكم ";
        $data['class'] = "page-template dashboard";

        // get list of orders

        if(auth('provider')->check()){
            $filter = ["providers.id" => auth('provider')->id()];
        }else if(auth('branch')->check()){
            $filter = ["branches.id" => auth('branch')->id()];
        }

        $data['orders'] = DB::table("orders")
            ->join("branches", "branches.id", "orders.branch_id")
            ->join("providers", "providers.id", "branches.provider_id")
            ->join("users", "users.id", "orders.user_id")
            ->leftjoin("images", "images.id", "users.image_id")
            ->join("order_statuses", "order_statuses.id", "orders.order_status_id")
            ->where($filter)
            ->orderBy("orders.id", "DESC")
            ->select(
                "orders.id AS order_id",
                "branches.ar_name AS branch_name",
                "orders.order_code",
                DB::raw("TIME(orders.order_date) AS order_time"),
                "orders.total_price",
                "users.name AS username",
                DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                "order_statuses.ar_name AS status_name",
                "order_statuses.id AS status_id",
                "order_statuses.ar_name as status_name"
            )
            ->paginate(5);

       
        
        foreach($data['orders'] as $order){

            $time_in_12_hour_format  = date("g:i a", strtotime($order->order_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $order->order_time = $dateArr[0];
            $order->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");

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
                                    "reservations.reservation_code",
                                    "branches.ar_name As branch_name",
                                    "reservations.date AS reservation_date",
                                    "reservations.time AS reservation_time",
                                    "reservations.seats_number",
                                    "users.name AS username",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                                    "reservation_statuses.ar_name AS status_name",
                                    "reservation_statuses.id AS status_id"
                                )
                                ->paginate(5);

        foreach($data['reservations'] as $r){
            $time_in_12_hour_format  = date("g:i a", strtotime($r->reservation_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $r->reservation_time = $dateArr[0];
            $r->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");

            $dateFormate = (new GeneralController())->get_time_params($r->reservation_date);
            $r->reservation_date = $dateFormate;
        }

        return view("Provider.pages.dashboard", $data);
    }
}
