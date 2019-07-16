<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
class CommentController extends Controller
{
    public function get_branch_comments(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "id" => "required|exists:branches,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.branch_id_exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        $comments = DB::table("comments")
                    ->join("users" , "users.id" , "comments.user_id")
                    ->leftjoin("images" , "users.image_id" , "images.id")
                    ->where("comments.branch_id" , $id)
                    ->where("comments.stopped", "0")
                    ->select(
                            "users.name AS username",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS image_url")
                            ,
                            "comments.comment",
                            "users.id"
                    )
                    ->paginate(10);
        foreach ($comments as $comment){
            if($comment->image_url == null){
                $comment->image_url = "";  
            }
            $rates = DB::table('rates')
                        ->where("user_id" , $comment->id)
                        ->where("branch_id" , $id)
                        ->select(
                            "service",
                            "quality",
                            "Cleanliness"
                        )
                        ->first();
            if($rates){
                $dataRate = ($rates->Cleanliness + $rates->service + $rates->quality) /3;
                $comment->average_rate = round($dataRate);
            }else{
                $comment->average_rate = 0;
            }
            unset($comment->id);
        }

        return response()->json(['status' => true , "errNum" => 0 , "msg" => $msg[3] , "comments" => $comments]);
    }
    public function add_comment(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "restaurant_id" => "required|exists:branches,id",
            "comment"       => "required",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg   = [
            1  => trans("messages.required"),
            2  => trans("messages.branch_id_exists"),
            3  => trans("messages.success"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        DB::table("comments")
                ->insert([
                    "user_id"   => (new GeneralController())->get_id($request),
                    "branch_id" => $request->input("restaurant_id"),
                    "comment"   => $request->input("comment")
                ]);
        return response()->json(['status' => true , "errNum" => 0 , "msg" => $msg[3]]);
    }
}
