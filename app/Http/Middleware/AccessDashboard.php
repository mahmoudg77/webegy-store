<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Auth;
use Func;
class AccessDashboard
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

        //if(Auth::user()->account_level_id <= 1)
        //{
            return $next($request);
        //}else{
           //return redirect('/');
        //}

    }
}
