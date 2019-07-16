<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use DB;
use Validator;
class SubCategories extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'التصنيفات الفرعية';
        $data['categories'] = DB::table("subcategories")
                                ->join("images" , "images.id" , "subcategories.image_id")
                                ->select(
                                    "subcategories.id",
                                    "subcategories.ar_name",
                                    "subcategories.en_name",
                                    "subcategories.created_at",
                                    "subcategories.order_level",
                                    "images.name AS image"
                                )
                                ->orderBy("order_level", "DESC")
                                ->get();
        return view("admin_panel.categories.SubCategories.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة تصنيف فرعى جديد';
        return view("admin_panel.categories.SubCategories.add",$data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم التصنيف بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم التصنيف بالعربية',
            'image.required'        => 'الصورة مطلوبة.',
            "order_level.required"  => 'برجاء ادخال ترتيب التصنيف عند العرض',
            "order_level.numeric"   => 'برجاء ادخال رقم صحيح',
            'image.mimes'           => 'نوع الصورة غير مدعوم.',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'order_level'  => 'required|numeric',
            'image'        => 'required|mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);

        $image = DB::table("images")->insertGetId([
            'name' => $request->image->hashName()
        ]);

        $request->image->store('subcategories', 'public');

        DB::table("subcategories")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "order_level"  => $request->input("order_level"),
                "image_id"     => $image
            ]);
        return redirect("/admin/subCategories")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['title'] = 'تعديل التصنيف';
        $data['categories'] = DB::table("subcategories")
                                ->join("images" , "images.id" , "subcategories.image_id")
                                ->where("subcategories.id" , $id)
                                ->select(
                                    "subcategories.id",
                                    "subcategories.ar_name",
                                    "subcategories.en_name",
                                    "subcategories.order_level",
                                    "images.name AS filename"
                                )
                                ->first();
        if(!$data['categories']){
            return redirect("/admin/subCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        return view("admin_panel.categories.SubCategories.edit",$data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("subcategories")
                ->join("images" , "images.id" , "subcategories.image_id")
                ->where("subcategories.id" , $id)
                ->select(
                    "subcategories.image_id",
                    "images.name AS filename"
                )
                ->first();
        if(!$data){
            return redirect("/admin/subCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم التصنيف بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم التصنيف بالعربية',
            'image.mimes'           => 'نوع الصورة غير مدعوم.',
            "order_level.required"  => 'برجاء ادخال ترتيب التصنيف عند العرض',
            "order_level.numeric"   => 'برجاء ادخال رقم صحيح',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'order_level'  => 'required|numeric',
            'image'        => 'mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);
        if($request->hasFile("image")) {
            DB::table("images")
                ->where("id" , $data->image_id)
                ->update([
                'name' => $request->image->hashName()
            ]);
            Storage::delete('public/subcategories/'.$data->filename);
            $request->image->store('subcategories', 'public');
        }
        DB::table("subcategories")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "order_level"  => $request->input("order_level")
            ]);
        return redirect("/admin/subCategories")->with("success" , "تمت العملية بنجاح");
	}
    public function delete($id){
        $data = DB::table("subcategories")
                ->join("images" , "images.id" , "subcategories.image_id")
                ->where("subcategories.id" , $id)
                ->select("subcategories.image_id" , "images.name AS filename")
                ->first();
        if ($data) {
            DB::table("images")->where("id" , $data->image_id)->delete();
            Storage::delete('public/subcategories/'.$data->filename);
            DB::table("subcategories")->where("id" , $id)->delete();
            return redirect("/admin/subCategories")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/subCategories")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	}
}
