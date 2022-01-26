<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdminLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if(Auth::guard('admin')->check()){
        } else
        {
         Auth::logout();
            return redirect('auth/login')->with('msg','Please login here..');   
        }
        return $next($request);
    }
}
