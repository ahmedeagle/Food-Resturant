<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Auth;
use App\Provider;
class RegisterController extends Controller
{
    public function post_register(Request $request){

        App()->setLocale("ar");


        $rules = [
            "restaurant-ar-name"        => "required",
            "restaurant-en-name"        => "required",
            "service-provider"          => "required|exists:categories,id",
            "automatic-list"            => "required|in:0,1",
            "accept-online-payment"     => "required|in:0,1",
            "accept-order"              => "required|in:0,1",
            "country"                   => "required|exists:countries,id",
            "city"                      => "required|exists:cities,id",
            //|unique:branches,phone
            "phone-number"              => array('required','regex:/^(05|5)([0-9]{8})$/','numeric','unique:providers,phone'),
            "email"                     => "required|email|unique:providers,email",
            "password"                  => "required|min:6",
            "provider-ar-details"       => "required",
            "provider-en-details"       => "required",
            "image"                     => "required"
        ];
        
         $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.success"),
            7  => trans("messages.phone_numeric"),
            8  => trans("messages.email"),
            10 => trans("messages.email_unique"),
            11 => trans("messages.phone_unique"),
            12 => trans("messages.success"),
         
            
           
        ];
        
        $messages = [
            "restaurant-ar-name.required"                      =>  $msg[1],
            "restaurant-en-name.required"                      =>  $msg[1],
            "service-provider.required"                        =>  $msg[1],
            "automatic-list.required"                          =>  $msg[1],
            "accept-online-payment.required"                   =>  $msg[1],
            "accept-order.required"                            =>  $msg[1],
            "country.required"                                 =>  $msg[1],
            "city.required"                                    =>  $msg[1],
            "phone-number.required"                            =>  $msg[1],
            "email.required"                                   =>  $msg[1],
            "password.required"                                =>  $msg[1],
            "provider-ar-details.required"                     =>  $msg[1],
            "provider-en-details.required"                     =>  $msg[1],
            "image.required"                                   =>  $msg[1],
            "service-provider.exists"                          =>  $msg[1],
            "automatic-list.in"             => ' لابد من اختيار الخدمات المطلوبة ',
            "accept-online-payment.in"      => $msg[1],
            "accept-order.in"               => $msg[1],
            "country.exists"                =>$msg[1],
            "city.exists"                   => $msg[1],
            "phone-number.numeric"          => trans("messages.phone_numeric"),
            "email.email"                   => trans("messages.email"),
            "password.min"                  =>'كلمة المرور اقل من 6 احرف',
            "email.unique"                  => trans("messages.email_unique"),
            "phone-number.unique"           => trans("messages.phone_unique"),
            "phone-number.regex"            =>'صيغة الهاتف غير صحيحة',
            
           
        ];

       

       $validator  = Validator::make($request->all(), $rules, $messages);
       
        if($validator->fails()){
            
            return response()->json($validator->errors(),422);  
            
        }
   
        $code  = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);
        $token = (new \App\Http\Controllers\Apis\User\GeneralController)->getRandomString(128);
        

        $hash = json_encode([
                    'code' => $code,
                    'type' => 'phone-activation',
                    'expiry' => \Carbon\Carbon::now()->addDays(1)->timestamp,
        ]);
        
         $message = "رقم الدخول الخاص بك هو :- " .$code;
        $res = (new \App\Http\Controllers\Apis\User\SmsController())->send($message , $request->input("phone-number"));
        
        
        
        // insert into database
        $data = [
            'ar_name'                   => $request->input("restaurant-ar-name"),
            'en_name'                   => $request->input("restaurant-en-name"),
            'phone'                     => $request->input("phone-number"),
            'email'                     => $request->input("email"),
            'password'                  => bcrypt($request->input("password")),
            'category_id'               => $request->input("service-provider"),
            'country_id'                => $request->input("country"),
            'city_id'                   => $request->input("city"),
            "accept_order"              => $request->input('accept-order'),
            'ar_description'            => $request->input("provider-ar-details"),
            'en_description'            => $request->input("provider-en-details"),
            'online_list'               => $request->input("automatic-list"),
            'accept_online_payment'     => $request->input("accept-online-payment"),
            'activate_phone_hash'       => $hash,
            'token'                     => $token
        ];

        if($request->hasFile("image")){

            $request->image->store('providers', 'public');
            $img_id = DB::table("images")
                ->insertGetId([
                    "name" => $request->image->hashName()
                ]);

            $data['image_id'] = $img_id;
        }



        // generate api token
 
        $id = DB::table("providers")
            ->insertGetId($data);
            
        //create balance account 
        
           DB::table('balances') -> insert([
                         
                         'balance'     => 0,
                         'actor_id'    => $id,
                         'actor_type'  => 'provider',
                        
                 ]);
                 
                 
         

        // authenticate the provider
       // authenticate the provider
       
        Auth::guard('provider')->login(Provider::find($id));
 
        // return redirect to food menu selection
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg"    => $msg[12],
            "token"  => $token,
        ]);
    }
}
