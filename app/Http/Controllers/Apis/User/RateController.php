<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use DateTime;
class RateController extends Controller
{
    public function add_rate(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "id"          => "required|exists:branches,id",
            "service"     => "required|in:0,1,2,3,4,5",
            "quality"     => "required|in:0,1,2,3,4,5",
            "cleanliness" => "required|in:0,1,2,3,4,5",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2,
            "in"         => 5
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.branch_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.rate.exists"),
            5  => trans("messages.error.in.rate"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        $service = $request->input("service");
        $quality = $request->input("quality");
        $cleanliness = $request->input("cleanliness");
        $user_id = (new GeneralController())->get_id($request);
        $user  = DB::table("rates")
                    ->where("user_id" , $user_id)
                    ->where("branch_id" , $id)
                    ->orderBy('rates.id', 'DESC')
                    ->select(
//                        DB::raw("DATE(created_at) AS created_at")
                    )
                    ->get();

        if(count($user) > 0){

            // check if the rate has been 1 day
            // check if there is order hasn't rate

            $orders = DB::table("orders")
                        ->where("user_id", $user_id)
                        ->where("branch_id", $id)
                        ->where("has_rate", "0")
                        ->select()
                        ->get();


            if(count($orders) > 0){
                $this->insert_order($service, $quality, $cleanliness, $user_id, $id);
                $this->update_orders_table($user_id, $id);
                return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
            }


            $to = \Carbon\Carbon::now()->format("Y-m-d H:i:s");

            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user[0]->created_at);

            $formatted_dt1 = \Carbon\Carbon::parse($to)->addHour(3);

            $formatted_dt2 = \Carbon\Carbon::parse($from);

            $diff_in_days = $formatted_dt1->diffInDays($formatted_dt2);


            if($diff_in_days == 0){

               DB::table("rates")
                        ->where("id", $user[0]->id)
                        ->update([
                            "service"       => $service,
                            "quality"       => $quality,
                            "Cleanliness"   => $cleanliness
                        ]);
                $this->update_orders_table($user_id, $id);
                return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);

            }else{
                return response()->json(['status' => false, 'errNum' => 4, 'msg' => $msg[4]]);
            }


        }else{

            $this->insert_order($service, $quality, $cleanliness, $user_id, $id);
            $this->update_orders_table($user_id,$id);
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);

        }

    }

    public function insert_order($service, $quality, $cleanliness, $user_id, $branch_id){

        DB::table("rates")
            ->insert([
                "user_id" => $user_id,
                "branch_id"     => $branch_id,
                "service"       => $service,
                "quality"       => $quality,
                "Cleanliness"   => $cleanliness
            ]);

    }

    public function update_orders_table($user_id,$branch_id){
        DB::table("orders")
            ->where("user_id", $user_id)
            ->where("branch_id", $branch_id)
            ->update([
                "has_rate" => "1"
            ]);
    }
}
