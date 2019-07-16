<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
class RegisterController extends Controller
{
    public function register(Request $request){

        App()->setLocale("ar");
        $rules = [

            "user-name"               => "required",
            "user-country"            => "required|exists:countries,id",
            "user-city"               => "required|exists:cities,id",
            "user-gender"             => "required|in:1,2",
            "user-age"                => 'required|date_format:Y-m-d',
            "user-phone"              => array('required','regex:/^(05|5)([0-9]{8})$/','numeric','unique:users,phone'),
            "user-email"              => "required|email|unique:users,email",
            "user-password"           => "required|min:6",
            "usage"                   => "required"
        ];

        $messages = [
            "required"                          => trans("messages.required"),
            "user-phone.numeric"                => trans("messages.phone_numeric"),
            "user-age.date_format"              => trans("messages.reservation.date.format.error"),
            "user-email.unique"                 => trans("messages.email_unique"),
            "user-email.email"                  => trans("messages.email"),
            "user-phone.unique"                 => trans("messages.phone_unique"),
            "user-password.min"                 => trans("messages.pasword_min"),
            "user-password.min"                 => trans("messages.pasword_min"),
            "user-phone.regex"                  => trans("messages.phonenotcorrect"),
            

        ];


        $this->validate($request, $rules , $messages);


        $code  = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);
        $token = (new \App\Http\Controllers\Apis\User\GeneralController)->getRandomString(128);
        

        $hash = json_encode([
                    'code' => $code,
                    'type' => 'phone-activation',
                    'expiry' => \Carbon\Carbon::now()->addDays(1)->timestamp,
        ]);

        // insert
        $user = DB::table("users")
                    ->insertGetId([
                        "name"  => $request->input("user-name"),
                        "email"  => $request->input("user-email"),
                        "phone"  => $request->input("user-phone"),
                        "password"  => bcrypt($request->input("user-password")),
                        "date_of_birth"  => $request->input("user-age"),
                        "gender"      => ($request->input("user-gender") == 1) ? "male" : "female",
                        "city_id"     => $request->input("user-city"),
                        "country_id"  => $request->input("user-country"),
                        "token"        => $token,
                        "activate_phone_hash" => $hash
                    ]);

        $message = "رقم الدخول الخاص بك هو :- " .$code ;
        $res = (new \App\Http\Controllers\Apis\User\SmsController())->send($message , $request->input("user-phone"));
        
        
        //create balance account 
        
        
           DB::table('balances') -> insert([
                         
                         'balance'     => 0,
                         'actor_id'    => $user,
                         'actor_type'  => 'user',
                         
                   
                 ]);
                 
                 
        $loginuser = \App\User::find($user);
        auth()->login($loginuser);
        
        return redirect("/user/activate-phone");

    }
}
