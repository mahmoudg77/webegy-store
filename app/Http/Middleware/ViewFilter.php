<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class ViewFilter
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

        if($request->ajax()) return $response;

       // dd($response->headers->headerNames);


        if(Auth::user() != null && Auth::user()->hasRole('sys_admin')) return $response;

        $content=$response->content();

        preg_match_all("/<(.*?)>/u",$content,$tags);

        //dd($tags);
        //print_r($tags);
        $index=0;
        foreach( $tags[0] As $tag){
            preg_match_all("/(groups)=[\"']?((?:.(?![\"']?\s+(?:\S+)=|[>\"']))+.)[\"']?/u",$tag,$str_groups);

            //dd($tags);
//            if($index==121){
//                dd($str_groups);
//            }

            if(count($str_groups[2])>0){

                $sel_groups=explode(",",$str_groups[2][0]);

                //echo ($str_groups[2][0]);
                //echo ($tag);
                $allow = False;
                
                foreach($sel_groups as $g){
                    //$allow = in_array($g,array_getcolumn( $context->user->groups,'groupkey'));
                     if(Auth::user() == null) {
                         $allow=false;
                     }else{
                         $allow=Auth::user()->hasRole($g);
                     }
                   
                    
                    if($allow) break;
                }

                If($allow == False) {
                    //$newtag = str_replace($str_groups[0][0],"style='display:none;'",$tag) ;
                    $newtag = str_replace($str_groups[0][0],"deleted_element",$tag) ;
                    $content = str_replace($tag, $newtag,$content);
                }else{
                    $newtag = str_replace($str_groups[0][0],"",$tag) ;
                    $content = str_replace($tag, $newtag,$content);
                }

            }



        }

        $doc = new \DOMDocument();
        $doc->encoding = 'utf-8';
        libxml_use_internal_errors(true);
        $doc->loadHTML('<meta charset="UTF-8">'.$content);
        libxml_clear_errors();

        loop:
        foreach($doc->getElementsByTagName('*') as $div) {
            if($div->hasAttribute('deleted_element')){
                $div->parentNode->removeChild($div);
                goto loop;
            }
        }
        $content=$doc->saveHTML();
           //$content= mb_convert_encoding($content, 'UTF-16LE', 'UTF-8');

        //$content=str_replace(["\n","\r"],'',$content);
        $response->setContent($content);
        return $response;

    }
}
