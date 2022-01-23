<?php

namespace App\Http\Middleware;

use Closure;
use App\Extra\APIHelper;
class APIKeyMiddleware
{
    use  APIHelper;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $appkeys=[    'QLV7pbzXue9ms6vTbjjcphe65pzURXJ8qKNd6NVqwQBrSgYVyQxZ7QDh3JYNJ3Ne',
                        
                        ];
    public function handle($request, Closure $next)
    {
        if(in_array($request->header('X-APP-KEY',''),$this->appkeys)){
            return $next($request);
        }
        return $this->error('Bad Gateway', 403)  ;

    }
}
