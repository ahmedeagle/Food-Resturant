<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use DB;
use Validator;
class Advantages extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'مميزات المطاعم  ';
        $data['options'] = DB::table("options")
             ->join("images" , "images.id" , "options.image_id")
            ->select("options.id","options.ar_name","options.en_name",
                DB::raw("CONCAT('". url('/') ."','/storage/app/public/options/', images.name) AS option_image_url"))
            ->orderBy('id','DESC')
            ->get();

        return view("admin_panel.advantages.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة ميزة جديده';
        return view("admin_panel.advantages.add",$data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الميزة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الميزة بالعربية',
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

        $request->image->store('options', 'public');

        DB::table("options")
            ->insert([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
                 "image_id"     => $image
            ]);
        return redirect("/admin/advantages")->with("success" , "تمت الاضافة بنجاح");
    }

    public function get_edit($id){
        $data['title'] = 'تعديل التصنيف';
        $data['option'] = DB::table("options")
            ->join("images" , "images.id" , "options.image_id")
            ->select("options.id","options.ar_name","options.en_name",
                DB::raw("CONCAT('". url('/') ."','/storage/app/public/options/', images.name) AS option_image_url"))
            ->orderBy('id','DESC')
            ->where('options.id',$id)
            ->first();
        if(!$data['option']){
            return redirect("/admin/advantages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        return view("admin_panel.advantages.edit",$data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("options")
            ->join("images" , "images.id" , "options.image_id")
            ->select("options.id","options.ar_name","options.en_name","options.image_id",
                DB::raw("CONCAT('". url('/') ."','/storage/app/public/options/', images.name) AS option_image_url"))
            ->orderBy('id','DESC')
            ->where('options.id',$id)
            ->first();
        if(!$data){
            return redirect("/admin/advantages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_name.required'      => 'برجاء ادخال اسم الميزة بالانجليزية',
            'ar_name.required'      => 'برجاء ادخال اسم الميزة بالعربية',
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
             $request->image->store('options', 'public');
        }
        DB::table("options")
            ->where("id" , $id)
            ->update([
                "ar_name"      => $request->input("ar_name"),
                "en_name"      => $request->input("en_name"),
             ]);
        return redirect("/admin/advantages")->with("success" , "تمت العملية بنجاح");
	}

    public function delete($id){
        $data = DB::table("options")
                ->join("images" , "images.id" , "options.image_id")
                ->where("options.id" , $id)
                ->select("options.image_id" , "images.name AS filename")
                ->first();
        if ($data) {
            DB::table("images")->where("id" , $data->image_id)->delete();
            Storage::delete('public/options/'.$data->filename);
            DB::table('branch_options')-> where('option_id',$id) -> delete();
            DB::table("options")->where("id" , $id)->delete();
            return redirect("/admin/advantages")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/advantages")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	}
}
