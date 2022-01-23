<?php

namespace App\Http\Middleware;

use Closure;
 class ApiDocsMiddleware
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
        $response= $next($request);
 
 

        $content=$response->content();

        $content=str_replace('src="','src="/docs/',$content);
        $content=str_replace('href="','href="/docs/',$content);

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' .$content);
        libxml_clear_errors();
 
    
        $content=$doc->saveHTML();
        //$content=str_replace(["\n","\r"],'',$content);
        $response->setContent($content);
        dd("sdasdasd");
        return $response;

    }
}
