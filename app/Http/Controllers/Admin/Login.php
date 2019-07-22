<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Auth;
use Validator;
use Hash;
class Login extends Controller {

    function __construct()
    {
        //$this->middleware("guest:admin")->except(['logout']);

    }
    public function get_login(){
        if(Auth::guard("admin")->user()){
            return redirect("/admin/dashboard");
        }
        return view("admin_panel.login");
    }
    public function post_login(Request $request)
    {
        $messages = [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'ادخل عنوان بريد إلكتروني صالح.',
            'password.required'  => 'كلمة المرور مطلوبة.'
        ];

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        $admin = DB::table('admins')->where('email', $request->email)->first();

        if ( !$admin){
            //session()->flash('fail', 'لم نجد أي سجلات لهذا البريد الالكتروني.');
            //return back()->withInput();
            return redirect()->back()->with("error" , 'لم نجد أي سجلات لهذا البريد الالكتروني.');
        }

        if ( !auth()->guard('admin')->attempt(['email' =>  $request->input("email"), 'password' =>  $request->input("password")]) ) {
                 session()->flash('fail', 'كلمة المرور خاطئة.');
                 return back()->withInput();
            return redirect()->back()->with("error" , 'كلمة المرور خاطئة');
       }


       return redirect('admin/dashboard');
       
    }
    public function logout(){
        Auth::guard("admin")->logout();
        return redirect("/admin/login");
    }
}
