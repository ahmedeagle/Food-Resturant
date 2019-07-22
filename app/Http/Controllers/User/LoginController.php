<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
class LoginController extends Controller
{
    public function login(Request $request){


        // validation
      //  App()->setLocale("ar");
        $rules = [

            "user-data"        => "required",
            "user-password"    => "required",

        ];

        $messages = [
            "required"    => trans("messages.required"),
        ];

        $this->validate($request, $rules , $messages);

        $credential = $request->input('user-data');
        $password   = $request->input('user-password');


        if(filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            $data = "email";
            $user = DB::table("users")
                ->where("email" , $credential)
                ->first();


            if($user == null){
                return redirect()->back()->with("user-error", trans("messages.no.record.found"));
            }
        }elseif(is_numeric($credential)){
            
               
             if(mb_substr(trim($credential), 0, 1) === '0'){
                  $credential= mb_substr(trim($credential),1,mb_strlen($credential));
              }
                   
                   
                   
            $data = "phone";
            $user = DB::table("users")
                ->where("phone" , $credential)
                 ->orwhere("phone" , '0'.$credential)
                ->first();


            if($user == null){
                return redirect()->back()->with("user-error", trans("messages.no.record.found"));
            }
        }else{
            return redirect()->back()->with("user-error", trans("messages.invalid.email.phone"));
        }



        if (Auth::guard('web') -> attempt([$data => $credential, 'password' => $password]) || Auth::attempt([$data => '0'.$credential, 'password' => $password])) {
            // login user
            $user = \App\User::where($data , $credential)->orwhere($data ,'0'.$credential)->first();
            auth()->login($user);
            return redirect("/user/dashboard");
        }else{
            return redirect()->back()->with("user-error", trans("messages.invalid.credential"));
        }
    }

    public function social_login(Request $request){

    }
}
