<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use DB;
use App\User;
class SocialLoginController extends Controller
{
    public function redirectToFacebookProvider(){

        return Socialite::driver('facebook')->redirect();

    }

    public function handleFacebookProviderCallback(){

        App()->setLocale("ar");

        $user = Socialite::driver('facebook')->user();

        $login = $this->login_social_user($user,"facebook");
        if($login){
            return redirect("/user/dashboard");
        }else{
            return redirect("/login")->with("user-error", trans("messages.email_unique"));
        }

    }

    public function redirectToTwitterProvider(){

        return Socialite::driver('twitter')->redirect();

    }

    public function handleTwitterProviderCallback(){

        App()->setLocale("ar");

        $user = Socialite::driver('twitter')->user();

        $login = $this->login_social_user($user,"twitter");

        if($login){

            return redirect("/user/dashboard");

        }else{

            return redirect("/login")->with("user-error", trans("messages.email_unique"));

        }
    }

    public function login_social_user($user, $provider){

        $id = $user->getId();
        $nickName = $user->getNickname();
        $name = $user->getName();
        $email = $user->getEmail();
        $image = $user->getAvatar();

        $userData = DB::table("users")
            ->where("social_token" , $id)
            ->where("social_name", $provider)
            ->select("*")
            ->first();

        if($userData){

            $user = \App\User::find($userData->id);
            auth()->login($user);
            return true;

        }else{

            $checkEmail = DB::table("users")
                ->where("email", $email)
                ->first();

            if($checkEmail){
                return false;
            }


            $data = [];
            $data['social_name']      = $provider;
            $data['social_token']     = $id;
            $data['is_social']        = "1";
            $data['name']             = $name;

            $data['email']            = ($email)? $email : "";
            $data['age']              = "";
            $data['gender']           = "";
            $data['phone']            = "";

            $data['country_id'] = 0;
            $data['city_id']    = 0;



            $data['password'] = "";

            $data['phoneactivated'] = "0";


            $data['token'] = (new \App\Http\Controllers\Apis\User\GeneralController)->getRandomString(128);

            $user = User::create($data);

            auth()->login($user);
            return true;
        }

    }
}
