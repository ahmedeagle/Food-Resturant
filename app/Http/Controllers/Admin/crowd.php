<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use DB;
use Validator;
class crowd extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'حالات الازدحام';
        $data['crowds'] = DB::table("congestion_settings")
            ->join("images" , "images.id" , "congestion_settings.image_id")
            ->select(
                "congestion_settings.id",
                "congestion_settings.ar_name",
                "congestion_settings.en_name",
                "congestion_settings.created_at",
                "images.name AS image"
            )
            ->get();
        return view("admin_panel.crowd.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة حالة جديد';
        return view("admin_panel.crowd.add",$data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الحالة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الحالة بالعربية',
            'image.required'        => 'الصورة مطلوبة.',
            'image.mimes'           => 'نوع الصورة غير مدعوم.',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'image'        => 'required|mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);

        $image = DB::table("images")->insertGetId([
            'name' => $request->image->hashName()
        ]);

        $request->image->store('settings', 'public');

        DB::table("congestion_settings")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                "image_id"     => $image
            ]);
        return redirect("/admin/crowd")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['title'] = 'تعديل الحالة';
        $data['crowd'] = DB::table("congestion_settings")
            ->join("images" , "images.id" , "congestion_settings.image_id")
            ->where("congestion_settings.id" , $id)
            ->select(
                "congestion_settings.id",
                "congestion_settings.ar_name",
                "congestion_settings.en_name",
                "images.name AS filename"
            )
            ->first();
        if(!$data['crowd']){
            return redirect("/admin/crowd")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        return view("admin_panel.crowd.edit",$data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("congestion_settings")
            ->join("images" , "images.id" , "congestion_settings.image_id")
            ->where("congestion_settings.id" , $id)
            ->select(
                "congestion_settings.image_id",
                "images.name AS filename"
            )
            ->first();
        if(!$data){
            return redirect("/admin/crows")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الحالة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الحالة بالعربية',
            'image.mimes'           => 'نوع الصورة غير مدعوم.',
        ];
        $rules = [
            'en_name'      => 'required',
            'ar_name'      => 'required',
            'image'        => 'mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);
        if($request->hasFile("image")) {
            DB::table("images")
                ->where("id" , $data->image_id)
                ->update([
                    'name' => $request->image->hashName()
                ]);
            Storage::delete('public/settings/'.$data->filename);
            $request->image->store('settings', 'public');
        }
        DB::table("congestion_settings")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name")
            ]);
        return redirect("/admin/crowd")->with("success" , "تمت العملية بنجاح");
    }
    public function delete($id){
        $data = DB::table("congestion_settings")
            ->join("images" , "images.id" , "congestion_settings.image_id")
            ->where("congestion_settings.id" , $id)
            ->select("congestion_settings.image_id" , "images.name AS filename")
            ->first();
        if ($data) {
            DB::table("images")->where("id" , $data->image_id)->delete();
            Storage::delete('public/settings/'.$data->filename);
            DB::table("congestion_settings")->where("id" , $id)->delete();
            return redirect("/admin/crowd")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/crowd")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
