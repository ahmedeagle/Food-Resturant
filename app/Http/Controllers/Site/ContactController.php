<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
class ContactController extends Controller
{
    public function contact_us(Request $request){

        //App()->setLocale("ar");

        $rules = [

            "name"         => "required",
            "email"        => "required|email",
            "phone"        => "required|numeric",
            "subject"      => "required",
            "message"      => "required"

        ];
        $messages = [
            "required"          => trans("messages.required"),
            "phone.numeric"     => trans("site.phone-number-numeric"),
            "email.email"       => trans("messages.email")
        ];

        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect("/#contact")->withErrors($validator)->withInput();
        }


        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $subject = $request->input('subject');
        $message = $request->input('message');

        DB::table("contact_us")
                    ->insert([
                       "name"    => $name,
                       "phone"   => $phone,
                       "email"   => $email,
                       "subject" => $subject,
                       "message" => $message
                    ]);

        return redirect("/#contact")->with("insert-success", trans("site.contact-success"));
    }
}
