<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Damas\Paytabs;
use Session;
use DB;
class PaymentController extends Controller
{
    protected $merchant_email = "Mjrb20182@gmail.com";
    protected $access_token = "xru0xOaVxn7vurcB7v4SGN8syKh2nsjUUOVrC6m9ttFYVRA2nEU3s3v1NN3afn49b0BN6XXArCymu8oRNjVfmqh9ekjuIoEUofHv";
    public function get_payment_page(){

        $user_name_arr = explode(" ", auth()->user()->name);

        $order_data = (array)Session::get("order_data");


        if(count($order_data) == 0){

            return redirect("/user/dashboard");

        }

        $pt = Paytabs\paytabs::getInstance($this->merchant_email, $this->access_token);
        $result = $pt->create_pay_page(array(
            "merchant_email" => $this->merchant_email,
            'secret_key' => $this->access_token,
            'title' => auth()->user()->name,
            'cc_first_name' => $user_name_arr[0],
            'cc_last_name' => (isset($user_name_arr[1])) ? $user_name_arr[1] : $user_name_arr[0] ,
            'email' => auth()->user()->email,
            'cc_phone_number' => "966",
            'phone_number' => auth()->user()->phone,
            'billing_address' => "Juffair, Manama, Bahrain",
            'city' => "Manama",
            'state' => "Capital",
            'postal_code' => "97300",
            'country' => "BHR",
            'address_shipping' => "Juffair, Manama, Bahrain",
            'city_shipping' => "Manama",
            'state_shipping' => "Capital",
            'postal_code_shipping' => "97300",
            'country_shipping' => "BHR",
            "products_per_title"=> "mjrb order number " . $order_data['order_code'],
            'currency' => "SAR",
            "unit_price"=> $order_data['paid_amount'],
            'quantity' => "1",
            'other_charges' => "0",
            'amount' => $order_data['paid_amount'],
            'discount'=>"0",
            "msg_lang" => "english",
            "reference_no" => $order_data['order_code'],
            "site_url" => "http://www.mjrb.wisyst.info",
            'return_url' => "http://www.mjrb.wisyst.info/user/paytabs_response",
            "cms_with_version" => "API USING PHP"
        ));

        if($result->response_code == 4012){
            return redirect($result->payment_url);
        }
        return $result->result;

    }

    public function payment_response(Request $request){

        $pt = Paytabs\paytabs::getInstance($this->merchant_email, $this->access_token);
        $result = $pt->verify_payment($request->payment_reference);
        if($result->response_code == 100){

            $data = (array)Session::get("order_data");
            $data['process_number'] = $result->pt_invoice_id;

            (new CartController())->add_order($data);

            $order_app_percentage = $data['app_percentage'];
            $total_paid_value = $data['total_price'];


            $app_value = ($order_app_percentage / 100) * $total_paid_value;

            $provider_due_balance = $total_paid_value - $app_value;

            $usedBalance = $data['used_user_balance'];

            // update provider balance

            $cart = Session::get("basket");
            $provider_id = 0;
            foreach($cart as $key => $item){
    

                $branch_data = (new CartController())->get_delivery_price($item['meal_id']);
    
                $provider_id = $branch_data->provider_id;
                break;
            }

            $provider_balance = DB::table("balances")
                            ->where("actor_id", $provider_id)
                            ->where("actor_type", "provider")
                            ->first();

            if($provider_balance){

                DB::table("balances")
                            ->where("actor_id", $provider_id)
                            ->where("actor_type", "provider")
                            ->update([
                                "balance" => ($provider_balance->balance + $provider_due_balance)
                            ]);

            }else{

                DB::table("balances")
                    ->insert([
                        "actor_id"   => $provider_id,
                        "actor_type" => "provider",
                        "balance"    => ( (int)$provider_due_balance )
                    ]);
            }

            // update user balance
            $user_balance = DB::table("balances")
                            ->where("actor_id", auth()->id())
                            ->where("actor_type", "user")
                            ->first();

            if($user_balance){

                DB::table("balances")
                    ->where("actor_id", auth()->id())
                    ->where("actor_type", "user")
                    ->update([
                        "balance" => ((int)$user_balance->balance - (int)$usedBalance)
                    ]);
            }

            // update app balance
            $app_balance = DB::table("balances")
                            ->where("actor_type", "app")
                            ->first();

            if($app_balance){
                DB::table("balances")
                        ->where("actor_type", "app")
                        ->update([
                            "balance" => (int)$app_balance->balance + (int)$total_paid_value
                        ]);
            }else{
                DB::table("balances")
                            ->insert([
                                "actor_id" => 0,
                                "actor_type" => "app",
                                "balance" => $total_paid_value
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
                     
                       $providerId =DB::table('branches') -> whereId($branch_data -> branch_id) -> select('provider_id') -> first();
                
                $provData= DB::table('providers') -> whereId($providerId -> provider_id) ;
                
                
                if($provData){
                    
                       $providerWebtokenSubscribe = $provData -> select('webtokenSubscribe') -> first();
                         
                             if($providerWebtokenSubscribe  -> webtokenSubscribe){
                                
                                (new \App\Http\Controllers\Apis\User\PushNotificationController())->sendNotificationToWebBrowser($providerWebtokenSubscribe -> webtokenSubscribe,$notif_data);
                                }
                             
                        }
                }else{
                    
                      
                         $providerId =DB::table('branches') -> whereId($branch_data -> branch_id) -> select('provider_id') -> first();
                
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
            return redirect("/user/cart/order-failed");
        }

    }
}
