<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class WithdrawController extends Controller
{
    public function __construct()
    {
        App()->setLocale("ar");
    }

    public function withdraw_balance(){
        $balance = DB::table("balances")
                        ->where("actor_type", "provider")
                        ->where("actor_id", auth("provider")->id())
                        ->first();

        $b = ($balance) ? $balance->balance : "0";
        if($b == "0"){
            return redirect()->back()->with("error", trans("provider.no_balance"));
        }

        $code = (new \App\Http\Controllers\Apis\User\GeneralController())->generate_random_number(10);
        $withrdaw = DB::table("withdraws")
                        ->insertGetId([
                            "provider_id" => auth("provider")->id(),
                            "withdrawn_amount" => $b,
                            "is_finished" => "0",
                            "withdraw_code" => $code
                        ]);
        DB::table("balances")
                ->where("actor_type", "provider")
                ->where("actor_id", auth("provider")->id())
                ->update([
                    "balance" => 0
                ]);

        DB::table("balances_logs")
                    ->insert([
                        "actor_id" => auth("provider")->id(),
                        "actor_type" => "provider",
                        "action_id" => $withrdaw,
                        "balance_befor" => $b,
                        "value"   => $b,
                        "balance_after" => 0,
                        "balance_action" => "withdraw",
                        "value_type" => "decrease"
                    ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }
}
