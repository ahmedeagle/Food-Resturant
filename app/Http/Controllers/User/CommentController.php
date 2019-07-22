<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
class CommentController extends Controller
{
    public function add_comment(Request $request){

     //   App()->setLocale("ar");
        $rules      = [
            "id"          => "required|exists:branches,id",
            "service"     => "required|in:0,1,2,3,4,5",
            "quality"     => "required|in:0,1,2,3,4,5",
            "cleanliness" => "required|in:0,1,2,3,4,5",
            "comment"     => "required"
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

        if($request->input("service") != "0" && $request->input("quality") != "0" && $request->input("cleanliness") != "0") {

            $user_id = auth('web')->id();
            $service = $request->input("service");
            $quality = $request->input("quality");
            $cleanliness = $request->input("cleanliness");

            $user = DB::table("rates")
                ->where("user_id", $user_id)
                ->where("branch_id", $id)
                ->orderBy('rates.id', 'DESC')
                ->select(
//                        DB::raw("DATE(created_at) AS created_at")
                )
                ->get();

            if (count($user) > 0) {

                // check if the rate has been 1 day
                // check if there is order hasn't rate

                $orders = DB::table("orders")
                    ->where("user_id", $user_id)
                    ->where("branch_id", $id)
                    ->where("has_rate", "0")
                    ->select()
                    ->get();


                if (count($orders) > 0) {
                    (new \App\Http\Controllers\Apis\User\RateController())->insert_order($service, $quality, $cleanliness, $user_id, $id);
                    (new \App\Http\Controllers\Apis\User\RateController())->update_orders_table($user_id, $id);
                }


                $to = \Carbon\Carbon::now()->format("Y-m-d H:i:s");

                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user[0]->created_at);

                $formatted_dt1 = \Carbon\Carbon::parse($to)->addHour(3);

                $formatted_dt2 = \Carbon\Carbon::parse($from);

                $diff_in_days = $formatted_dt1->diffInDays($formatted_dt2);


                if ($diff_in_days == 0) {

                    DB::table("rates")
                        ->where("id", $user[0]->id)
                        ->update([
                            "service" => $service,
                            "quality" => $quality,
                            "Cleanliness" => $cleanliness
                        ]);
                    (new \App\Http\Controllers\Apis\User\RateController())->update_orders_table($user_id, $id);


                } else {
                    return response()->json(['status' => false, 'errNum' => 4, 'msg' => $msg[4]]);
                }


            } else {

                (new \App\Http\Controllers\Apis\User\RateController())->insert_order($service, $quality, $cleanliness, $user_id, $id);
                (new \App\Http\Controllers\Apis\User\RateController())->update_orders_table($user_id, $id);


            }

        }

        DB::table("comments")
                ->insert([
                    "comment" => $request->input("comment"),
                    "branch_id" => $id,
                    "user_id" => auth('web')->id()
                ]);


        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }
}
