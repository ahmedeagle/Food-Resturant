<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;
 
class BannedUser
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            // Block access if user is banned
            if (Auth::guard($guard)->user()->blocked == '1') {
                if ($request->ajax() || $request->wantsJson()) {
                    return response(trans('messages.user.blocked'), 401);
                } else {
                    Auth::logout();
                    
                    $message = "This user has been banned.";
                    
                    flash()->error($message);
                    
                    return redirect()->guest('login');
                }
            }
        }else{

            return redirect()->guest('logind');
        }
        
        return $next($request);
    }
}
