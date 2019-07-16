<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Tickets_types extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'انواع التذاكر';
        $data['tickets_types'] = DB::table("ticket_types")->get();
        return view("admin_panel.tickets_types.list" , $data);
    }
    public function get_add(){
        $data['title'] = 'اضافة نوع جديدة';
        return view("admin_panel.tickets_types.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم النوع بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم النوع بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("ticket_types")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/ticketTypes")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['type'] = DB::table("ticket_types")->where("id" , $id)->select("*")->first();
        if(!$data['type']){
            return redirect("/admin/ticketTypes")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title'] = 'تعديل نوع التذكرة';
        return view('admin_panel.tickets_types.edit', $data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("ticket_types")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/ticketTypes")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم النوع بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم النوع بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("ticket_types")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/ticketTypes")->with("success" , "تمت الاضافة بنجاح");
	}
    public function delete($id){
        $data = DB::table("ticket_types")->where("id" , $id)->first();
        if ($data) {
            DB::table("ticket_types")->where("id" , $id)->delete();
            return redirect("/admin/ticketTypes")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/ticketTypes")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
