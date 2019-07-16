<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class MealCategories extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'تصنيفات قائمة الطعام';
       $data['categories'] = DB::table("mealcategories")
                                  ->join('providers','mealcategories.provider_id','providers.id') 
                                  ->
                                  ->select('mealcategories.*','providers.ar_name as provider_name')
                                  ->get();


        return view("admin_panel.categories.MealCategories.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة تصنيف قائمة طعام جديد';
        return view("admin_panel.categories.MealCategories.add" , $data);
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
        DB::table("mealcategories")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/mealCategories")->with("success" , "تمت الاضافة بنجاح");

    }
    public function get_edit($id){
        $data['categories'] = DB::table("mealcategories")->where("id" , $id)->select("*")->first();
        if(!$data['categories']){
            return redirect("/admin/mealCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $data['title'] = 'تعديل التصنيف';
        return view('admin_panel.categories.MealCategories.edit', $data);
    }
    public function post_edit($id, Request $request){
        $data = DB::table("mealcategories")->where("id" , $id)->first();
        if(!$data){
            return redirect("/admin/mealCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
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
        DB::table("mealcategories")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
            ]);
        return redirect("/admin/mealCategories")->with("success" , "تمت العملية بنجاح");
    }
    public function delete($id){
        $data = DB::table("mealcategories")->where("id" , $id)->first();
        if ($data) {
            DB::table("mealcategories")->where("id" , $id)->delete();
            return redirect("/admin/mealCategories")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/mealCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
