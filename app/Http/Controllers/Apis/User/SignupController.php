<?php

namespace App\Http\Controllers\Apis\User;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Carbon\Carbon;
use DB;
class SignupController extends Controller
{
    public function __construct()
    {
    }

    public function SignUp(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $rules    = $this->getRegisterRules();
        $messages = $this->setRegistetErrorMessages();
        $msg = $this->setRegisterMessages();
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $input = $request->except('password_confirmation' ,'lang');
        $input['password'] = bcrypt($input['password']);
        
        $code = (new GeneralController())->generate_random_number(4);
        $input['token'] = (new GeneralController)->getRandomString(128);
        $input['activate_phone_hash'] = json_encode([
            'code'   => $code,
            'expiry' => Carbon::now()->addDays(1)->timestamp,
        ]);
        
       
        $message = (App()->getLocale() == "en")?
                    "Your Activation Code is :- " . $code :
                     "رقم الدخول الخاص بك هو :- " .$code ;
        $user = User::create($input);
        
         DB::table('balances') -> insert([
                'actor_id'   => $user -> id,
                'actor_type' => 'user'
            ]);
        
        

           // send  sctivation code to user phone number with expiration 
        $res = (new SmsController())->send($message , $user->phone);

        $userData = ( new BaseConroller())->get_user_data($user);
        
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[12],'activation_code' => $code , 'user' => $userData]);
    }

    public function social_login(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $rules    = [
                "social_token"     => "required",
                "username"         => "required",
                "social_name"      => "required",
                'age'              => 'numeric',
                'date_of_birth'    => 'date_format:Y-m-d',
                'gender'           => 'in:male,female',
                'device_reg_id'    => 'required'
        ];
        $messages = [
            "required"              => 1,
            'email'                 => 2,
            'email.unique'          => 3,
            'age.numeric'           => 4,
            'gender.in'             => 5,
            'phone.numeric'         => 8,
            'phone.unique'          => 9
        ];
        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.email"),
            3  => trans("messages.email_unique"),
            4  => trans("messages.age_numeric"),
            5  => trans("messages.gender_in"),
            8  => trans("messages.phone_numeric"),
            9  => trans("messages.phone_unique"),
            12 => trans("messages.register.check.phone"),
            13 => trans("messages.error"),
            14 => trans("messages.success")
        ];

        $userData = DB::table("users")
                        ->where("social_token" , $request->input("social_token"))
                        ->select("*")
                        ->first();
                        
        if($userData){
            $user = User::find($userData->id);
            $userData = ( new BaseConroller())->get_user_data($user);
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[14] , 'user' => $userData]);
        }else{
            $rules['phone'] = "numeric|unique:users,phone";
            $rules['email'] = "email|unique:users,email";
            $validator  = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
                $error = $validator->errors()->first();
                return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
            }
            $data = [];
            $data['social_name']      = $request->input('social_name');
            $data['social_token']     = $request->input('social_token');
            $data['is_social']        = "1";
            $data['name']             = $request->input('username');
            
            $data['email']            = ($request->input('email'))? $request->input('email') : "";
            //$data['age']              = ($request->input('age'))? $request->input('age') : "";
            $data['gender']           = ($request->input('gender'))? $request->input('gender') : "";
            $data['phone']            = ($request->input('phone'))? $request->input('phone') : "";


            $data['date_of_birth']    = ($request->input('date_of_birth')) ? $request->input('date_of_birth') : null;
            $data['country_id'] = 0;
            $data['city_id']    = 0;
            
            $data['device_reg_id'] = $request->input("device_reg_id");
            
            $data['password'] = "";
            
            $data['phoneactivated'] = ($request->input('phone')) ? "1" : "0";
            

            $data['token'] = (new GeneralController)->getRandomString(128);
    
            $user = User::create($data);
    
            $userData = ( new BaseConroller())->get_user_data($user);
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[14] , 'user' => $userData]);
        }
    }

    protected function getRegisterRules()
    {
        return [
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'phone'            =>  array('required','numeric','unique:users,phone','regex:/^(05|5)([0-9]{8})$/'),
            //'age'              => 'required|numeric',
            'date_of_birth'    => 'required|date_format:Y-m-d',
            'gender'           => 'required|in:male,female',
            'country_id'       => 'required|exists:countries,id',
            'city_id'          => 'required||exists:cities,id',
            'device_reg_id'    => 'required',
            'password'         => 'required|min:6|confirmed',
        ];
    }
    protected function setRegistetErrorMessages()
    {
        return [
            'required'              => 1,
            'email'                 => 2,
            'email.unique'          => 3,
            'age.numeric'           => 4,
            'gender.in'             => 5,
            'country_id.exists'     => 6,
            'city_id.exists'        => 7,
            'phone.numeric'         => 8,
            'phone.unique'          => 9,
            'password.min'          => 10,
            'password.confirmed'    => 11,
            'success'               => 12,
            "error"                 => 13,
            "date_of_birth.date_format" => 14,
            "regex"                 => 15
        ];
    }
    protected function setRegisterMessages()
    {
        return [
            1  => trans("messages.required"),
            2  => trans("messages.email"),
            3  => trans("messages.email_unique"),
            4  => trans("messages.age_numeric"),
            5  => trans("messages.gender_in"),
            6  => trans("messages.country_id_exists"),
            7  => trans("messages.city_id_exists"),
            8  => trans("messages.phone_numeric"),
            9  => trans("messages.phone_unique"),
            10 => trans("messages.pasword_min"),
            11 => trans("messages.confirm_pasword_same"),
            12 => trans("messages.register.check.phone"),
            13 => trans("messages.error"),
            14 => trans("messages.date_of_birth_format"),
            15 => trans("messages.invalid_phone_format"),
        ];
    }
}
