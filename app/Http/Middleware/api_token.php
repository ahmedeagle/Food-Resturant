<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class api_token
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
        $method = $request->method();
        $token = $request->input('access_token');
        if ($method != "GET") {
            $get = DB::table('users')
                ->where("token", $token)
                ->first();
            if (!$get || $get == NULL) {
                return response()->json(['status' => false, 'errNum' => 300, 'msg' =>'Unauthenticated']);
            }
            if ($get->blocked == '1') {
                return response()->json(['status' => false, 'errNum' => 301, 'msg' =>trans('messages.user.blocked')]);
            }

        }
        return $next($request);
    }
}
