<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class bookingstatus extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'حالات الحجز';
        $data['tickets_types'] = DB::table("reservation_statuses")->get();
        return view("admin_panel.bookingstatus.list" , $data);
    }
    public function get_add(){
        $data['title'] = 'اضافة حالة جديدة';
        return view("admin_panel.bookingstatus.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الحالة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الحالة بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("reservation_statuses")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/bookingstatus")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['type'] = DB::table("reservation_statuses")->where("id" , $id)->select("*")->first();
        if(!$data['type']){
            return redirect("/admin/bookingstatus")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title'] = 'تعديل حالة الحجز';
        return view('admin_panel.bookingstatus.edit', $data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("reservation_statuses")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/bookingstatus")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الحالة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الحالة بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("reservation_statuses")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/bookingstatus")->with("success" , "تمت الاضافة بنجاح");
    }
    public function delete($id){
        $data = DB::table("reservation_statuses")->where("id" , $id)->first();
        if ($data) {
            DB::table("reservation_statuses")->where("id" , $id)->delete();
            return redirect("/admin/bookingstatus")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/bookingstatus")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
