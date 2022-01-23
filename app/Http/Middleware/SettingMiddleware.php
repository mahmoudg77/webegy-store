<?php

namespace App\Http\Middleware;

use Closure;
class SettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$key)
    {
       
       if(!$key){
           return response(view('errors.406'),406);
        }
        
       //dd(\App\Models\Setting::getIfExists('allow_register',"0"));
        if(\App\Models\Setting::getIfExists($key,"0")=="1"){
            return $next($request);
        }
            return response(view('errors.406'),406);
    }
}
