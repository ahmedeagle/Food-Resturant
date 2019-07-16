<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class user_phone_active
{
    /*
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(auth()->user()->phoneactivated == "0" && auth()->user()->is_social == "0"){
            return redirect("/user/activate-phone");
        }
        return $next($request);
    }
}
