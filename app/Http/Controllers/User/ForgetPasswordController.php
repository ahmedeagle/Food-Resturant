<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use Carbon\Carbon;
class ForgetPasswordController extends Controller
{
    public function get_forget_password(){

        $data['title'] = " - إستعادة كلمة المرور";
        $data['class'] = "page-template password change";

        return view("User.pages.auth.forget-password", $data);

    }

    public function post_forget_password(Request $request){
        App()->setLocale("ar");
        $rules = [

            "phone"                 => "required|numeric|exists:users,phone"
        ];
        $messages = [
            "required"          => trans("messages.required"),
            "phone.numeric"     => trans("messages.phone_numeric"),
            "phone.exists"      => trans("messages.phone_exists"),
        ];


        $this->validate($request, $rules , $messages);

        $phone = $request->input('phone');

        $user = DB::table("users")->where("phone", $phone)->first();

        $code = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);

        $message = (App()->getLocale() == "en")?
            "Your Activation Code is :- " . $code :
            $code . "رقم الدخول الخاص بك هو :- " ;

        $phone_hash = json_encode([
            'code'   => $code,
            'expiry' => Carbon::now()->addDays(1)->timestamp,
        ]);
        DB::table("users")
            ->where("phone", $phone)
            ->update([
                "phone_recovery_hash" => $phone_hash
            ]);

        (new \App\Http\Controllers\Apis\User\SmsController())->send($message , $phone);

        return redirect("/user/password-recovery/" . $user->token);
    }

    public function get_password_recovery($token){
        $user = DB::table("users")->where("token", $token)->first();
        if(!$user){
            return redirect("/");
        }

        $data['title']  = " - إستعادة كلمة المرور";
        $data['class']  = "page-template password validation";
        $data['token']  = $token;
        return view("User.pages.auth.password-recovery" , $data);
    }

    public function post_password_recovery(Request $request){
        App()->setLocale("ar");
        $rules = [

            "code"    =>  "required"
        ];
        $messages = [
            "required"  => trans("messages.required")
        ];


        $this->validate($request, $rules , $messages);

        $code  = $request->input('code');
        $token = $request->input('token');

        $user = DB::table("users")->where("token", $token)->first();
        if(!$user){
            return redirect("/");
        }

        $hash = json_decode($user->phone_recovery_hash);

        if($code != $hash->code){
            return redirect()->back()->with("error", trans("messages.register.active.notMatch"));
        }

        if(Carbon::now()->timestamp > $hash->expiry){
            return redirect()->back()->with("error", trans("messages.register.active.expire"));
        }

        return redirect("/user/change-password/" . $token);
    }

    public function get_change_password($token){

        // check if token exists
        $user = DB::table("users")->where("token", $token)->first();
        if(!$user){
            return redirect("/");
        }
        $data['title']  = " - إستعادة كلمة المرور";
        $data['class']  = "page-template password validation";
        $data['token']  = $token;
        return view("User.pages.auth.change-password" , $data);
    }

    public function post_change_password(Request $request){

        App()->setLocale("ar");
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

        $user = DB::table("users")
                    ->where("token", $token)
                    ->first();

        if(!$user){
            return redirect("/");
        }

        DB::table("users")
            ->where("token", $token)
            ->update([
                "password" => bcrypt($password),
                "phone_recovery_hash" => null
            ]);

        return redirect("/login")->with("user-login-success", trans("provider.password-changed"));
    }
}
