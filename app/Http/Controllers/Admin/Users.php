<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Validator;
use Hash;
use Gate;
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

        $data['roles'] = Role::all();
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
            'role_id.required'   => 'لابد من اختيار صلاحيه ',
            'role_id.exists'     => 'الصلاحيه المختاره عير موجوده '
        ];
        
        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:admins,email',
            'phone'         => 'required|numeric',
            'password'      => 'required|min:6',
            'role_id'       => 'required|exists:roles,id',
        ];
        $this->validate($request, $rules , $messages);

        $admin_id = DB::table("admins")
                        ->insertGetId([
                            "name"          => $request->input("name"),
                            "phone"         => $request->input("phone"),
                            "email"         => $request->input("email"),
                            "role_id"       => $request->input("role_id"),
                            "password"      => bcrypt($request->input('password'))
                        ]);
       
        return redirect("/admin/admins")->with("success" , "تمت الاضافة بنجاح");

    }
    public function get_edit($id){
        $data['admin'] = DB::table("admins")
                              ->where("id" , $id)
                              ->select("*")
                               
                              ->first();

        $data['roles']=Role::all();


         if(!$data['admin']){
            return redirect("/admin/admins")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        
        
        $data['title'] = 'تعديل بيانات المدير';
        return view('admin_panel.admins.edit', $data);
    }

    public function post_edit($id , Request $request){

     
      $input  =[];
      $rules  =[];
      $url    = "";

        if(Gate::check('admins')){   //check permision can edit admins or not 
              $rules['role_id']         = 'required|exists:roles,id';
              $inputs["role_id"]        = $request->input("role_id");
              $url                      = "admin/admins" ;

          }  else{

             $url                      = "admin/admins/edit/".$id ;
          }
 

        $data = DB::table("admins")->where("id" , $id)->first();
        if(!$data){
            return redirect($url)->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
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
            'role_id.required'   => 'لابد من اختيار صلاحيه ',
            'role_id.exists'     => 'الصلاحيه المختاره عير موجوده '
        ];
        $rules = [
            'name'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required|numeric',
            'password'   => 'nullable|confirmed|min:6',
           

        ];
        if($data->email != $request->input("email")){
            $rules['email'] = 'required|email|unique:admins,email';
        }


        $inputs=[
               
                "name"          => $request->input("name"),
                "phone"         => $request->input("phone"),
                "email"         => $request->input("email")  
               ];

         

        $this->validate($request, $rules , $messages);
        
        
        DB::table("admins")
            ->where("id" , $id)
            ->update($inputs);
            
         
         //update user password if present    
     if ($request->input('password') != null) {
             DB::table("admins")
            ->where("id" , $id) -> update([
                
                    'password'   => bcrypt($request->input('password')),
                ]);
                
         }
        
      
      
        return redirect($url)->with("success" , "تمت الاضافة بنجاح");

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
