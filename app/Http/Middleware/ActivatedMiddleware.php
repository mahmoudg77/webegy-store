<?php

namespace App\Http\Middleware;
use App\Extra\APIHelper;

use Closure;
use App\User;
use Auth;
class ActivatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    use APIHelper;
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){

            $token=$request->header('X-TOKEN','');
            if($token!='') {
                $user=User::where('api_token',$token)->first();
                if($user){
                    Auth::login($user);
                    return $next($request);
                }
            }
        }
        if(Auth::user()->active) return $next($request);


        return $this->error('Not Activat Account', 201);

    }
}
