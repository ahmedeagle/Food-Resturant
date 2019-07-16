<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GeneralController extends Controller
{
    public static function get_pages_list(){
        // get list of pages
        $pages = DB::table("pages")
            ->where("active", "1")
            ->select(
                "id",
                "ar_title AS title"
            )
            ->where("active", "1")
            ->get();
        return $pages;
    }

    public function get_order_provider_id($id, $is_user = false){
        $order = DB::table("orders")
                    ->join("branches", "branches.id", "orders.branch_id")
                    ->join("providers", "providers.id", "branches.provider_id")
                    ->where("orders.id", $id)
                    ->select("providers.id AS provider_id", "orders.user_id")
                    ->first();

        if($is_user){
            return $order->user_id;
        }
        return $order->provider_id;
    }

    public function get_reservation_provider_id($id, $is_user=false){
        $reservation = DB::table("reservations")
                        ->join("branches", "branches.id", "reservations.branch_id")
                        ->join("providers", "providers.id", "branches.provider_id")
                        ->where("reservations.id", $id)
                        ->select("providers.id AS provider_id", "reservations.user_id")
                        ->first();
        if($is_user){
            return $reservation->user_id;
        }
        return $reservation->provider_id;
    }

    public function get_time_params($data){
        $time = strtotime($data);
        $newformat = date('d',$time);
        $postdate_d = date('d' , $time);
        $postdate_d2 = date('D', $time);
        $postdate_m = date('M' , $time);
        $postdate_y = date('Y' , $time);
        return $this->single_post_arabic_date($postdate_d,$postdate_d2, $postdate_m, $postdate_y);
    }
    public function single_post_arabic_date($postdate_d,$postdate_d2,$postdate_m,$postdate_y) {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $en_month = $postdate_m;
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }

        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = $postdate_d2;
        $ar_day = str_replace($find, $replace, $ar_day_format);

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $post_date = $postdate_d.' '.$ar_month.' '.$postdate_y;
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $post_date);

        return $arabic_date;
    }
}
