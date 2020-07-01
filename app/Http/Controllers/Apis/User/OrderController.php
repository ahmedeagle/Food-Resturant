<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Meal;
use Carbon\Carbon;
use DateTime;
class OrderController extends Controller
{
    public function create_order(Request $request){

        (new BaseConroller())->setLang($request);

       date_default_timezone_set('Asia/Riyadh');


        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules    = [
                "meals"                => "required",
                "in_future"            => "required|in:0,1",
                "is_delivery"          => "required|in:0,1",
                "payment_method"       => "required"
        ];
        $messages = [
                "required"                  => 1,
                "in_future.in"              => 6,
                "is_delivery.in"            => 7,
                "payment_method.exists"     => 14,
                "order_date.date_formate"   => 15,
        ];


        $msg = [
                1    => trans("messages.required"),
                2    => trans("messages.meal_id_exists"),
                3    => trans("messages.meal_size_exists"),
                4    => trans("messages.meal_option_exists"),
                5    => trans("messages.meal_add_exists"),
                6    => trans('messages.order.in_future.in'),
                7    => trans('messages.order.is_delivery.in'),
                8    => trans('messages.success'),
                9    => trans('messages.error'),
                10   => trans('messages.order.balance.not.enough'),
                11   => trans('messages.workinghoursfrombranch'),
                12   => trans('messages.branchclosedtoday'),
                13   => trans('messages.exitbranchhours'),
                14   => 'وسيله الدفع المرسله غير صحيحه',
                15   => 'صيغة التاريخ غير صحيحه'
             ];




        if($request->input("in_future") == 1){
            $rules['order_date']  = "required";

        }


        if($request->input("is_delivery") == 1){
            $rules['latitude']  = "required";
            $rules['longitude']  = "required";
        }

        if($request->input("payment_method") == 2 || $request->input("payment_method") == 3){
            $rules['total_paid_amount']  = "required";
            $rules['process_number']     = "required";
        }


          $payment_method = $request->input("payment_method");



         if($request->input("payment_method") !=1 && $request->input("payment_method") !="1" && $request->input("payment_method") !=2 && $request->input("payment_method") !="2" && $request->input("payment_method") !=3 && $request->input("payment_method") !="3")
         {


             $payment_method = 1;

         }



        $validator  = Validator::make($request->all(), $rules, $messages);


        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }




   ////
        $meals = $request->input("meals");

		$branch_id = 0;
        $meals_arr = [];
        $deliveryPrice = 0;
        $total_price = 0;
        $latitude    = "";
        $longitude   = "";



         foreach($meals as $key => $meal){

            if(empty($meal['meal_id'])){
                return response()->json([
                    "status" => false,
                    "errNum" => 1,
                    "msg"    => $msg[1]
                ]);
            }

            $meals = DB::table("meals")
                        ->join("branches" , "branches.id" , "meals.branch_id")
                        ->where("meals.id" , $meal['meal_id'])
                        ->select(
                            "meals.id" ,
                            "meals.branch_id" ,
                            "branches.has_delivery",
                            "branches.delivery_price",
                            "meals.price"
                            )
                        ->first();

            if($meals == null){
                return response()->json([
                    "status" => false,
                    "errNum" => 2,
                    "msg"    =>$msg[2]
                ]);
            }

            if($key == 0){
                if($request->is_delivery == "1"){
                    if($meals->has_delivery == "0"){
                        return response()->json([
                            "status" => false,
                            "errNum" => 9,
                            "msg"    =>$msg[9]
                        ]);
                    }
                    $deliveryPrice = $meals->delivery_price;
                    $latitude    = $request->input("latitude");
                    $longitude   = $request->input("longitude");
                }
                $branch_id = $meals->branch_id;
            }else{
                if($meals->branch_id != $branch_id){
                    return response()->json([
                            "status" => false,
                            "errNum" => 9,
                            "msg"    =>$msg[9]
                        ]);
                }
            }

            if(empty($meal['qty'])){
                return response()->json([
                    "status" => false,
                    "errNum" => 1,
                    "msg"    =>$msg[1]
                ]);
            }
            $mealPrice = 0;
            $mealSize  = 0;
            if(empty($meal['size'])){
                $mealPrice = $meals->price;
                $mealSize  = 0;
            }else{

                $size_id = DB::table("meal_sizes")
                        ->where("id" , $meal['size'])
                        ->where("meal_id" , $meal['meal_id'])
                        ->select("id" , "price")
                        ->first();

                if($size_id == null){
                    return response()->json([
                        "status" => false,
                        "errNum" => 3,
                        "msg"    =>$msg[3]
                    ]);
                }
                $mealPrice = $size_id->price;
                $mealSize  = $size_id->id;
            }

            $options_arr = [];
            $options_added_price = 0;
            if(!empty($meal['options']) && is_array($meal['options']))
            {
                foreach($meal['options'] as $option){
                    if(empty($option['id'])){
                        return response()->json([
                            "status" => false,
                            "errNum" => 1,
                            "msg"    =>$msg[1]
                        ]);
                    }
                    $option_id = DB::table("meal_options")
                                ->where("id" , $option['id'])
                                ->where("meal_id" , $meal['meal_id'])
                                ->select("id" , "added_price")
                                ->first();

                    if($option_id == null){
                       return response()->json([
                            "status" => false,
                            "errNum" => 4,
                            "msg"    =>$msg[4]
                        ]);
                    }
                    $options_arr[] = [
                            "id"   => $option_id->id,
                            "add_price"  => $option_id->added_price
                    ];
                    $options_added_price += $option_id->added_price;
                }
            }
            $adds_arr = [];
            $adds_added_price = 0;
            if(!empty($meal['adds']) && is_array($meal['adds'])){
                foreach($meal['adds'] as $add){
                    if(empty($add['id'])){
                        return response()->json([
                            "status" => false,
                            "errNum" => 1,
                            "msg"    =>$msg[1]
                        ]);
                    }
                    $add_id = DB::table("meal_adds")
                                ->where("id" , $add['id'])
                                ->where("meal_id" , $meal['meal_id'])
                                ->select("id" , "added_price")
                                ->first();

                    if($add_id == null){
                        return response()->json([
                            "status" => false,
                            "errNum" => 5,
                            "msg"    =>$msg[5]
                        ]);
                    }
                    $adds_arr[] = [
                            "id"  => $add_id->id,
                            "added_price" => $add_id->added_price
                    ] ;
                    $adds_added_price += $add_id->added_price;
                }
            }
            $meals_arr[] = [
                "meal_id"   => $meal['meal_id'],
                "meal_qty"  => $meal['qty'],
                "size"      => $mealSize,
                "price"     => $mealPrice,
                "options"   => $options_arr,
                "add"       => $adds_arr
            ];
            $total_price += (((int)$mealPrice ) + ($options_added_price) + ($adds_added_price)) * (int)$meal['qty'];
        }



        $code       = (new GeneralController())->generate_random_number(10);
        $inFuture   = (string)$request->input("in_future");
        $orderDate  = $request->input("order_date");
        $payment    = $payment_method;
        $isDelivery = (string)$request->input("is_delivery");
        $orderDateTime = ($inFuture == "1") ? $orderDate : Carbon::now();

        $app_percentage  = DB::table("branches")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->where("branches.id" , $branch_id)
                            ->select("providers.order_app_percentage AS percentage")
                            ->first();


        $tax = DB::table("app_settings")
                    ->select("app_settings.order_tax")
                    ->first();
        if($tax){
            $taxData = $tax->order_tax;
        }else{
            $taxData = 0;
        }

        $total_price = $total_price + ( ( $taxData * $total_price ) / ( 100 ) );
        $total_price += $deliveryPrice;

        $userBalance = $this->getuserbalance($request);

        $processNumber = "";
        if($userBalance > $total_price){
            $paid_price = 00.00;
            $usedBalance = $total_price;

        }else{
            $paid_price  = $total_price - $userBalance;
            $usedBalance = $userBalance;
        }

        if($payment == 2 || $payment == 3){
            if($request->input("total_paid_amount") != $paid_price){
                return response()->json([
                        "status" => false,
                        "errNum" => 9,
                        "msg"    =>$msg[9]
                    ]);
            }

            $processNumber = $request->input("process_number");
        }



                 //order time
                $order_time = DateTime::createFromFormat("Y-m-d H:i:s",$orderDate) -> format("H:i:s");

                $order_day = lcfirst(date('l'));

                 //check if this date is open or closed
                $day =    DB::table('branch_working_hours')
                          -> where('branch_id',$branch_id)
                          -> select(

                                      $order_day.'_start_work AS open' ,
                                      $order_day.'_end_work AS close'

                                  )
                          -> first();


               if(!$day){

                   return response()->json([
                    "status" => false,
                    "errNum" => 11,
                    "msg"    =>$msg[11]
                ]);


               }


               if(!$day -> open || !$day -> close){


                    return response()->json([
                        "status" => false,
                        "errNum" => 12,
                        "msg"    =>$msg[12]
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
                                                "errNum" => 13,
                                                "msg"    =>$msg[13]
                                            ]);

                                 }

	              }else{

	                      if(!($start <=  $order_time  && $order_time  <= $end)){

                                            return response()->json([
                                                "status" => false,
                                                "errNum" => 13,
                                                "msg"    =>$msg[13]
                                            ]);

                             }


         }

        $data = [
                   "order_code"         =>  $code,
                   "in_future"          =>  $inFuture,
                   "order_date"         =>  $orderDateTime,
                   "is_delivery"        =>  $isDelivery,
                   "delivery_price"     =>  $deliveryPrice,
                   "total_price"        =>  $total_price,
                   "paid_amount"        =>  $paid_price,
                   "used_user_balance"  =>  $usedBalance,
                   "app_percentage"     =>  $app_percentage->percentage,
                   "order_tax"          =>  $tax->order_tax,
                   "user_latitude"      =>  $latitude,
                   "user_longitude"     =>  $longitude,
                   "user_lang"          =>  App()->getLocale(),
                   "payment_id"         =>  $payment,
                   "order_status_id"    =>  1,
                   "branch_id"          =>  $branch_id,
                   "user_id"            =>  (new GeneralController())->get_id($request),
                   "process_number"     => $processNumber
        ];

        try {

            DB::transaction(function () use ($data, $meals_arr ,$request, $usedBalance,$branch_id) {

                // insert order data;
                $order_id = DB::table("orders")
                            ->insertGetid($data);
                // insert order meals
                foreach($meals_arr as $value){
                        $order_meal_id = DB::table("order_meals")
                                        ->insertGetid([
                                                "order_id"         => $order_id,
                                                "meal_id"          => $value['meal_id'],
                                                "meal_price"       => $value['price'],
                                                "meal_size_id"     => $value['size'],
                                                "quantity"         => $value['meal_qty']
                                        ]);

                        foreach($value['options'] as $insertOptions){
                            DB::table("order_meals_options")
                                    ->insert([
                                         "order_meals_id" => $order_meal_id,
                                         "option_id"      => $insertOptions['id'],
                                         "added_price"    => $insertOptions['add_price']
                                    ]);
                        }
                        foreach($value['add'] as $insertAdds){
                            DB::table("order_meals_adds")
                                    ->insert([
                                         "order_meals_id" => $order_meal_id,
                                         "add_id"         => $insertAdds['id'],
                                         "added_price"    => $insertAdds['added_price']
                                    ]);
                        }
                }
                $user_balance = DB::table("balances")
                                    ->where("actor_id" , (new GeneralController())->get_id($request))
                                    ->where("actor_type" , "user")
                                    ->select("balance")
                                    ->first();
                if($user_balance){
                    $new_balance = $user_balance->balance - $usedBalance;
                    $user_balance = DB::table("balances")
                                    ->where("actor_id" , (new GeneralController())->get_id($request))
                                    ->where("actor_type" , "user")
                                    ->update([
                                        "balance" => $new_balance
                                        ]);
                }
                /*
                 ************
                 ** Send Push Notification to Provider and branch
                 ************
                */


                $userobj = DB::table('users') -> whereId((new GeneralController())->get_id($request));

                if($userobj){

                         $notif_data = array();

                $content = "  هناك طلب جديد من المستخدم ".$userobj -> first()-> name;

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



            });


            return response()->json([
                    "status" => true,
                    "errNum"  => 0,
                    "msg"      => $msg[8],
                ]);
        }
        catch (Exception $e) {
			return response()->json(['status' => false, 'errNum' => 9, 'msg' => $msg[9]]);
		}

    }

    public function cancel_order(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "order_id"  => "required|exists:orders,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.order.id.not.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $order_id = $request->input("order_id");
        $order = DB::table("orders")
                        ->where("id", $order_id)
                        ->where("user_id", (new GeneralController())->get_id($request))
                        ->select("order_status_id")
                        ->first();
        if(!$order || $order->order_status_id != 1){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
        }
        DB::table("orders")
                ->where("id" , $order_id)
                ->update([
                    "order_status_id" => 5
                ]);
        /*
        **********
        *** Send Push notification to the provider
        **********
        */
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }

    public function get_list_of_orders(Request $request){
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
        $arrValues = ($type == "0") ? [1,2,3] : [4,5];

        $orders = DB::table("orders")
                            ->join("branches" , "branches.id" , "orders.branch_id")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->join("images" , "images.id" , "providers.image_id")
                            ->join("order_statuses" , "order_statuses.id" , "orders.order_status_id")
                            ->where("orders.user_id" , (new GeneralController())->get_id($request))
                            ->whereIn("orders.order_status_id" , $arrValues)
                            ->select(
                                "orders.id AS order_id",
                                "orders.order_code",
                                "branches.id AS restaurant_id",
                                 DB::raw("CONCAT(providers.".$name."_name,' - ', branches.".$name."_name) AS name"),
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                DB::raw("DATE(orders.order_date) AS order_date"),
                                DB::raw("TIME(orders.order_date) AS order_time"),
                                "order_statuses.id AS status_id",
                                "order_statuses.". $name ."_name AS status",
                                "orders.user_latitude AS latitude",
                                "orders.user_longitude AS longitude"
                            )
                            ->orderBy("orders.created_at" , "DESC")
                            ->paginate(10);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "orders" => $orders]);
    }

    public function get_order_details(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "order_id"  => "required|exists:orders,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.order.id.not.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $order_id = $request->input("order_id");
        $order = DB::table("orders")
                    ->join("branches" , "branches.id" , "orders.branch_id")
                    ->join("providers" , "providers.id" , "branches.provider_id")
                    ->join("images" , "images.id" , "providers.image_id")
                    ->join("order_statuses" , "order_statuses.id" ,"orders.order_status_id")
                    ->join("payment_methods" , "payment_methods.id" , "orders.payment_id")
                    ->where("orders.id" , $order_id)
                    ->select(
                                "orders.id AS order_id",
                                "orders.order_code",
                                "orders.is_delivery",
                                "branches.id AS restaurant_id",
                                "providers.".$name."_name AS name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                DB::raw("DATE(orders.order_date) AS order_date"),
                                DB::raw("TIME(orders.order_date) AS order_time"),
                                "order_statuses.id AS status_id",
                                "order_statuses.". $name ."_name AS status",
                                "payment_methods." . $name . "_name AS payment_method_name",
                                "payment_methods.id AS payment_method_id",
                                "orders.order_tax",
                                "orders.delivery_price",
                                "orders.total_price",
                                "orders.user_latitude AS latitude",
                                "orders.user_longitude AS longitude"
                    )
                    ->first();
        $meals = DB::table("order_meals")
                        ->where("order_id" , $order_id)
                        ->join("meals" , "meals.id" , "order_meals.meal_id")
                        ->select(
                            "order_meals.id AS order_meal_id",
                            "order_meals.meal_price",
                            "order_meals.quantity AS qty",
                            "meals." . $name . "_name AS meal_name"
                            )
                        ->get();

        foreach($meals as $meal){
            $options = DB::table("order_meals_options")
                            ->where("order_meals_id" , $meal->order_meal_id)
                            ->select(DB::raw("SUM(added_price) AS options_price"))
                            ->first();
            $adds = DB::table("order_meals_adds")
                ->where("order_meals_id" , $meal->order_meal_id)
                ->select(DB::raw("SUM(added_price) AS adds_price"))
                ->first();

            $meal->meal_price += $options->options_price;
            $meal->meal_price += $adds->adds_price;
            unset($meal->order_meal_id);
        }
        $order->meals = $meals;
        $fav = DB::table("order_favorits")
                    ->where("order_id" , $order_id)
                    ->where("user_id" , (new GeneralController())->get_id($request))
                    ->select("*")
                    ->first();
        if($fav){
            $order->is_user_fav_order = true;
        }else{
            $order->is_user_fav_order = false;
        }
        if($order->latitude && $order->longitude){
            $address = (new GeneralController())->get_address_from_location($order->latitude, $order->longitude , App()->getLocale());
        }else{
            $address = "";
        }

        $order->address = $address;
        return response()->json([
                    "status"  => true,
                    "errNum"  => 0,
                    "msg"     => $msg[3],
                    "order"   => $order
            ]);
    }

    public function add_favorit_order(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "order_id"  => "required|exists:orders,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.order.id.not.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
            6   => trans("messages.favorite.order.not.finished")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $order_id = $request->input("order_id");
        $status = DB::table("orders")
                    ->where("id" , $order_id)
                    ->select("order_status_id")
                    ->first();
        if(!($status->order_status_id == 4 || $status->order_status_id == 5)){
            return response()->json(['status' => true, 'errNum' => 6, 'msg' => $msg[6]]);
        }
        $fav  =  DB::table("order_favorits")
                    ->where("user_id" , (new GeneralController())->get_id($request))
                    ->where("order_id" , $order_id)
                    ->select("*")
                    ->first();
        if($fav){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
        }
        DB::table("order_favorits")
                ->insert([
                    "user_id" => (new GeneralController())->get_id($request),
                    "order_id"  => $order_id
                ]);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }
    public function remove_favorit_order(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "order_id"  => "required|exists:orders,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.order.id.not.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $order_id = $request->input("order_id");
        $fav  =  DB::table("order_favorits")
                    ->where("user_id" , (new GeneralController())->get_id($request))
                    ->where("order_id" , $order_id)
                    ->select("*")
                    ->first();
        if(!$fav){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
        }
        DB::table("order_favorits")
                ->where("user_id" , (new GeneralController())->get_id($request))
                ->where("order_id"  , $order_id)
                ->delete();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }
    public function get_favorit_orders(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [

        ];
        $messages   = [
            "required"             => 1,
        ];
        $msg        = [
            1   => trans("messages.required"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }


        $orders = DB::table("order_favorits")
                            ->join("orders" , "orders.id" , "order_favorits.order_id")
                            ->join("branches" , "branches.id" , "orders.branch_id")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->join("images" , "images.id" , "providers.image_id")
                            ->join("order_statuses" , "order_statuses.id" , "orders.order_status_id")
                            ->where("order_favorits.user_id" , (new GeneralController())->get_id($request))
                            ->select(
                                "orders.id AS order_id",
                                "orders.order_code",
                                "branches.id AS restaurant_id",
                                "providers.".$name."_name AS name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                DB::raw("DATE(orders.order_date) AS order_date"),
                                DB::raw("TIME(orders.order_date) AS order_time"),
                                "order_statuses.id AS status_id",
                                "order_statuses.". $name ."_name AS status",
                                "orders.user_latitude AS latitude",
                                "orders.user_longitude AS longitude"
                            )
                            ->get();
        foreach($orders as $order){
            $meals = DB::table("order_meals")
                        ->join("meals" , "meals.id" , "order_meals.meal_id")
                        ->where("order_meals.order_id" , $order->order_id)
                        ->select(
                            "order_meals.quantity AS qty",
                            "meals." . $name  . "_name AS name"
                        )->get();
            $order->meals = $meals;
        }
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "orders" => $orders]);
    }
    public function get_favorit_order_details(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "order_id"  => "required|exists:orders,id",
        ];
        $messages   = [
            "required"             => 1,
            "exists"               => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.order.id.not.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $order_id = $request->input("order_id");
        $order = $this->get_order_details_data($order_id,$name);

        unset($order->order_app_percentage);
        unset($order->in_future);
        $tax = DB::table("app_settings")
                    ->select("order_tax")
                    ->first();
        $branch = DB::table("branches")
                        ->where("id" ,$order->restaurant_id)
                        ->select("delivery_price")
                        ->first();
        $order->order_tax = $tax->order_tax;
        if($order->is_delivery != 0){
            $order->delivery_price = $branch->delivery_price;
        }
        $meals = DB::table("order_meals")
                        ->join("meals" , "meals.id" , "order_meals.meal_id")
                        ->leftjoin("meal_sizes" , "meal_sizes.id" ,"order_meals.meal_size_id")
                        ->where("order_meals.order_id" , $order_id)
                        ->select(
                            "meals.id AS meal_id",
                            "meals.price",
                            "order_meals.quantity AS qty",
                            "meals." . $name . "_name AS meal_name",
                            "order_meals.meal_size_id",
                            "order_meals.id AS order_meal_id"
                            )
                        ->get();

        $total_meals_price = 0;
        foreach($meals as $meal){

            if($meal->meal_size_id != 0){
                $size = DB::table("meal_sizes")
                            ->where("id" , $meal->meal_size_id)
                            ->select("price")
                            ->first();

                $meal->price =  $size->price;
            }
            $options = DB::table("order_meals_options")
                            ->join("meal_options" , "meal_options.id" ,"order_meals_options.option_id")
                            ->where("order_meals_id" , $meal->order_meal_id)
                            ->select(DB::raw("SUM(meal_options.added_price) AS options_price"))
                            ->first();

            $optionsId = DB::table("order_meals_options")
                            ->join("meal_options" , "meal_options.id" , "order_meals_options.option_id")
                            ->where("order_meals_id" , $meal->order_meal_id)
                            ->select("order_meals_options.option_id AS id")
                            ->get();

            $meal->options = $optionsId;
            $adds = DB::table("order_meals_adds")
                            ->join("meal_adds" , "meal_adds.id" , "order_meals_adds.add_id")
                            ->where("order_meals_id" , $meal->order_meal_id)
                            ->select(DB::raw("SUM(meal_adds.added_price) AS adds_price"))
                            ->first();


            $addsId = DB::table("order_meals_adds")
                            ->join("meal_adds" , "meal_adds.id" , "order_meals_adds.add_id")
                            ->where("order_meals_id" , $meal->order_meal_id)
                            ->select("order_meals_adds.add_id AS id")
                            ->get();

            $meal->add = $addsId;
            $meal->price += $options->options_price;
            $meal->price += $adds->adds_price;
            $total_meals_price += ($meal->qty) * ($meal->price);
            unset($meal->meal_size_id);
            unset($meal->order_meal_id);
        }
        $order->total_price = $order->order_tax +  $order->delivery_price + $total_meals_price;

        $order->meals = $meals;

        if($order->latitude && $order->longitude){
            $address = (new GeneralController())->get_address_from_location($order->latitude, $order->longitude , App()->getLocale());
        }else{
            $address = "";
        }
        $order->address = $address;
        return response()->json([
                    "status"  => true,
                    "errNum"  => 0,
                    "msg"     => $msg[3],
                    "order"   => $order
            ]);
    }

    protected function get_order_details_data($order_id,$name){
        return DB::table("orders")
                    ->join("branches" , "branches.id" , "orders.branch_id")
                    ->join("providers" , "providers.id" , "branches.provider_id")
                    ->join("images" , "images.id" , "providers.image_id")
                    ->join("order_statuses" , "order_statuses.id" ,"orders.order_status_id")
                    ->join("payment_methods" , "payment_methods.id" , "orders.payment_id")
                    ->where("orders.id" , $order_id)
                    ->select(
                                "orders.id AS order_id",
                                "orders.order_code",
                                "orders.is_delivery",
                                "orders.in_future",
                                "providers.order_app_percentage",
                                "branches.id AS restaurant_id",
                                "providers.".$name."_name AS name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                DB::raw("DATE(orders.order_date) AS order_date"),
                                DB::raw("TIME(orders.order_date) AS order_time"),
                                "order_statuses.id AS status_id",
                                "order_statuses.". $name ."_name AS status",
                                "payment_methods." . $name . "_name AS payment_method_name",
                                "payment_methods.id AS payment_method_id",
                                "orders.order_tax",
                                "orders.delivery_price",
                                "orders.total_price",
                                "orders.user_latitude AS latitude",
                                "orders.user_longitude AS longitude"
                    )
                    ->first();
    }
    protected function getuserbalance(Request $request){
        $balance = DB::table("balances")
                        ->where("actor_id" , (new GeneralController())->get_id($request))
                        ->where("actor_type" , "user")
                        ->select("balance")
                        ->first();
        if($balance){
                return $balance->balance;
        }else{
                return 0;
        }
    }
}
