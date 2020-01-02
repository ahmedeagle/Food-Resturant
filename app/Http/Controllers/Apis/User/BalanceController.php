<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class BalanceController extends Controller
{
    public function get_user_balance(Request $request){
        $balance = DB::table("balances")
                    ->where("actor_id" , (new GeneralController())->get_id($request))
                    ->where("actor_type",  "user")
                    ->select("balance")
                    ->first();
        if($balance){
            $data = $balance->balance;
        }else{
            $data = 0.00;
        }
        return response()->json(["status" => true , "errNum" => 0 , "msg" => trans("messages.success") , "balance" => $data]);
    }
    public function get_app_balanace_settings(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.branch_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.error"),
        ];
        $id = $request->input("id");
        if($id){
            $rules["id"] = "exists:branches,id";
        }
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $settings = DB::table("app_settings")
                    ->select("order_tax")
                    ->first();
        if($settings){
            $tax = $settings->order_tax;
        }else{
            $tax = "0.0";
        }
        if($id){
            $branch = DB::table("branches")
                        ->where("id" , $id)
                        ->select("delivery_price" ,"has_delivery")
                        ->first();

            $price = $branch->delivery_price;
        }else{
            $price = "0.0";
        }
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "delivery_price" => $price , "tax" => $tax]);
    }
}
