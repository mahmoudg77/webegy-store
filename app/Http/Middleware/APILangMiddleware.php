<?php

namespace App\Http\Middleware;

use Closure;
 class APILangMiddleware
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
        $langs=$request->header('Accept-Language','');
        $lang=explode(',',$langs)[0];
        $lang=explode('-',$langs)[0];
        
        if(in_array($lang,config('translatable.locales'))){
            \App::setLocale($lang);
        }else{
            \App::setLocale("en"); 
        }
        return $next($request);
        
        // return $this->error('Bad Gateway', 403)  ;
    }
}
