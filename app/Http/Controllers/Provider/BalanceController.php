<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BalanceController extends Controller
{
    public function __construct()
    {
       // App()->setLocale("ar");
    }

    public function get_balance_page(){
        $data['title'] = " - الرصيد";
        $data['class'] = "page-template food-menu all-kinds";

        // get provider balance
        $balance = DB::table("balances")
                    ->where("actor_type", "provider")
                    ->where("actor_id", auth("provider")->id())
                    ->first();
        $data['balance'] = ($balance) ? $balance->balance : 0;

        $data['logs'] = DB::table("balances_logs")
                                ->where("actor_type", "provider")
                                ->where("actor_id", auth("provider")->id())
                                ->select(
                                    "balances_logs.id as log_id",
                                    "action_id",
                                    "balance_action",
                                    "value",
                                    "value_type",
                                    DB::raw("DATE(created_at) AS created_at")
                                )
                                ->orderBy("id", "DESC")
                                ->paginate(10);


        if($data['logs']){
            foreach ($data['logs'] as $log){
                if($log->balance_action == "order"){
                    $order = DB::table("orders")
                                ->where("id", $log->action_id)
                                ->first();

                    $log->code = $order->order_code;
                }elseif($log->balance_action == "withdraw"){
                    $withdraw = DB::table("withdraws")
                                    ->where("id", $log->action_id)
                                    ->first();
                    $log->code = $withdraw->withdraw_code;
                }
            }
        }
        return view("Provider.pages.balance", $data);
    }
}
