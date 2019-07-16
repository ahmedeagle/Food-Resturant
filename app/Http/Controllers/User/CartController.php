<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use DB;
class CartController extends Controller
{
    public function get_cart_page(){

        $data['title'] = ' - السلة';
        $data['class'] = 'front-page page-template';

        $cart  = Session::get("basket");

        foreach((array)$cart as $key => $item){

            $meal_data = DB::table("meals")
                            ->where("id", $item['meal_id'])
                            ->where("published", "1")
                            ->where("deleted", "0")
                            ->select(
                                "meals.ar_name AS name",
                                "meals.price"
                            )->first();

            if(!$meal_data){
                Session::forget("basket.{$key}");
                continue;
            }
            $img = DB::table("meal_images")
                            ->join("images", "images.id", "meal_images.image")
                            ->where("meal_id", $item['meal_id'])
                            ->select(
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                            )->first();

            if($item['size'] == 0){
                // size => 0 user select the default price
                $price = $meal_data->price;
            }else{
                $sizeData = DB::table("meal_sizes")
                                ->where("id", $item['size'])
                                ->select(
                                    "price"
                                )->first();
                if(!$sizeData){
                    Session::forget("basket.{$key}");
                    continue;
                }
                $price = $sizeData->price;
            }

            $optionsName = "";
            $optionsAddedPrice = 0;

            foreach($item['options'] as $keyOption => $option){
                $optionsData = DB::table("meal_options")
                                ->where("id", $option)
                                ->select(
                                        "ar_name AS name",
                                        "added_price"
                                )->first();

                if(!$optionsData){
                    Session::forget("basket.{$key}");
                    continue;
                }
                $delimeter = ($keyOption == "") ? "" : ",";
                $optionsName .= $delimeter . $optionsData->name;
                $optionsAddedPrice = $optionsAddedPrice + (int)$optionsData->added_price;
            }

            $addsName = "";
            $addsAddedPrice = 0;
            foreach($item['adds'] as $keyAdds => $add){
                $addsData = DB::table("meal_adds")
                                ->where("id", $add)
                                ->select(
                                        "ar_name AS name",
                                        "added_price"
                                )->first();

                if(!$addsData){
                    Session::forget("basket.{$key}");
                    continue;
                }
                $delimeter = ($keyAdds == "") ? "" : ",";
                $addsName .= $delimeter . $addsData->name;
                $addsAddedPrice = $addsAddedPrice + (int)$addsData->added_price;
            }



            $cart[$key]['meal_image_url'] = $img->meal_image_url;
            $cart[$key]['meal_name'] = $meal_data->name;
            $cart[$key]['price'] = $price;
            $cart[$key]['optionsNameString'] = $optionsName;
            $cart[$key]['optionsAddedPrice'] = $optionsAddedPrice;
            $cart[$key]['addsNameString'] = $addsName;
            $cart[$key]['addsAddedPrice'] = $addsAddedPrice;

        }

        $data['cart'] = (array)$cart;
        return view("User.pages.cart.cart", $data);
    }

    public function add(Request $request){

        $meal_id = $request->input("meal_id");
        $size = $request->input("size");

        $options = ($request->input("options") == null)? [] : explode(",", $request->input("options"));
        $adds = ($request->input("adds") == null) ? [] : explode(",", $request->input("adds"));


        $branch = DB::table("meals")
            ->where("id", $meal_id)
            ->first();
        if(!$branch){
            return redirect("/user/dashboard");
        }
        $dataResponse = [];
        if(Session::has("basket")){


            $basket = Session::get("basket");

            $c_branch = 0;
            foreach($basket as $key => $item){

                $currentBranch = DB::table("meals")
                    ->where("id", $item['meal_id'])
                    ->first();

                $c_branch = $currentBranch->branch_id;
                break;

            }

            if($c_branch == $branch->branch_id){

                // check if the meal exist in basket
                if($this->check_meal_exist($meal_id)){

                    $key_exist = false;
                    $key_number = 0;
                    foreach($basket as $key => $item){

                        if($meal_id != $item['meal_id']){
                            continue;
                        }

                        $addKey = $this->check_adds($adds, $key);
                        $optionKey = $this->check_options($options, $key);
                        $sizeCheck = $this->check_meal_size($size, $key);

                        if($addKey && $optionKey && $sizeCheck){
                            $key_exist = true;
                            $key_number = $key;
                        }
                    }

                    if( $key_exist ){

                        $dataResponse = $this->increment_qty($key_number);

                    }else{
                        $dataResponse =$this->add_meal($meal_id, $size, $options, $adds);
                    }

                }else{
                    $dataResponse = $this->add_meal($meal_id, $size, $options, $adds);

                }

            }else{

                // clear the basket
                Session::forget("basket");
                // add the meal to basket
                $dataResponse = $this->add_meal($meal_id, $size, $options, $adds);
            }

        }else{
            // add the meal to basket
            $dataResponse = $this->add_meal($meal_id,$size,  $options, $adds);
        }
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg" => trans("messages.success"),
            "data" => $dataResponse
        ]);
    }

    public function remove_cart_meal($key){

        App()->setLocale("ar");
        if(!Session::has("basket.{$key}")){
            return redirect("/user/dashboard");
        }

        Session::forget("basket.{$key}");

        return redirect()->back()->with("success", trans("messages.success"));
    }

    function add_meal($meal_id, $size, array $options, array $adds){


        $data = [
            "meal_id"   => $meal_id,
            "qty"       => 1,
            "size"      => $size,
            "options"   => $options,
            "adds"      => $adds
        ];
        Session::put("basket.". \Carbon\Carbon::now()->timestamp ."", $data);

        $total_price = $this->get_cart_total_price($meal_id, $size, $options, $adds);
        $dataResponse = [
            "meal_id" => $meal_id,
            "qty"     =>  1,
            "size"    => $size,
            "options" => $options,
            "adds"    => $adds,
            "price"   =>  $total_price
        ];
        return $dataResponse;

    }
    function check_meal_exist($meal_id){

        $basket = Session::get("basket");
        foreach ($basket as $item){

            if($item['meal_id'] == $meal_id){
                return true;
            }

        }
        return false;
    }

    function check_options(array $options, $key){

        $basket = Session::get("basket.{$key}");

        if(count($options) == 0 && count($basket['options']) == 0){
            return true;
        }

        $check = false;
        foreach($options as $option){
            if(in_array($option, $basket['options'])){
                $check = true;
            }else{
                $check = false;
                break;
            }
        }
        return $check;

    }

    function check_adds(array $adds, $key){

        $basket = Session::get("basket.{$key}");

        if(count($adds) == 0 && count($basket['adds']) == 0){
            return true;
        }

        $check = false;
        foreach($adds as $add){

            if(in_array($add, $basket['adds'])){
                $check = true;
            }else{
                $check = false;
                break;
            }
        }

        return $check;
    }


    public function check_meal_size($size, $key){

        $basket = Session::get("basket.{$key}");

        if ($basket['size'] == $size){
            return true;
        }

        return false;
    }

    function increment_qty($iterate){

        $basket = Session::get("basket");
        foreach($basket as $key => $item){
            if($iterate == $key){

                $total_price = $this->get_cart_total_price($item['meal_id'], $item['size'], $item['options'], $item['adds']);

                $data = [
                    "meal_id" => $item['meal_id'],
                    "qty"     => (int)$item['qty'] + 1,
                    "size"    => $item['size'],
                    "options" => $item['options'],
                    "adds"    => $item['adds'],
                    "price"   => ((int)$item['qty'] + 1) * ( $total_price)
                  ];
                Session::put("basket.{$key}", $data);
                return $data;
            }
        }
    }

    function get_cart_total_price($meal_id, $size, $options, $adds){
        $meal = DB::table("meals")
            ->where("id", $meal_id)
            ->first();

        if($size == 0){
            $price = (int)$meal->price;
        }else{
            $priceData = DB::table("meal_sizes")
                ->where("id", $size)
                ->first();
            $price = (int)$priceData->price;
        }

        $optionsPrice = 0;
        $addsPrice = 0;

        foreach((array)$options as $option){
            $optionsData = DB::table("meal_options")
                ->where("id", $option)
                ->first();
            $optionsPrice = $optionsPrice + (int) $optionsData->added_price;
        }

        foreach((array)$adds as $add){
            $addsData = DB::table("meal_adds")
                ->where("id", $add)
                ->first();

            $addsPrice = $addsPrice + (int) $addsData->added_price;
        }

        return  $price + $optionsPrice + $addsPrice;
    }

    public function check_cart_content(Request $request){

        $meal_id    = $request->input("meal_id");
        $size       = $request->input("size");
        $options    = ($request->input("options") == null)? [] : explode(",", $request->input("options"));
        $adds       = ($request->input("adds") == null) ? [] : explode(",", $request->input("adds"));

        $key_exist = false;
        $key_number = 0;
        $qty = 0;
        $price = $this->get_cart_total_price($meal_id, $size, $options, $adds);

        if(Session::has("basket")){


            $basket = Session::get("basket");

            // check if the meal exist in basket
            if($this->check_meal_exist($meal_id)){

                foreach($basket as $key => $item){

                    if($meal_id != $item['meal_id']){
                        continue;
                    }

                    $addKey = $this->check_adds($adds, $key);
                    $optionKey = $this->check_options($options, $key);
                    $sizeCheck = $this->check_meal_size($size, $key);

                    if($addKey && $optionKey && $sizeCheck){
                        $key_exist = true;
                        $key_number = $key;
                        $qty = $item['qty'];
                        $price = ((int) $item['qty']) * $price;
                    }
                }
            }
        }

        return response()->json([
            "status"        => true,
            "errNum"        => 0,
            "message"       => trans("messages.success"),
            "key_exist"     => $key_exist,
            "key_number"    => $key_number,
            "qty"           => $qty,
            "price"         => $price
        ]);

    }

    public function get_complete_order(){

        // get the branch delivery price
        $cart = Session::get("basket");

        if(count((array)$cart) == 0){

            return redirect("/user/dashboard");

        }

        $delivery_price = 0;
        $total_price = 0;

        foreach($cart as $key => $item){

            $price = ($item['qty']) * ( $this->get_cart_total_price($item['meal_id'], $item['size'], $item['options'], $item['adds']));

            $total_price = $total_price + (int) $price;

            if ($delivery_price != 0) {
                continue;
            }


            $delivery_price = $this->get_delivery_price($item['meal_id'])->delivery_price;
            

        }



        $data['tax'] = $this->get_tax_value();
        $data['total_price'] = $total_price;
        $data['delivery_price'] = $delivery_price;

        $data['user_balance'] = $this->get_user_balance();

        $data['total_paid_value'] =  $data['total_price'] + ( ( $data['tax'] * $data['total_price'] ) / ( 100 ) );

        $data['title'] = ' - إكمال الطلب';
        $data['class'] = 'front-page page-template';

        $data['payment_methods'] = DB::table("payment_methods")
                                    ->select(
                                        "id",
                                        "ar_name AS name"
                                    )->get();

        return view("User.pages.cart.complete-order", $data);
    }

    public function post_complete_order(Request $request){
        date_default_timezone_set('Asia/Riyadh');
          
        App()->setLocale("ar");

        if(!Session::has("basket")){
            return redirect("/user/dashboard");
        }
        $rules = [
            "in_future"          => 'required|in:0,1',
            "delivery_method"    => "required|in:0,1",
            "payment_method"     => "required|exists:payment_methods,id",

        ];


        if($request->input("delivery_method") == "1"){

            $rules['lat'] = "required";
            $rules['lng'] = "required";

        }

        if($request->input("in_future") == "1"){

            $rules["date"] = 'required|date_format:Y-m-d|after_or_equal:'.date('Y-m-d');
            $rules["time"] = "required|date_format:H:i";

        }

        $messages = [
            "required"             => trans("messages.required"),
            "lat.required"         => trans("user.location.required"),
            "lng.required"         => trans("user.location.required"),
            "date.date_format"     => trans("messages.reservation.date.format.error"),
            "time.date_format"     => trans("messages.reservation.time.format.error"),
            "in"                   => trans("messages.error"),
            "after_or_equal"       => trans("messages.dateMustAfterorEqualTodat")
        ];


        $this->validate($request, $rules , $messages);
        
          
         
         
         

        $inFuture = $request->input("in_future");
        $payment_method = $request->input("payment_method");
        $delivery_method = $request->input("delivery_method");
        $time = $request->input("time");
        $date = $request->input("date");
        $latitude = $request->input("lat");
        $lng = $request->input("lng");

                
                
                
                //once the app only allow to make order only for one branch at time 
                //get branch id from cart meal item
                
         $cart = Session::get("basket");

           
        foreach($cart as $key => $item){
 

            $branch_data = $this->get_delivery_price($item['meal_id']);
 

            $branch_id = $branch_data->branch_id;
          

        }
        

               if($inFuture == 0 ){

                          //order time 
                 $order_time =  date('H:i:s') ;
                
                //by default day is today in english lang
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
         
         
            }
            
            else{
                
                  
                          //order time 
                  $order_time =  date('H:i:s',strtotime($time)) ;
                 $order_day = lcfirst(date('l', strtotime($date)));

                 
                 //check if this date is open or closed
                $day =    DB::table('branch_working_hours') 
                          -> where('branch_id',$branch_id) 
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
         
         
            
            }
              
               
        // get total order value
        $order_price = 0;

        $cart = Session::get("basket");

        $delivery_price = 0;
        $total_price = 0;

        $branch_id = 0;
        $order_app_percentage = 0;
        $provider_id = 0;

        $tax = $this->get_tax_value();
        $balance = $this->get_user_balance();

        foreach($cart as $key => $item){

            $price = ($item['qty']) * ( $this->get_cart_total_price($item['meal_id'], $item['size'], $item['options'], $item['adds']));

            $total_price = $total_price +  $price;

            if ($branch_id != 0) {
                continue;
            }


            $branch_data = $this->get_delivery_price($item['meal_id']);

            $delivery_price = ($delivery_method == "1") ? $branch_data->delivery_price : 0;

            $branch_id = $branch_data->branch_id;
            $order_app_percentage = $branch_data->app_percentage;
            $provider_id = $branch_data->provider_id;

        }

        $total_paid_without_tax = $total_price + $delivery_price;
        $total_paid_value = $total_paid_without_tax + ( ( $tax * $total_paid_without_tax) / 100);
 

        $data_time_string = $date . " " . $time . ":00";

        $orderDateTime = ($inFuture == "1") ? $data_time_string : \Carbon\Carbon::now();

        $code  = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(10);



         $orderTotal = $total_paid_value;
         $paid_price = $orderTotal;
         
         if($orderTotal <= 0 ){
             return response() -> json(['balanceMessage' => 'اجمالي الطلب غير صحيح', 'type' => "1"]);
         }
         if(auth()-> check()){
                  $userBalance = DB::table('balances') ->where('actor_id',auth() -> id()) -> where('actor_type','user') -> select('balance') -> first();
                     if($userBalance -> balance > 0 )
                     {
                         
                           $discountedBalance = abs($userBalance -> balance -  $orderTotal);
                           
                         if(  $userBalance -> balance >= $orderTotal) 
                          {
                               
                               
                                $paid_price  = 0;
                                $usedBalance =$orderTotal;
 
 
                          }else{
                              
                                        
                                       $paid_price = $discountedBalance;
                                       $usedBalance =$userBalance -> balance;
 
                            }
                          
                     }else{
                           
                        // return response() -> json(['balanceMessage' => 'رصيدك لايسمح', 'type'=> "0"]);
                         $usedBalance =0;
                      }
             }else{
                 
                  return response() -> json(['balanceMessage' => 'لأابد من تسجيل الدخول اولا ', 'type' => "1"]);
             }
             
         
        $data = [
            "order_code"         =>  $code,
            "in_future"          =>  $inFuture,
            "order_date"         =>  $orderDateTime,
            "is_delivery"        =>  $delivery_method,
            "delivery_price"     =>  $delivery_price,
            "total_price"        =>  $total_paid_value,
            "paid_amount"        =>  $paid_price,
            "used_user_balance"  =>  $usedBalance,
            "app_percentage"     =>  $order_app_percentage,
            "order_tax"          =>  $tax,
            "user_latitude"      =>  ($latitude == null) ? '' : $latitude,
            "user_longitude"     =>  ($lng == null) ? '' : $lng,
            "user_lang"          =>  'ar',
            "payment_id"         =>  $payment_method,
            "order_status_id"    =>  1,
            "branch_id"          =>  $branch_id,
            "user_id"            =>  auth()->id(),
            "process_number"     =>  ""
        ];

        if($payment_method == "1" or $data['paid_amount'] == 0){

            $this->add_order($data);
            $app_value = ($order_app_percentage / 100) * $total_paid_value;
            // get provider balance
            $provider_balance = DB::table("balances")
                                    ->where("actor_id", $provider_id)
                                    ->where("actor_type", "provider")
                                    ->first();

            if($provider_balance){

                DB::table("balances")
                    ->where("actor_id", $provider_id)
                    ->where("actor_type", "provider")
                    ->update([
                        "balance" => ($provider_balance->balance - $app_value)
                    ]);
            }else{
                DB::table("balances")
                    ->insert([
                        "actor_id"   => $provider_id,
                        "actor_type" => "provider",
                        "balance"    => ( - $app_value )
                    ]);
            }

            $user_balance = DB::table("balances")
                            ->where("actor_id", auth()->id())
                            ->where("actor_type", "user")
                            ->first();

            if($user_balance){

                DB::table("balances")
                    ->where("actor_id", auth()->id())
                    ->where("actor_type", "user")
                    ->update([
                        "balance" => ($user_balance->balance - $usedBalance)
                    ]);
            }

             
    
                // push notification to branch web browser

                $notif_data = array();
                
                $content = "  هناك طلب جديد من المستخدم ".auth() -> user() -> name;

                $notif_data['title']      = 'مجرب';
                $notif_data['body']       = $content;
                $notif_data['icon']       = env('APP_URL').'/assets/site/img/logo.png';
              
                

                if($branch_data  -> webtokenSubscribe){
                     
                     (new \App\Http\Controllers\Apis\User\PushNotificationController())->sendNotificationToWebBrowser($branch_data->webtokenSubscribe,$notif_data);
                     
                       $providerId =DB::table('branches') -> whereId($branch_id) -> select('provider_id') -> first();
                
                $provData= DB::table('providers') -> whereId($providerId -> provider_id) ;
                
                
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
                 
               
            return redirect("/user/cart/finish-order");
        }else{


            Session::put("order_data", $data);
            
              if($data['paid_amount'] > 0){
                  
                   return (new PaymentController())->get_payment_page();
                   
              }
            
            
        }

    }

    public function get_user_balance(){
        // check user balance
        $balance = DB::table("balances")
                    ->where("actor_id", auth()->id())
                    ->where("actor_type", "user")
                    ->first();

        if($balance){
            return $balance->balance;
        }else{
            return 0;
        }

    }

    public function get_tax_value(){

        $taxData = DB::table("app_settings")
            ->first();

        return $taxData->order_tax;
    }

    public function get_delivery_price($meal_id){

        $branch = DB::table("meals")
                    ->join("branches", "branches.id", "meals.branch_id")
                    ->join("providers", "providers.id", "branches.provider_id")
                    ->where("meals.id", $meal_id)
                    ->select(
                        "branches.id AS branch_id",
                        "branches.delivery_price",
                        "branches.webtokenSubscribe",
                        "providers.id AS provider_id",
                        "providers.order_app_percentage AS app_percentage"
                    )->first();

        return $branch;

    }

    public function get_finish_order(){

        $data['title'] = ' -الطلب';
        $data['class'] = 'front-page page-template';

        return view("User.pages.cart.finish-order", $data);
    }

    public function add_order(array $data){

        $cart = Session::get("basket");

        $order_id = DB::table("orders")
            ->insertGetId($data);

        foreach ($cart as $key => $item){



            if($item['size'] == 0){

                $meal_data = DB::table("meals")
                    ->where("id", $item['size'])
                    ->first();

                $meal_price = $meal_data->price;
            }else{

                $meal_data = DB::table("meal_sizes")
                    ->where("id", $item['size'])
                    ->first();
                $meal_price = $meal_data->price;

            }
            $order_meal_id = DB::table("order_meals")
                ->insertGetId([
                    "order_id" => $order_id,
                    "meal_id"  => $item['meal_id'],
                    "meal_size_id" => $item['size'],
                    "quantity"     => $item['qty'],
                    "meal_price"   => $meal_price
                ]);

            foreach($item['adds'] as $add){

                $add_price = DB::table("meal_adds")
                    ->where("id", $add)
                    ->first();

                DB::table("order_meals_adds")
                    ->insert([

                        "order_meals_id" => $order_meal_id,
                        "add_id"   => $add,
                        "added_price" => $add_price->added_price

                    ]);

            }

            foreach($item['options'] as $option){

                $add_price = DB::table("meal_options")
                    ->where("id", $option)
                    ->first();

                DB::table("order_meals_options")
                    ->insert([

                        "order_meals_id" => $order_meal_id,
                        "option_id"   => $option,
                        "added_price" => $add_price->added_price

                    ]);

            }

        }
    }

    public function get_failed_order(){

        $data['class'] = "";
        $data['title'] = " - فشل فى اضافة الطلب";
        return view("User.pages.cart.order-failed", $data);
    }
    
    
    public function checkUserBalance(Request $request){
          
         $orderTotal = $request -> orderTotal;
         
         if($orderTotal <= 0 ){
             return response() -> json(['balanceMessage' => 'اجمالي الطلب غير صحيح', 'type' => "1"]);
         }
         if(auth()-> check()){
                  $userBalance = DB::table('balances') ->where('actor_id',auth() -> id()) -> where('actor_type','user') -> select('balance') -> first();
                     if($userBalance -> balance > 0 )
                     {
                         
                           $discountedBalance = abs($userBalance -> balance -  $orderTotal);
                           
                         if(  $userBalance -> balance >= $orderTotal) 
                          {
                               
                                return response() -> json(['balanceMessage' => 'سوف يتم خصم مبلغ من رصيد الحالي وقدره ' .$orderTotal .'وسيصبح رصيدك  بعد تاكيدك للطلب  ' . $discountedBalance, 'type' => "1"]);
 
 
                          }else{
                              
                                  return response() -> json(['balanceMessage' => 'سوف يتم خصم مبلغ من رصيد الحالي وقدره ' .$userBalance -> balance .' ويصبح مبلغ الطلب  المستحق دفعه الان  ' . $discountedBalance, 'type' => "1"]);
 
                            }
                          
                     } 
         }else{
             
              return response() -> json(['balanceMessage' => 'لأابد من تسجيل الدخول اولا ', 'type' => "1"]);
         }
         
          
         
         
            
    }
    
    
}
