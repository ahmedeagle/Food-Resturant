<?php
namespace App\Http\Controllers\Admin;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Countries extends Controller {

	function __construct()
	{

	}
	public function index()
	{
        $data['title'] = 'الدول';
        $data['countries'] = DB::table("countries")->get();
		return view('admin_panel.countries.list', $data);
    }
    public function get_add(){
        $data['title'] = 'اضافة دولة جديدة';
	    return view("admin_panel.countries.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الدولة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الدولة بالعربية',
            'code.required'         => "برجاء ادخال رقم الدولة",
            'code.numeric'          => "رقم الدولة غير صحيح",
            'active.required'          => "برجاء اختيار حالة الدولة",
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'code'         => 'required|numeric',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("countries")
                    ->insert([
                        "ar_name"      => $request->input("ar_name"),
                        "en_name"      => $request->input("en_name"),
                        "country_code" => $request->input("code"),
                        "active"       => $request->input("active")
                    ]);
        return redirect("/admin/countries")->with("success" , "تمت الاضافة بنجاح");
        
	}
    public function get_edit($id){
		$data['country'] = DB::table("countries")->where("id" , $id)->select("*")->first();
		if(!$data['country']){
            return redirect("/admin/countries")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
		$data['title'] = 'تعديل الدولة';
        return view('admin_panel.countries.edit', $data);
	}
    public function post_edit($id , Request $request){
        $data = DB::table("countries")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/countries")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	    $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الدولة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الدولة بالعربية',
            'code.required'         => "برجاء ادخال رقم الدولة",
            'code.numeric'          => "رقم الدولة غير صحيح",
            'active.required'       => "برجاء اختيار حالة الدولة",
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'code'         => 'required|numeric',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("countries")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "country_code" => $request->input("code"),
                "active"       => $request->input("active")
            ]);
        return redirect("/admin/countries")->with("success" , "تمت عملية التعديل بنجاح");
	}
    public function delete($id){
	    $data = DB::table("countries")->where("id" , $id)->first();
		if ($data) {
            DB::table("countries")->where("id" , $id)->delete();
            return redirect("/admin/countries")->with("success", "تمت العملية بنجاح");
		}else{
            return redirect("/admin/countries")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	}
}
