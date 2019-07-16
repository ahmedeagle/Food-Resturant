<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Validator;
use App\User;
use DB;
class ForgetPasswordController extends Controller
{
    public function forgetPassword(Request $request){
        (new BaseConroller())->setLang($request);
        $rules    = [
                "phone" => "required|numeric|exists:users,phone"
        ];
        $messages = [
                "required" => 1,
                "numeric"  => 2,
                "exists"   => 3
        ];
        $msg  = [
                1   => trans("messages.required"),
                2   => trans("messages.phone_numeric"),
                3   => trans("messages.phone_exists"),
                4   => trans("messages.send.activation.code"),
                5   => trans("messages.phone.not.active"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        //generate phone hash code
        $userData = DB::table("users")->where("phone" , $request->input("phone"))->select("id")->first();
        $user = User::find($userData->id);
        if(!$user->isActive()){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
        }
        $code = (new GeneralController())->generate_random_number(4);
        $message = (App()->getLocale() == "en")?
            "Your Activation Code is :- " . $code :
            $code . "رقم الدخول الخاص بك هو :- " ;

        $user->activate_phone_hash = json_encode([
            'code'   => $code,
            'expiry' => Carbon::now()->addDays(1)->timestamp,
        ]);
        $user->save();
        (new SmsController())->send($message , $user->phone);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[4] , 'code' => $code , "access_token" => $user->token]);
    }
    public function activateAccount(Request $request){
        (new BaseConroller())->setLang($request);
        $user = User::find((new GeneralController())->get_id($request));
        $user->phoneactivated = "1";
        $user->activate_phone_hash = null;
        $user->save();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => trans("messages.success")]);
    }

    public function updatePassword(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "password" => "required|min:6|confirmed"
        ];
        $messages   = [
            "required"              => 1,
            'password.min'          => 2,
            'password.confirmed'    => 3,
        ];
        $msg        = [
            1     => trans("messages.required"),
            2     => trans("messages.pasword_min"),
            3     => trans("messages.confirm_pasword_same"),
            4     => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $user = User::find((new GeneralController())->get_id($request));
        $user->password = bcrypt($request->input('password'));
        $user->activate_phone_hash = null;
        $user->save();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[4]]);
    }
}
