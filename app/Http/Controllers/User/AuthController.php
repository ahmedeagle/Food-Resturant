<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Session;
use guard;

class AuthController extends Controller
{
    public function __construct()
    {


    }

    public function get_activate_phone(){

        if(auth()->guard('web')->user()->phoneactivated == "1"){

            return redirect("/user/dashboard");

        }
        
        $data['title'] = "تأكيد رقم الهاتف";
        $data['class'] = "page-template password recovery";
        
        return view("User.pages.auth.activate-phone", $data);
        
    }

    public function post_activate_phone(Request $request){

        //App()->setLocale("ar");
        $rules = [

            "code"    => "required",

        ];

        $messages = [
            "required"    => trans("messages.required"),
        ];

        $this->validate($request, $rules , $messages);

        $code = $request->input("code");


        $hash = json_decode(auth('web')->user() -> activate_phone_hash);
        //if (\Carbon\Carbon::now()->gt(Carbon::createFromTimestamp($hash->expiry))) {
        //    return redirect()->back()->with("error", trans("messages.register.active.expire"));
        //}

        if($hash->code != $code){
            return redirect()->back()->with("error", trans("messages.register.active.notMatch"));
        }

        DB::table("users")
                ->where("id", auth('web')->user()->id)
                ->update([
                    "phoneactivated" => "1",
                    "activate_phone_hash" => ""
                ]);

        return redirect("/user/dashboard");

    }

    public function resend_activate_code(){

        $resendCode = Session::get("resend_code");
        if($resendCode){
            if($resendCode > 3){
                return redirect("/user/activate-phone")->with("error", "تم ارسال رقم التفعيل من قبل");
            }else{
                Session::put("resend_code", ($resendCode + 1));
            }
        }else{
            // add the number
            Session::put("resend_code", 1);
        }
        $code  = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);
        $hash = json_encode([
            'code' => $code,
            'type' => 'phone-activation',
            'expiry' => \Carbon\Carbon::now()->addDays(1)->timestamp,
        ]);

        $user = DB::table("users")
                ->where("id", auth('web')->user()->id)
                ->update([
                    "activate_phone_hash" => $hash
                ]);

        $message = "رقم الدخول الخاص بك هو :- " .$code ;
        $res = (new \App\Http\Controllers\Apis\User\SmsController())->send($message , auth('web')->user()->phone);
        return redirect("/user/activate-phone")->with("success", "تم ارسال رقم تفعيل جديد على رقم الهاتف");
    }

}
