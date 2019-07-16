<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class FoodCategories extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'تصنيفات نوع الاكل';
        $data['categories'] = DB::table("mealsubcategories")->get();
        return view("admin_panel.categories.FoodCategories.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة نوع اكل جديد';
        return view("admin_panel.categories.FoodCategories.add" , $data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم التصنيف بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم التصنيف بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("mealsubcategories")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/foodCategories")->with("success" , "تمت الاضافة بنجاح");

    }
    public function get_edit($id){
        $data['categories'] = DB::table("mealsubcategories")->where("id" , $id)->select("*")->first();
        if(!$data['categories']){
            return redirect("/admin/foodCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title'] = 'تعديل التصنيف';
        return view('admin_panel.categories.FoodCategories.edit', $data);
    }
    public function post_edit($id, Request $request){
        $data = DB::table("mealsubcategories")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/foodCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم التصنيف بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم التصنيف بالعربية',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
        ];
        $this->validate($request, $rules , $messages);
        DB::table("mealsubcategories")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/foodCategories")->with("success" , "تمت العملية بنجاح");
    }
    public function delete($id){
        $data = DB::table("mealsubcategories")->where("id" , $id)->first();
        if ($data) {
            DB::table("mealsubcategories")->where("id" , $id)->delete();
            return redirect("/admin/foodCategories")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/foodCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
