<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Apis\User\GeneralController;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Auth;
use Hash;
class LoginController extends Controller
{
    public function post_login(Request $request){
         
        
        App()->setLocale("ar");
        
        
        $rules = [

            "provider-phone-number"   => "required|numeric",
            "provider-password"       => "required",
            "guard"                   => "required"
            
        ];
        $messages = [
            "required"                          => trans("messages.required"),
            "provider-phone-number.numeric"     => trans("messages.phone_numeric")
        ];


        $this->validate($request, $rules , $messages);

         $phone    =   $request->input('provider-phone-number');
         $password =   $request->input('provider-password');


         if($request -> guard ==1){
             
              if(mb_substr(trim($phone), 0, 1) === '0'){
                  $phone= mb_substr(trim($phone),1,mb_strlen($phone));
              }
              
             
                $branch   =  DB::table('branches') ->where('phone', $phone)->orwhere("phone" , '0'.$phone)->first();  
                
                        if($branch){
                            
                             $data = \App\Branch::find($branch->id) ;
                        }else{
                              
                              
                              return redirect()->back()->with("provider-login-error" , 'لم نجد أي سجلات للبيانات المدخلة');
                            
                        }
                
                
         }else{
              
              
              
                if(mb_substr(trim($phone), 0, 1) === '0'){
                  $phone= mb_substr(trim($phone),1,mb_strlen($phone));
              }
              
              
              $provider =  DB::table('providers')->where('phone', $phone)->orwhere("phone" , '0'.$phone)->first();  
              
                      if($provider){
                        
                         $data = \App\Provider::find($provider->id);
                         
                         //save browser subscrbe token 
                         
                         
                    }else{
                        
                          return redirect()->back()->with("provider-login-error" , 'لم نجد أي سجلات للبيانات المدخلة');
                        
                    }
             
         }
         
                
          //  return    $password .'  -> '. $data->password;                   

        if(Hash::check($password, $data->password) ){
            
           
             // login the user
            $gaurd = ($request -> guard ==1) ? "branch" : "provider";
            Auth::guard($gaurd)->login($data);
            return redirect("/restaurant/dashboard");
        }else{
            return redirect()->back()->with("provider-login-error" , 'كلمة المرور خاطئة');
        }
        
        
        
        

    }
}
