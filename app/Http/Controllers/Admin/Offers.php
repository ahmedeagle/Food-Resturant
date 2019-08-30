<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Offer;
use DB;
use Validator;
class Offers extends Controller {

    function __construct()
    {

    }
    public function index($status)
    {
        $data['title'] = 'العروض';
        if($status == "active"){
            $con = ["1"];
        }elseif($status == "notactive"){
            $con = ["0"];
        }else{
            $con = ["1" , "0"];
        }
        $data['offers'] = DB::table("offers")
                                ->join("images" , "images.id" , "offers.image_id")
                                ->join("providers" , "providers.id" , "offers.provider_id")
                                ->whereIn("offers.approved" , $con)
                                ->select(
                                    "offers.id",
                                    "offers.ar_title",
                                    "offers.en_title",
                                    "offers.created_at",
                                    "offers.approved",
                                    "offers.order_level",
                                    "images.name AS image",
                                    "providers.ar_name"
                                )
                                ->orderBy("offers.order_level", "DESC")
                                ->get();
        return view("admin_panel.offers.list",$data);
    }
    public function get_add(){
        $data['title'] = 'اضافة عرض جديد';
        $data['providers'] = DB::table("providers")->where('accountactivated' , "1")->get();
        return view("admin_panel.offers.add",$data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_title.required'      => 'برجاء ادخال عنوان العرض بالانجليزية',
            'ar_title.required'      => 'برجاء ادخال عنوان بالعربية',
            'provider_id.required'   => 'برجاء اختيار المطعم',
            'image.required'         => 'الصورة مطلوبة.',
            'image.mimes'            => 'نوع الصورة غير مدعوم.',
            'approved.required'      => 'برجاء اختيار حالة العرض',
            'order_level.required'   => 'برجاء ادخال ترتيب الظهور',
            'order_level.numeric'    => 'برجاء ادخال قيمة صحيحة لترتيب الظهور',
        ];
        $rules = [
            'en_title'      => 'required',
            'ar_title'      => 'required',
            'provider_id'   => 'required',
            'approved'      => 'required',
            'image'         => 'required|mimes:jpg,jpeg,png',
            'order_level'   => 'required|numeric'
        ];
        $this->validate($request, $rules , $messages);

        $image = DB::table("images")->insertGetId([
            'name' => $request->image->hashName()
        ]);

        $request->image->store('offers', 'public');

        DB::table("offers")
            ->insert([
                "ar_title"       => $request->input("ar_title"),
                "en_title"       => $request->input("en_title"),
                "image_id"       => $image,
                "provider_id"    => $request->input("provider_id"),
                "approved"       => $request->input("approved"),
                "order_level"    => $request->input("order_level")
            ]);
        return redirect("/admin/offers/list/all")->with("success" , "تمت الاضافة بنجاح");
    }
    public function get_edit($id){
        $data['title'] = 'تعديل العرض';
        $data['offers'] = DB::table("offers")
                                ->join("images" , "images.id" , "offers.image_id")
                                ->join("providers" , "providers.id" , "offers.provider_id")
                                ->where("offers.id" , $id)
                                ->select(
                                    "offers.id",
                                    "offers.ar_title",
                                    "offers.en_title",
                                    "offers.provider_id",
                                    "providers.ar_name",
                                    "offers.approved",
                                    "offers.order_level",
                                    "images.name AS filename"
                                )
                                ->first();
        $data['providers'] = DB::table("providers")
                                ->where("accountactivated" , "1")
                                ->get();
        if(!$data['offers']){
            return redirect("/admin/offers")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        return view("admin_panel.offers.edit",$data);
    }
    public function post_edit($id , Request $request){
        $data = DB::table("offers")
                ->join("images" , "images.id" , "offers.image_id")
                ->where("offers.id" , $id)
                ->select(
                    "offers.image_id",
                    "images.name AS filename"
                )
                ->first();
        if(!$data){
            return redirect("/admin/offers")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_title.required'      => 'برجاء ادخال عنوان العرض بالانجليزية',
            'ar_title.required'      => 'برجاء ادخال عنوان بالعربية',
            'provider_id.required'   => 'برجاء اختيار المطعم',
            'image.mimes'            => 'نوع الصورة غير مدعوم.',
            'approved.required'      => 'برجاء اختيار حالة العرض',
            'order_level.required'   => 'برجاء ادخال ترتيب الظهور',
            'order_level.numeric'    => 'برجاء ادخال قيمة صحيحة لترتيب الظهور',
        ];
        $rules = [
            'en_title'      => 'required',
            'ar_title'      => 'required',
            'provider_id'   => 'required',
            'approved'      => 'required',
            'order_level'   => 'required|numeric',
            'image'         => 'mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);

        if($request->hasFile("image")) {
            DB::table("images")
                ->where("id" , $data->image_id)
                ->update([
                'name' => $request->image->hashName()
            ]);
            Storage::delete('public/offers/'.$data->filename);
            $request->image->store('offers', 'public');
        }
        DB::table("offers")
            ->where("id" , $id)
            ->update([
                "ar_title"      => $request->input("ar_title"),
                "en_title"      => $request->input("en_title"),
                "provider_id"   => $request->input("provider_id"),
                "order_level"   => $request->input("order_level"),
                "approved"      => $request->input("approved")
            ]);
        return redirect("/admin/offers/list/all")->with("success" , "تمت العملية بنجاح");
	}
    public function delete($id){
        $data = DB::table("offers")
                ->join("images" , "images.id" , "offers.image_id")
                ->where("offers.id" , $id)
                ->select("offers.image_id" , "images.name AS filename")
                ->first();
        if ($data) {
            DB::table("images")->where("id" , $data->image_id)->delete();
            Storage::delete('public/offers/'.$data->filename);
            DB::table("offers")->where("id" , $id)->delete();
            return redirect("/admin/offers")->with("success", "تمت العملية بنجاح");
        }else{
            return redirect("/admin/offers")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
	}

    public function reorder(){

             $data['title'] = 'إعاده ترتيب العروض ';

              $data['offers'] = DB::table("offers")
                               ->get();

             return view("admin_panel.offers.reorder",$data);

    }


    public function saveReorder(Request $request){

         $count = 0;
        $all_entries = $request::input('tree');

        if (count($all_entries)) {
            foreach ($all_entries as $key => $entry) {
                if ($entry['item_id'] != "" && $entry['item_id'] != null) {
                    $entry['parent_id'] = $this->parentId;
                    $item               = Offer::find($entry['item_id']);
                    $item->depth        = $entry['depth'];
                    $item->lft          = $entry['left'];
                    $item->rgt          = $entry['right'];
                    $item->save();

                    $count++;
                }
            }
        }
        else
        {
            return false;
        }

        return 'success for ' . $count . " items";

    }


}
