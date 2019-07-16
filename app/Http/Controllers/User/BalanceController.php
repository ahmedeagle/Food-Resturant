<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class BalanceController extends Controller
{
    public static function get_balance(){
        $balance = DB::table("balances")
                        ->where("actor_type", "user")
                        ->where("actor_id", auth()->id())
                        ->first();

        if($balance){
            return $balance->balance;
        }else{
            return 0;
        }
    }
}
