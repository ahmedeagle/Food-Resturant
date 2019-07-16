<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
use Hash;
class Users extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'المستخدمين';
        $data['admins'] = DB::table("admins")->get();
		return view("admin_panel.admins.list" ,$data);

    }
    public function get_add(){
        $data['title'] = 'اضافة مدير جديدة';
        return view("admin_panel.admins.add" , $data);
    }
    public function post_add(Request $request){

        $messages = [
            'name.required'      => 'الاسم مطلوب',
            'email.required'     => 'البريد الالكترونى مطلوب',
            'email.email'        => 'البريد الالكترونى غير صحيح',
            'email.unique'       => 'البريد الالكترونى مستخدم من قبل',
            'phone.required'     => 'رقم الجوال مطلوب',
            'phone.numeric'      => 'رقم الجوال غير صحيح',
            'password.required'  => 'الرقم السرى مطلوب',
            'password.min'       => 'الرقم السرى يجب ان يكون ستة رموز على الاقل',
        ];
        $rules = [
            'name'      => 'required',
            'email'      => 'required|email|unique:admins,email',
            'phone'      => 'required|numeric',
            'password'      => 'required|min:6'
        ];
        $this->validate($request, $rules , $messages);

        $admin_id = DB::table("admins")
                        ->insertGetId([
                            "name"          => $request->input("name"),
                            "phone"         => $request->input("phone"),
                            "email"         => $request->input("email"),
                            "password"      => bcrypt($request->input('password'))
                        ]);

        $credit = ($request->input('credit')) ?  "1" : "0";
        $profile = ($request->input('profile')) ?  "1" : "0";
        $settings = ($request->input('settings')) ?  "1" : "0";
        $dashboard = ($request->input('dashboard')) ?  "1" : "0";
        $countries = ($request->input('countries')) ?  "1" : "0";
        $cities = ($request->input('cities')) ?  "1" : "0";
        $pages = ($request->input('pages')) ?  "1" : "0";
        $categories = ($request->input('categories')) ?  "1" : "0";
        $ticket_types = ($request->input('ticket_types')) ?  "1" : "0";
        $order_status = ($request->input('order_status')) ?  "1" : "0";
        $booking_status = ($request->input('booking_status')) ?  "1" : "0";
        $crowd = ($request->input('crowd')) ?  "1" : "0";
        $meals = ($request->input('meals')) ?  "1" : "0";
        $offers = ($request->input('offers')) ?  "1" : "0";
        $orders = ($request->input('orders')) ?  "1" : "0";
        $reservations = ($request->input('reservations')) ?  "1" : "0";
        $tickets = ($request->input('tickets')) ?  "1" : "0";
        $notifications = ($request->input('notifications')) ?  "1" : "0";
        $comments = ($request->input('comments')) ?  "1" : "0";
        $providers = ($request->input('providers')) ?  "1" : "0";
        $users = ($request->input('users')) ?  "1" : "0";
        $withdraws = ($request->input('withdraws')) ?  "1" : "0";
        $admins = ($request->input('admins')) ?  "1" : "0";

        // insert admin permissions
        DB::table("admin_privileges")
            ->insert([
                "admin_id" => $admin_id,
                "credit" => $credit,
                "profile" => $profile,
                "settings" => $settings,
                "dashboard" => $dashboard,
                "countries" => $countries,
                "cities" => $cities,
                "pages" => $pages,
                "categories" => $categories,
                "ticket_types" => $ticket_types,
                "order_status" => $order_status,
                "booking_status" => $booking_status,
                "crowd" => $crowd,
                "meals" => $meals,
                "offers" => $offers,
                "orders" => $orders,
                "reservations" => $reservations,
                "tickets" => $tickets,
                "notifications" => $notifications,
                "comments" => $comments,
                "providers" => $providers,
                "users" => $users,
                "withdraws" => $withdraws,
                "admins" => $admins
            ]);
        return redirect("/admin/admins")->with("success" , "تمت الاضافة بنجاح");

    }
    public function get_edit($id){
        $data['admin'] = DB::table("admins")->where("id" , $id)->select("*")->first();
        $data['permissions'] = DB::table("admin_privileges")->where("admin_id" , $id)->select("*")->first();
        if(!$data['admin']){
            return redirect("/admin/admins")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        
        
        $data['title'] = 'تعديل بيانات المدير';
        return view('admin_panel.admins.edit', $data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("admins")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/admins")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'name.required'      => 'الاسم مطلوب',
            'email.required'     => 'البريد الالكترونى مطلوب',
            'email.email'        => 'البريد الالكترونى غير صحيح',
            'email.unique'       => 'البريد الالكترونى مستخدم من قبل',
            'phone.required'     => 'رقم الجوال مطلوب',
            'phone.numeric'      => 'رقم الجوال غير صحيح',
            'passowrd.confirm'   => 'لابد من تاكيد كلمه المرور',
            'passowrd.min'   => 'كلمه المرور لابد ان تكون اكثر من 6 احرف ',
        ];
        $rules = [
            'name'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required|numeric',
            'password'   => 'nullable|confirmed|min:6'
        ];
        if($data->email != $request->input("email")){
            $rules['email'] = 'required|email|unique:admins,email';
        }
        $this->validate($request, $rules , $messages);
        
        
        DB::table("admins")
            ->where("id" , $id)
            ->update([
                "name"          => $request->input("name"),
                "phone"         => $request->input("phone"),
                "email"         => $request->input("email")
            ]);
            
         
         //update user password if present    
     if ($request->input('password') != null) {
             DB::table("admins")
            ->where("id" , $id) -> update([
                
                    'password'   => bcrypt($request->input('password')),
                ]);
                
         }
        
        

        if($id != 1){
            $credit = ($request->input('credit')) ?  "1" : "0";
            $profile = ($request->input('profile')) ?  "1" : "0";
            $settings = ($request->input('settings')) ?  "1" : "0";
            $dashboard = ($request->input('dashboard')) ?  "1" : "0";
            $countries = ($request->input('countries')) ?  "1" : "0";
            $cities = ($request->input('cities')) ?  "1" : "0";
            $pages = ($request->input('pages')) ?  "1" : "0";
            $categories = ($request->input('categories')) ?  "1" : "0";
            $ticket_types = ($request->input('ticket_types')) ?  "1" : "0";
            $order_status = ($request->input('order_status')) ?  "1" : "0";
            $booking_status = ($request->input('booking_status')) ?  "1" : "0";
            $crowd = ($request->input('crowd')) ?  "1" : "0";
            $meals = ($request->input('meals')) ?  "1" : "0";
            $offers = ($request->input('offers')) ?  "1" : "0";
            $orders = ($request->input('orders')) ?  "1" : "0";
            $reservations = ($request->input('reservations')) ?  "1" : "0";
            $tickets = ($request->input('tickets')) ?  "1" : "0";
            $notifications = ($request->input('notifications')) ?  "1" : "0";
            $comments = ($request->input('comments')) ?  "1" : "0";
            $providers = ($request->input('providers')) ?  "1" : "0";
            $users = ($request->input('users')) ?  "1" : "0";
            $withdraws = ($request->input('withdraws')) ?  "1" : "0";
            $admins = ($request->input('admins')) ?  "1" : "0";

            // insert admin permissions
            DB::table("admin_privileges")
                ->where("admin_id", $id)
                ->update([
                    "credit" => $credit,
                    "profile" => $profile,
                    "settings" => $settings,
                    "dashboard" => $dashboard,
                    "countries" => $countries,
                    "cities" => $cities,
                    "pages" => $pages,
                    "categories" => $categories,
                    "ticket_types" => $ticket_types,
                    "order_status" => $order_status,
                    "booking_status" => $booking_status,
                    "crowd" => $crowd,
                    "meals" => $meals,
                    "offers" => $offers,
                    "orders" => $orders,
                    "reservations" => $reservations,
                    "tickets" => $tickets,
                    "notifications" => $notifications,
                    "comments" => $comments,
                    "providers" => $providers,
                    "users" => $users,
                    "withdraws" => $withdraws,
                    "admins" => $admins
                ]);
        }
        return redirect("/admin/admins")->with("success" , "تمت الاضافة بنجاح");
    }
    public function delete($id){
        $data = DB::table("admins")->where("id" , $id)->first();
        if ($data) {
            DB::table("admins")->where("id" , $id)->delete();
            DB::table("admin_privileges")->where("admin_id" , $id)->delete();
            return redirect("/admin/admins")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/admins")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
