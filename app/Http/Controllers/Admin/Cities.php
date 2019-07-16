<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Cities extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'المدن';
        $data['cities'] = DB::table("cities")
                            ->join("countries" , "countries.id" , "cities.country_id")
                            ->select(
                                "cities.ar_name" ,
                                "cities.en_name" ,
                                "cities.id" ,
                                "cities.active" ,
                                "cities.created_at" ,
                                "countries.ar_name AS country_name")
                            ->get();
        return view('admin_panel.cities.list', $data);
    }
    public function get_add(){
        $data['title'] = 'اضافة مدينة جديدة';
        $data['countries'] = DB::table("countries")->get();
        return view("admin_panel.cities.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم المدينة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم المدينة بالعربية',
            'country_id.required'   => "برجاء اختيار الدولة",
            'country_id.exists'     => "الدولة غير صحيحة",
            'active.required'          => "برجاء اختيار حالة المدينة",
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'country_id'   => 'required|exists:countries,id',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("cities")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "country_id"   => $request->input("country_id"),
                "active"       => $request->input("active")
            ]);
        return redirect("/admin/cities")->with("success" , "تمت الاضافة بنجاح");

    }
    public function get_edit($id){
        $data['city'] = DB::table("cities")->where("id" , $id)->select("*")->first();
        if(!$data['city']){
            return redirect("/admin/cities")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title'] = 'تعديل المدينة';
        $data['countries'] = DB::table("countries")->get();
        return view('admin_panel.cities.edit', $data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("cities")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/cities")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم المدينة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم المدينة بالعربية',
            'country_id.required'   => "برجاء اختيار الدولة",
            'country_id.exists'     => "الدولة غير صحيحة",
            'active.required'       => "برجاء اختيار حالة المدينة",
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'country_id'   => 'required|exists:countries,id',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("cities")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "country_id"   => $request->input("country_id"),
                "active"       => $request->input("active")
            ]);
        return redirect("/admin/cities")->with("success" , "تمت عملية التعديل بنجاح");
    }
    public function delete($id){
        $data = DB::table("cities")->where("id" , $id)->first();
        if ($data) {
            DB::table("cities")->where("id" , $id)->delete();
            return redirect("/admin/cities")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/cities")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
