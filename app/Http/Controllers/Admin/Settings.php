<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Settings extends Controller {

    function __construct()
    {

    }
	public function index(){
		$data['settings'] = DB::table("app_settings")
                            ->where("id" , 1)
                            ->first();
		$data['title'] = 'الاعدادات';
		return view("admin_panel.settings" , $data);
	}
    public function post_add(Request $request){
        $messages = [
            'app_en_name.required'      => 'برجاء ادخال اسم التطبيق بالانجليزية',
            'app_ar_name.required'      => 'برجاء ادخال اسم التطبيق بالعربية',
            'phone.required'            => 'برجاء ادخال رقم الجوال',
            'phone.numeric'             => 'رقم الجوال غير صحيح',
            'email.required'            => 'برجاء ادخال البريد الالكترونى',
            'email.numeric'             => 'البريد الالكترونى غير صحيح',
            'ar_address.required'       => 'برجاء ادخال العنوان بالعربية',
            'en_address.required'       => 'برجاء ادخال العنوان بالانجليزية',
            'tax.required'              => 'برجاء ادخال الضريبة',
            'android.required'          => 'برجاء ادخال العنوان',
            'ios.required'              => 'برجاء ادخال العنوان',
        ];
        $rules = [
            'app_en_name'      => 'required',
            'app_ar_name'      => 'required',
            'phone'            => 'required|numeric',
            'email'            => 'required|email',
            'ar_address'       => 'required',
            'en_address'       => 'required',
            'tax'              => 'required',
            'android'          => 'required',
            'ios'              => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("app_settings")
            ->where("id" , 1)
            ->update([
                "app_ar_name"      => $request->input("app_ar_name"),
                "app_en_name"      => $request->input("app_en_name"),
                "phone"            => $request->input("phone"),
                "email"            => $request->input("email"),
                "ar_address"       => $request->input("ar_address"),
                "en_address"       => $request->input("en_address"),
                "order_tax"        => $request->input("tax"),
                "android_app_url"  => $request->input("android"),
                "ios_app_url"      => $request->input("ios"),

            ]);
        return redirect("/admin/settings")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_app_balance(){
        $balance = DB::table("balances")
            ->where("actor_type" , "app")
            ->first();
        if(!$balance){
            return 0;
        }else{
            return $balance->balance;
        }
    }
}
