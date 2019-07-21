<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Apis\User\SmsController;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class ForgetPasswordController extends Controller
{
    public function get_forget_password(){

        $data['title'] = " - إستعادة كلمة المرور";
        $data['class']  = "page-template password recovery";
        return view("Provider.pages.forget-password" , $data);
    }

    public function post_forget_password(Request $request){
       // App()->setLocale("ar");
        
         $phone = $request->input('phone');
          
             
        if($request -> guard == 1){
            
        $rules = [

            "phone"                 => "required|numeric|exists:branches,phone",
            "guard"                 => "required"
        ];
        $messages = [
            "required"          => trans("messages.required"),
            "phone.numeric"     => trans("messages.phone_numeric"),
            "phone.exists"      => trans("messages.phone_exists"),
        ];
 
               $provider = DB::table("branches")->where("phone", $phone)->first();
        }else{
            
            
                  
        $rules = [

            "phone"                 => "required|numeric|exists:providers,phone",
            "guard"                 => "required"
        ];
        $messages = [
            "required"          => trans("messages.required"),
            "phone.numeric"     => trans("messages.phone_numeric"),
            "phone.exists"      => trans("messages.phone_exists"),
        ];
        

              $provider = DB::table("providers")->where("phone", $phone)->first();
            
        }

         
         $this->validate($request, $rules , $messages);
         

        $code = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);

        $message = (App()->getLocale() == "en")?
            "Your Activation Code is :- " . $code :
            $code . "رقم الدخول الخاص بك هو :- " ;

        $phone_hash = json_encode([
                        'code'   => $code,
                        'expiry' => Carbon::now()->addDays(1)->timestamp,
                    ]);
                    
                    
                        
        if($request -> guard == 1){
            
               
        
        DB::table("branches")
                    ->where("phone", $phone)
                    ->update([
                        "activate_phone_hash" => $phone_hash
                    ]);
        }else{

             
        
        DB::table("providers")
                    ->where("phone", $phone)
                    ->update([
                        "activate_phone_hash" => $phone_hash
                    ]);
            
        }
        
         

        (new \App\Http\Controllers\Apis\User\SmsController())->send($message , $phone);
         
         
        $guard =    ($request -> guard == 1)  ?  'branches' : 'providers';

        return redirect("/restaurant/password-recovery/" . $provider->token .'/'.$guard);
    }

    public function get_password_recovery($token , $guard){

        // check if token exists
        
        if($guard ==  'branches'){
            
            
             $provider = DB::table("branches")->where("token", $token)->first();
             
        }else{
            
            
             $provider = DB::table("providers")->where("token", $token)->first();
        }
       
        
        
        if(!$provider){
            return redirect("/");
        }
        
        
        
        $data['title']  = " - إستعادة كلمة المرور";
        $data['class']  = "page-template password validation";
        $data['token']  = $token;
        $data['guard']   = $guard;
        
        return view("Provider.pages.password-recovery" , $data);

    }

    public function post_password_recovery(Request $request){

        //App()->setLocale("ar");
        $rules = [

            "code"    =>  "required"
        ];
        $messages = [
            "required"  => trans("messages.required")
        ];


        $this->validate($request, $rules , $messages);

        $code  = $request->input('code');
        $token = $request->input('token');
        
        if($request -> guard == 'branches')
        {
              $provider = DB::table("branches")->where("token", $token)->first();
              
        }else{
            
             
             $provider = DB::table("providers")->where("token", $token)->first(); 
        }

         
        if(!$provider){
            return redirect("/");
        }

        $hash = json_decode($provider->activate_phone_hash);

        if($code != $hash->code){
            return redirect()->back()->with("error", trans("messages.register.active.notMatch"));
        }

        if(Carbon::now()->timestamp > $hash->expiry){
            return redirect()->back()->with("error", trans("messages.register.active.expire"));
        }

        return redirect("/restaurant/change-password/" . $token .'/'.$request -> guard);
    }

    public function get_change_password($token,$guard){
        
        // check if token exists
        
        if($guard =='branches'){
               
               $provider = DB::table("branches")->where("token", $token)->first();
               
        }else{
            
              $provider = DB::table("providers")->where("token", $token)->first();
        }
        
        
        
        if(!$provider){
            return redirect("/");
        }
        
        $data['title']  = " - إستعادة كلمة المرور";
        $data['class']  = "page-template password validation";
        $data['token']  = $token;
        $data['guard'] = $guard;
        
        
        return view("Provider.pages.change-password" , $data);
    }

    public function post_change_password(Request $request){
       // App()->setLocale("ar");
        $rules = [

            "password"    =>  "required|min:6|confirmed"
        ];
        $messages = [
            "required"    => trans("messages.required"),
            "min"         => trans("messages.pasword_min"),
            "confirmed"   => trans("messages.confirm_pasword_same"),
        ];


        $this->validate($request, $rules , $messages);

        $password  = $request->input('password');
        $token     = $request->input('token');

  
        if($request -> guard =='branches'){
              
              
               $provider = DB::table("branches")
                        ->where("token", $token)
                        ->first();
            
        }else{
              
              
               $provider = DB::table("providers")
                        ->where("token", $token)
                        ->first();
            
        }
       

        if(!$provider){
            return redirect("/");
        }
        
        
         if($request -> guard =='branches'){

                    DB::table("branches")
                            ->where("token", $token)
                            ->update([
                                "password" => bcrypt($password),
                                "activate_phone_hash" => null
                            ]);
         }else{
             
              
               DB::table("providers")
                            ->where("token", $token)
                            ->update([
                                "password" => bcrypt($password),
                                "activate_phone_hash" => null
                            ]);
             
         }    
         
         

        return redirect("/login")->with("provider-login-success", trans("provider.password-changed"));
    }
}
