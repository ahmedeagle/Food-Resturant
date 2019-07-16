<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use DB;
use Validator;
class PageController extends Controller
{
    public function get_pages(Request $request){
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $pages = Page::select(
                    "id"
                    ,$name . "_title AS title")
                ->get();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => trans("messages.success"), "page" => $pages]);
    }
    public function get_usage_agreement_page(Request $request){
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $pages = Page::where('id' , 1)->select("id"
            ,$name . "_title AS title"
            ,$name . "_content AS content")
            ->first();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => trans("messages.success"), "page" => $pages]);
    }
    public function get_page(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "id" => "required|exists:pages,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.page.exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $id   = $request->input('id');
        $pages = Page::where('id' , $id)->select(
            "id"
            ,$name . "_title AS title"
            ,$name . "_content AS content")
            ->first();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => trans("messages.success"), "page" => $pages]);
    }
}
