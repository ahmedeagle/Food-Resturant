<?php

namespace App\Http\Controllers\Provider;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OrderController extends Controller
{
    public function __construct()
    {
        
        
       // App()->setLocale("ar");
        if(!(auth("provider")->check() || auth("branch")->check())){
            return redirect("/login");
        }
    }

    public function get_orders($type){
        $data['title'] = " - الطلبات";
        $data['class'] = "page-template orders";

        // get list of orders
        if($type == "1"){
            // current orders
            $status = ["1", "2", "3"];
        }else{
            // previouse orders
            $status = ["4", "5"];
        }

        if(auth("provider")->check()){
            $filter = ["providers.id" => auth("provider")->id()];
        }elseif(auth("branch")->check()){
            $filter = ["branches.id" => auth("branch")->id()];
        }

        $data['orders'] = DB::table("orders")
                        ->join("branches", "branches.id", "orders.branch_id")
                        ->join("providers", "providers.id", "branches.provider_id")
                        ->join("users", "users.id", "orders.user_id")
                        ->leftjoin("images", "images.id", "users.image_id")
                        ->join("order_statuses", "order_statuses.id", "orders.order_status_id")
                        ->join("payment_methods", "payment_methods.id", "orders.payment_id")

                        ->where($filter)
                        ->orderBy("orders.id", "DESC")
                        ->select(
                            "orders.id AS order_id",
                            "orders.order_code",
                            "branches.ar_name AS branch_name",
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
                        ->paginate(25);

        foreach($data['orders'] as $order){
            $time_in_12_hour_format  = date("g:i a", strtotime($order->order_time));
            $dateArr = explode(" ", $time_in_12_hour_format);
            $order->order_time = $dateArr[0];
            $order->time_extention = ( $dateArr[1] == "am" ) ? trans("site.time-am") : trans("site.time-pm");
        }
        $data['type'] = $type;


         return view("Provider.pages.orders", $data);
    }

    public function get_order($id){

        $order = Order::find($id);
        if(!$order){
            return redirect("/restaurant/dashboard");
        }

        if(auth('provider')->check()){
            $provider_id = (new GeneralController())->get_order_provider_id($order->id);
            if($provider_id != auth("provider")->id()){
                return redirect("restaurant/dashboard");
            }
        }
        if(auth('branch')->check()){

            if($order->branch_id != auth("branch")->id()){
                return redirect("restaurant/dashboard");
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
                                    "orders.user_latitude AS latitude",
                                    "orders.user_longitude AS longitude",
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


        $dateFormate = (new GeneralController())->get_time_params($data['orderDetails']->order_date);
        
        
           if( $data['orderDetails']->latitude &&  $data['orderDetails']->longitude){
               
               $lat = $data['orderDetails']->latitude;
               $lng = $data['orderDetails']->longitude;
             $data['orderDetails']-> address = (new \App\Http\Controllers\Apis\User\GeneralController())->get_address_from_location($lat,$lng, App()->getLocale());   
        }else{
              $data['orderDetails']-> address = "";
        }
        
        
        $data['orderDetails']->order_date = $dateFormate;
        // get the order meals
        $data['meals'] = DB::table("order_meals")
                            ->join("meals", "meals.id", "order_meals.meal_id")
                            ->where("order_meals.order_id", $data['orderDetails']->order_id)
                            ->select(
                                "order_meals.id as order_meal_id",
                                "meals.id AS meal_id",
                                "meals.ar_name AS meal_name",
                                "order_meals.quantity AS meal_qty",
                                "order_meals.meal_price"
                            )->get();


        // get order options
        foreach($data['meals'] as $meal){

            $options = DB::table("order_meals_options")
                        ->where("order_meals_options.order_meals_id", $meal->order_meal_id)
                        ->join("meal_options", "meal_options.id", "order_meals_options.option_id")
                        ->select(
                            "order_meals_options.added_price",
                            "meal_options.ar_name as option_name"
                        )->get();
            $meal->options = $options;

            $adds = DB::table("order_meals_adds")
                        ->where("order_meals_adds.order_meals_id", $meal->order_meal_id)
                        ->join("meal_adds", "meal_adds.id", "order_meals_adds.add_id")
                        ->select(
                            "order_meals_adds.added_price",
                            "meal_adds.ar_name as add_name"
                        )->get();
            $meal->adds = $adds;

        }

        // get order adds
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
        
  

        return view("Provider.pages." . $view, $data);

    }

    public function accept_order($id){

//        App()->setLocale("ar");
        $order = DB::table("orders")
            ->where("id", $id)
            ->first();
        if(!$order){
            return redirect("/restaurant/dashboard");
        }

        DB::table("orders")
                    ->where("id", $id)
                    ->update([
                        "order_status_id" => "2"
                    ]);

        // send user notification
        $push_notif_title = "  تعديل حالة الطلب-" . $id;
        $post_id          = $id;
        $post_title       = "لقد تم قبول الطلب المقدم, برجاء الدخول لحسابك لاستعراض تفاصيل الطلب";

        $notif_data = array();

        $notif_data['title']   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 1;

        // get users device reg token
        $user = DB::table("orders")
                    ->join("users", "users.id", "orders.user_id")
                    ->where("orders.id", $id)
                    ->select(
                        "users.device_reg_id",
                        "users.id as user_id",
                        "orders.order_code as code"
                    )->first();

        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
        DB::table("notifications")
            ->insert([
                "en_title" => "change order status",
                "ar_title" => $push_notif_title,
                "en_content" => "The Service Provider Accept the Order With Code {$user->code}, Login To You Account to See More Details",
                "ar_content"  => $post_title,
                "notification_type"  => 1,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
        return redirect()->back()->with("success", trans("messages.success"));

    }
    public function decline_order($id){

//        App()->setLocale("ar");
        $order = DB::table("orders")
            ->where("id", $id)
            ->first();
        if(!$order){
            return redirect("/restaurant/dashboard");
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
        $push_notif_title = "  تعديل حالة الطلب-" . $id;
        $post_id          = $id;
        $post_title       = "لقد تم رفض الطلب المقدم, برجاء الدخول لحسابك لاستعراض تفاصيل الطلب";

        $notif_data = array();

        $notif_data['title']   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 1;
        // get users device reg token
        $user = DB::table("orders")
                    ->join("users", "users.id", "orders.user_id")
                    ->where("orders.id", $id)
                    ->select(
                        "users.device_reg_id",
                        "users.id as user_id",
                        "orders.order_code as code"
                    )->first();

        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
        DB::table("notifications")
            ->insert([
                "en_title" => "change order status",
                "ar_title" => $push_notif_title,
                "en_content" => "The Service Provider Decline the Order With Code {$user->code}, Login To You Account to See More Details",
                "ar_content"  => $post_title,
                "notification_type"  => 1,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function processed_order($id){
       // App()->setLocale("ar");
        $order = DB::table("orders")
                    ->where("id", $id)
                    ->first();
        if(!$order){
            return redirect("/restaurant/dashboard");
        }

        DB::table("orders")
            ->where("id", $id)
            ->update([
                "order_status_id" => "3"
            ]);

        // send user notification
         $push_notif_title = "  تعديل حالة الطلب-" . $id;
        $post_id          = $id;
        $post_title       = "لقد تم تجهيز الطلب المقدم, برجاء الدخول لحسابك لاستعراض تفاصيل الطلب";

        $notif_data = array();

        $notif_data['title']   = $push_notif_title;
        $notif_data['body']    = $post_title;
        $notif_data['id']      = $post_id;
        $notif_data['notification_type']      = 1;

        // get users device reg token
        $user = DB::table("orders")
            ->join("users", "users.id", "orders.user_id")
            ->where("orders.id", $id)
            ->select(
                "users.device_reg_id",
                "users.id as user_id",
                "orders.order_code as code"
            )->first();

        $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
        
        DB::table("notifications")
            ->insert([
                "en_title" => "change order status",
                "ar_title" => $push_notif_title,
                "en_content" => "The Service Provider process the Order With Code {$user->code}, Login To You Account to See More Details",
                "ar_content"  => $post_title,
                "notification_type"  => 1,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
            
        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function finish_order($id){

//        App()->setLocale("ar");
        $order = DB::table("orders")
                    ->where("id", $id)
                    ->first();
        if(!$order){
            return redirect("/restaurant/dashboard");
        }

        DB::table("orders")
            ->where("id", $id)
            ->update([
                "order_status_id" => "4"
            ]);

        // update provider balance
        
           
        if($order->payment_id == "1"){

            // check if the user using credit from balance
            
             $resturantId =  auth('provider') -> check() ? auth('provider') -> id() : auth('branch') -> provider_id();
             
                 $balance = DB::table("balances")
                    ->where("actor_id",$resturantId)
                    ->where("actor_type", "provider")
                    ->first();
                    
                    //app percentage from this order 
                    $addPalance = 0;
                
                $totalordervalWithAppPercent =  $order -> total_price;
                 
                 $tax = DB::table("app_settings")
                    ->select("app_settings.order_tax")
                    ->first();
                    
                    if($tax){
                        $taxData = $tax->order_tax;
                    }else{
                        $taxData = 0;
                    }
                    
                    
                    if($taxData > 0){
                         
                        $AppPercent = ($totalordervalWithAppPercent  * $taxData) / 100 ;
                        
                    }
                    
                    
                    $providerBalanceFromOrder = $order -> total_price -  $AppPercent;
                     
                
                if($balance){
                    
                    
                    $resturantId =  auth('provider') -> check() ? auth('provider') -> id() : auth('branch') -> provider_id();
                    
                    DB::table("balances")
                        ->where("actor_id", $resturantId)
                        ->where("actor_type", "provider")
                        ->update([
                            "balance" => $balance->balance - $AppPercent
                        ]);
                }
            

        }
        
        
        
         if($order->payment_id == "2" ||  $order->payment_id == "3"){
             
             
                  // check if the user using credit from balance
            
             $resturantId =  auth('provider') -> check() ? auth('provider') -> id() : auth('branch') -> provider_id();
             
                 $balance = DB::table("balances")
                    ->where("actor_id",$resturantId)
                    ->where("actor_type", "provider")
                    ->first();
                    
                    //app percentage from this order 
                    $addPalance = 0;
                
                $totalordervalWithAppPercent =  $order -> total_price;
                 
                 $tax = DB::table("app_settings")
                    ->select("app_settings.order_tax")
                    ->first();
                    
                    if($tax){
                        $taxData = $tax->order_tax;
                    }else{
                        $taxData = 0;
                    }
                    
                    
                    if($taxData > 0){
                         
                        $AppPercent = ($totalordervalWithAppPercent  * $taxData) / 100 ;
                        
                    }
                    
                    
                    $providerBalanceFromOrder = $order -> total_price -  $AppPercent;
                     
                
                if($balance){
                    
                    
                    $resturantId =  auth('provider') -> check() ? auth('provider') -> id() : auth('branch') -> provider_id();
                    
                    DB::table("balances")
                        ->where("actor_id", $resturantId)
                        ->where("actor_type", "provider")
                        ->update([
                            "balance" => $balance->balance + $providerBalanceFromOrder
                        ]);
                        
                        
                        
                        
                }
                
                
                

             
         }



        // send user notification
        $user = DB::table("orders")
                    ->join("users", "users.id", "orders.user_id")
                    ->where("orders.id", $id)
                    ->select(
                        "orders.order_code as code",
                        "users.id as user_id",
                        "users.device_reg_id",
                        "orders.branch_id"
                    )->first();

        $push_notif_title = "تقييم المطعم";
        $post_id          = $user->branch_id;
        $post_title       = "لقد قام مقدم الخدمة بإنهاء الطلب المقدم برقم {$user->code}, برجاء تقييم المطعم حتى نتمكن من الاستمرار فى تقديم خدمة متميزة دائما";

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
                "en_content" => "The Service Provider Finish the Order With Code {$user->code}, Please Rate the Restaurant To Help Us Provider Excellent Service",
                "ar_content"  => $post_title,
                "notification_type"  => 3,
                "actor_id" => $user->user_id,
                "actor_type" => "user",
                "action_id" => $post_id

            ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }
}
