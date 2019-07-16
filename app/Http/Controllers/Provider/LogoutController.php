<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LogoutController extends Controller
{
    public function logout(){
        if(auth("provider")->check()){
           
        $id = auth('provider') -> id();
        
        DB::table('providers') -> whereId($id) -> update(['webtokenSubscribe' => null]);
         
            auth("provider")->logout();
        }elseif(auth("branch")->check()){
            
             $id = auth('branch') -> id();
        
        DB::table('branches') -> whereId($id) -> update(['webtokenSubscribe' => null]);
            auth("branch")->logout();
        }

        return redirect("/");
    }
}
