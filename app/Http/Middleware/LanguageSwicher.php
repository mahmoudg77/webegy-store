<?php

namespace App\Http\Middleware;
use Redirect;
use Closure;
use App;
use Setting;
class LanguageSwicher
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
      // Make sure current locale exists.
        $locale = $request->segment(1);
        // If provided Locale not in Available Locale Array
        //dd(app()->getLocale());
         
        
        //dd($locale);
        if ( !in_array($locale, config('translatable.locales'))) {

            $segments = $request->segments();
            
            $newsegments=[];
            $newsegments[]=Setting::getIfExists('site_lang',config('app.fallback_locale'));

            foreach($segments as $seg){
                $newsegments[]=$seg;
            }
            //$segments[0] = Setting::getIfExists('site_lang',config('app.fallback_locale'));//config('app.fallback_locale');
            
            return Redirect::to(implode('/', $newsegments));

            
            
        }


        // Else, Set Current Locale
        App::setLocale($locale);

        return $next($request);
    }
}
