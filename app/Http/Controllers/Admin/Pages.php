<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Pages extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'الصفحات الفرعيه';
        $data['pages'] = DB::table("pages")->get();
        return view("admin_panel.pages.list" , $data);
    }
    public function get_add(){
        $data['title'] = 'اضافة صفحة جديدة';
        return view("admin_panel.pages.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_title.required'     => 'برجاء ادخال العنوان بالانجليزية',
            'ar_title.required'     => 'برجاء ادخال العنوان بالعربية',
            'ar_content.required'   => "برجاء ادخال المحتوى بالعربية",
            'en_content.required'   => "برجاء ادخال المحتوى بالانجليزية",
            'active.required'       => "برجاء ادخال حالة الصفحة",
        ];
        $rules = [
            'en_title'     => 'required',
            'ar_title'     => 'required',
            'ar_content'   => 'required',
            'en_content'   => 'required',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("pages")
            ->insert([
                "ar_title"      => $request->input("ar_title"),
                "en_title"      => $request->input("en_title"),
                "ar_content"    => $request->input("ar_content"),
                "en_content"    => $request->input("en_content"),
                "active"        => $request->input("active")
            ]);
        return redirect("/admin/pages")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['page'] = DB::table("pages")->where("id" , $id)->select("*")->first();
        if(!$data['page']){
            return redirect("/admin/pages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title']      = 'تعديل الصفحة';
        return view('admin_panel.pages.edit', $data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("pages")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/pages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_title.required'     => 'برجاء ادخال العنوان بالانجليزية',
            'ar_title.required'     => 'برجاء ادخال العنوان بالعربية',
            'ar_content.required'   => "برجاء ادخال المحتوى بالعربية",
            'en_content.required'   => "برجاء ادخال المحتوى بالانجليزية",
            'active.required'       => "برجاء ادخال حالة الصفحة",
        ];
        $rules = [
            'en_title'     => 'required',
            'ar_title'     => 'required',
            'ar_content'   => 'required',
            'en_content'   => 'required',
            'active'       => 'required'
        ];
        $this->validate($request, $rules , $messages);
        DB::table("pages")
            ->where("id" , $id)
            ->update([
                "ar_title"      => $request->input("ar_title"),
                "en_title"      => $request->input("en_title"),
                "ar_content"    => $request->input("ar_content"),
                "en_content"    => $request->input("en_content"),
                "active"        => $request->input("active")
            ]);
        return redirect("/admin/pages")->with("success" , "تمت العملية بنجاح");
	}
    public function delete($id){
        if($id == 1){
            return redirect("/admin/pages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data = DB::table("pages")->where("id" , $id)->first();
        if ($data) {
            DB::table("pages")->where("id" , $id)->delete();
            return redirect("/admin/pages")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/pages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	}
}
