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
        if (auth::guard('web')->check()) {
            // Block access if user is banned
            if (auth::guard('web')->user()->blocked == '1') {
                if ($request->ajax() || $request->wantsJson()) {
                    return response(trans('messages.user.blocked'), 401);
                } else {
                    auth::guard('web')->logout();
                    
                    $message = "This user has been banned.";
                                        
                    return redirect()->guest('login') -> with('message',$message);
                }
            }
        }else{

            return redirect()->guest('logind');
        }
        
        return $next($request);
    }
}
