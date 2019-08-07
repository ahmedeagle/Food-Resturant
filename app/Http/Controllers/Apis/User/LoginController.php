<?php

namespace App\Http\Controllers\Apis\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\User\GeneralController;
use Validator;
use Auth;
use DB;
use guard;
class LoginController extends Controller
{
    public function login(Request $request){

        (new BaseConroller())->setLang($request);
        $rules      = $this->getLoginRules();
        $messages   = $this->setLoginErrorMessages();
        $msg        = $this->setLoginMessages();
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $credential = $request->input('credentials');
        $password   = $request->input('password');

        if(filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            $data = "email";
            $user = DB::table("users")
                        ->where("email" , $credential)
                        ->first();
            if($user == null){
                return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
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
                return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
            }
        }else{
            return response()->json(['status' => false, 'errNum' => 2, 'msg' => $msg[2]]);
        }
        
         if (auth()->guard('web')->attempt([$data => $credential, 'password' => $password]) || auth()->guard('web')->attempt([$data => '0'.$credential, 'password' => $password])) {
            // login user
            $user = User::where($data , $credential)
                          ->orwhere($data ,'0'.$credential)->first();
            
            User::where($data , $credential)
                   ->orwhere($data ,'0'.$credential)
                
                  -> update([
                    "device_reg_id" => $request->input("device_reg_id") 
                ]);
            $userData = ( new BaseConroller())->get_user_data($user);
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[4] , 'user' => $userData]);
        }else{
            return response()->json(['status' => false, 'errNum' => 3, 'msg' => $msg[3]]);
        }
    }

    protected function getLoginRules()
    {
        return [
            'credentials'   => 'required',
            'password'      => 'required',
            "device_reg_id" => 'required'
        ];
    }
    protected function setLoginErrorMessages()
    {
        return [
            'required'              => 1,
        ];
    }
    protected function setLoginMessages()
    {
        return [
            1  => trans("messages.required"),
            2  => trans("messages.invalid.email.phone"),
            3  => trans("messages.invalid.credential"),
            4  => trans("messages.success"),
            5  => trans("messages.no.record.found"),
        ];
    }
}
