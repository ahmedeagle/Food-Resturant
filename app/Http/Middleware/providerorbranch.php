<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class providerorbranch
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
        
        
        if(auth('provider') -> check() ){
            
             if(auth('provider')->user()->phoneactivated == "0" ){
            return redirect("/restaurant/activate-phone");
             }
          }elseif(auth('branch') -> check()){
            
              if(auth('branch')->user()->phoneactivated == "0" ){
            return redirect("/restaurant/activate-phone");
          }
        }else{
            
            return redirect("/login");
        }
        
        
         
        return $next($request);
    
}


}
