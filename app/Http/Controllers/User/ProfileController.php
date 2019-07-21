<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use phpDocumentor\Reflection\Types\Self_;
use Validator;
use Hash;
class ProfileController extends Controller
{
    public function get_profile_page(){


        $data['title'] = " - تعديل الملف الشخصي";
        $data['class'] = "front-page page-template";

        $data['countries'] = DB::table("countries")
                                ->get();

        foreach ($data['countries'] as $key => $value){
            if($value->active == "0" && $value->id != auth()->user()->country_id){
                unset($data['countries'][$key]);
            }
        }
        $data['cities'] = DB::table("cities")
                               ->where("country_id", auth()->user()->country_id)
                               ->get();

        foreach ($data['cities'] as $key => $value){
            if($value->active == "0" && $value->id != auth()->user()->city_id){
                unset($data['cities'][$key]);
            }
        }
        $data['img'] = Self::get_image();



        return view("User.pages.profile", $data);

    }

    public function post_profile_page(Request $request){

       // App()->setLocale("ar");

        $user = \App\User::find(auth()->id());

        $rules = [

            "user-name"               => "required",
            "user-country"            => "required|exists:countries,id",
            "user-city"               => "required|exists:cities,id",
            "user-gender"             => "required|in:1,2",
            "user-age"                => "required|numeric",


        ];


        if($user->phone != $request->input("user-phone")){
            $rules['user-phone'] = array('required','regex:/^(05|5)([0-9]{8})$/' ,'numeric','unique:users,phone');
            $phoneActive = "0";
        }else{
            $rules['user-phone'] =array('required','regex:/^(05|5)([0-9]{8})$/' ,'numeric');
            $phoneActive = "1";
        }

        if($user->email != $request->input("user-email")){
            $rules['user-email'] = "required|email|unique:users,email";
        }else{
            $rules['user-email'] = "required";
        }

        $messages = [
            "required"                          => trans("messages.required"),
            "user-phone.numeric"                => trans("messages.phone_numeric"),
            "user-age.numeric"                  => trans("messages.age_numeric"),
            "user-email.unique"                 => trans("messages.email_unique"),
            "user-email.email"                  => trans("messages.email"),
            "user-phone.unique"                 => trans("messages.phone_unique"),
            "user-password.min"                 => trans("messages.pasword_min"),
            "user-phone.regex"                  => trans("messages.phonenotcorrect")
        ];


        $this->validate($request, $rules , $messages);

        // insert into database
        $data = [
            "name"  => $request->input("user-name"),
            "email"  => $request->input("user-email"),
            "phone"  => $request->input("user-phone"),
            "age"  => $request->input("user-age"),
            "gender"      => ($request->input("user-gender") == 1) ? "male" : "female",
            "city_id"     => $request->input("user-city"),
            "country_id"  => $request->input("user-country"),
            "phoneactivated" => $phoneActive
        ];


        if($phoneActive == "0"){
            $code  = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(4);

            $data['activate_phone_hash'] = json_encode([
                        'code' => $code,
                        'type' => 'phone-activation',
                        'expiry' => \Carbon\Carbon::now()->addDays(1)->timestamp,
            ]);

            $message = "رقم الدخول الخاص بك هو :- " .$code ;
            //$res = (new \App\Http\Controllers\Apis\User\SmsController())->send($message , $request->input('phone'));
        }

        $id = DB::table("users")
                    ->where("id", auth()->id())
                    ->update($data);

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function change_password(Request $request){

        //App()->setLocale("ar");

        $rules = [
            "old-password"    => "required",
            "password"        => "required|min:6|confirmed",
        ];


        $messages = [
            "required"              => trans("messages.required"),
            "min"                   => trans("messages.pasword_min"),
            "password.confirmed"    => trans("messages.confirm_pasword_same")
        ];


        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect("/user/profile#change-password-form")->withErrors($validator)->withInput();
        }

        if(!Hash::check($request->input("old-password"), auth()->user()->password)){
            return redirect("/user/profile#change-password-form")->with("edit-password-error", "الرقم السرى غير صحيح");
        }
        // insert into database

        DB::table("users")
            ->where("id", auth()->id())
            ->update([
                'password'  => bcrypt($request->input("password"))
            ]);

        return redirect("/user/profile#change-password-form")->with("edit-password-success", trans("messages.success"));

    }

    public function edit_logo(Request $request){
        //App()->setLocale("ar");

        $rules = [
            "image"      => "required"
        ];
        $messages = [
            "required"   => 1,
        ];

        $msg = [
            1  => trans("messages.required"),
            2 => trans("messages.success")
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }


        if($request->hasFile("image")){

            $request->image->store('users', 'public');
            $img_id = DB::table("images")
                ->insertGetId([
                    "name" => $request->image->hashName()
                ]);
            DB::table("users")
                ->where("id", auth()->id())
                ->update([
                    "image_id" => $img_id
                ]);

        }

        // return redirect to food menu selection
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg"    => $msg[2],
        ]);
    }

    public static function get_image(){
        $img = DB::table("images")
                    ->where("id", auth()->user()->image_id)
                    ->select(
                        DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS image")
                    )->first();

        if($img){
            return $img->image;
        }else{
            return url("/storage/app/public/users/avatar.png");
        }
    }
}
