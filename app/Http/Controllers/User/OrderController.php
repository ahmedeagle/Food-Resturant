<?php

namespace App\Http\Controllers\User;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OrderController extends Controller
{
    public function get_orders(){

        App()->setLocale("ar");
        $data['title'] = ' - الطلبات';
        $data['class'] = 'page-template orders';

        $data['currentOrders'] = $this->select_order(true);
        $data['previousOrders'] = $this->select_order(false);
        return view("User.pages.order.orders", $data);
    }

    public function select_order($current){

        if($current){
            $filter = [1,2,3];
            $page = "currentOrder";
        }else{
            $filter = [4,5];
            $page = "previousOrder";
        }



        $orders = DB::table("orders")
                    ->join("branches", "branches.id", "orders.branch_id")
                    ->join("providers", "providers.id", "branches.provider_id")
                    ->join("users", "users.id", "orders.user_id")
                    ->leftjoin("images", "images.id", "users.image_id")
                    ->join("order_statuses", "order_statuses.id", "orders.order_status_id")
                    ->join("payment_methods", "payment_methods.id", "orders.payment_id")
                    ->whereIn("orders.order_status_id", $filter)
                    ->where("orders.user_id", auth()->id())
                    ->orderBy("orders.id", "DESC")
                    ->select(
                        "orders.id AS order_id",
                        "orders.order_code",
                        DB::raw("TIME(orders.order_date) AS order_time"),
                        DB::raw("DATE(orders.order_date) AS order_date"),
                        "orders.total_price",
                        "users.name AS username",
                        DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                        "order_statuses.ar_name AS status_name",
                        "order_statuses.id AS status_id",
                        "payment_methods.id AS payment_id",
                        "payment_methods.ar_name AS payment_name"
                    )
                    ->paginate(25,['*'], $page);

        foreach($orders as $order){
            $time_in_12_hour_format  = date("g:i a", strtotime($order->order_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $order->order_time = $dateArr[0];
            $order->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");
        }
        return $orders;
    }

    public function get_order($id){

        $order = Order::find($id);
        if(!$order){
            return redirect("/user/dashboard");
        }

        if(auth()->check()){
            $user_id = (new \App\Http\Controllers\Provider\GeneralController())->get_order_provider_id($order->id, true);
            if($user_id != auth()->id()){
                return redirect("user/dashboard");
            }
        }

        $data['orderDetails'] = DB::table("orders")
                        ->join("branches", "branches.id", "orders.branch_id")
                        ->join("providers", "providers.id", "branches.provider_id")
                        ->join("users", "users.id", "orders.user_id")
                        ->leftjoin("images", "images.id", "users.image_id")
                        ->join("order_statuses", "order_statuses.id", "orders.order_status_id")
                        ->join("payment_methods", "payment_methods.id", "orders.payment_id")
                        ->where("orders.id", $id)
                        ->orderBy("orders.id", "DESC")
                        ->select(
                            "orders.id AS order_id",
                            "orders.order_code",
                            DB::raw("TIME(orders.order_date) AS order_time"),
                            DB::raw("DATE(orders.order_date) AS order_date"),
                            "orders.total_price",
                            "users.name AS username",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url"),
                            "order_statuses.ar_name AS status_name",
                            "order_statuses.id AS status_id",
                            "payment_methods.id AS payment_id",
                            "payment_methods.ar_name AS payment_name"
                        )
                        ->first();


        $dateFormate = (new \App\Http\Controllers\Provider\GeneralController())->get_time_params($data['orderDetails']->order_date);
        $data['orderDetails']->order_date = $dateFormate;
        // get the order meals
        $data['meals'] = DB::table("order_meals")
            ->join("meals", "meals.id", "order_meals.meal_id")
            ->where("order_meals.order_id", $data['orderDetails']->order_id)
            ->select(
                "meals.id AS meal_id",
                "meals.ar_name AS meal_name",
                "order_meals.quantity AS meal_qty",
                "order_meals.meal_price"
            )->get();


        $time_in_12_hour_format  = date("g:i a", strtotime($data['orderDetails']->order_time));
        $dateArr = explode(" ", $time_in_12_hour_format);
        $data['orderDetails']->order_time = $dateArr[0];
        $data['orderDetails']->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");

        if($data['orderDetails']->status_id == "1"){
            $view = "orders-pending";
        }elseif($data['orderDetails']->status_id == "2"){
            $view = "orders-confirmed";
        }elseif($data['orderDetails']->status_id == "3"){
            $view = "orders-ready";
        }elseif($data['orderDetails']->status_id == "4"){
            $view = "orders-expired";
        }elseif($data['orderDetails']->status_id == "5"){
            $view = "orders-canceled";
        }


        $data['title'] = " - تفاصيل الطلب";
        $data['class'] = "page-template orders canceled";

        return view("User.pages.order." . $view, $data);

    }

    public function decline_order($id){

        App()->setLocale("ar");
        $order = DB::table("orders")
            ->where("id", $id)
            ->first();
        if(!$order){
            return redirect("/user/dashboard");
        }

        if($order->payment_id == "1"){

            // check if the user using credit from balance
            if($order->used_user_balance != 0.00){
                $balance = DB::table("balances")
                    ->where("actor_id", $order->user_id)
                    ->where("actor_type", "user")
                    ->first();
                if($balance){
                    DB::table("balances")
                        ->where("actor_id", $order->user_id)
                        ->where("actor_type", "user")
                        ->update([
                            "balance" => $balance->balance + $order->used_user_balance
                        ]);
                }
            }

        }

        if($order->payment_id == "2" || $order->payment_id == "3"){

            $balance = DB::table("balances")
                ->where("actor_id", $order->user_id)
                ->where("actor_type", "user")
                ->first();

            if($balance){
                DB::table("balances")
                    ->where("actor_id", $order->user_id)
                    ->where("actor_type", "user")
                    ->update([
                        "balance" => $balance->balance + $order->total_price
                    ]);
            }
        }

        DB::table("orders")
            ->where("id", $id)
            ->update([
                "order_status_id" => "5"
            ]);

        // send user notification

        return redirect()->back()->with("success", trans("messages.success"));
    }
}
