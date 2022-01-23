<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

use App\Models\Post;

class HomeController extends Controller
{    
    public function index()
    {
        \App\Models\Visit::log("HomePage",0);
        
         if(request()->has('search')){
            $search=request()->get('search');
            $data =Post::where('is_published',1)
                ->listsTranslations('title','body')
                ->where(function($q)use($search){
                    $q->where('title', 'like',"%".$search."%")
                        ->orWhere('body', 'like',"%".$search."%");
                })
                ->orderBy('id','desc')->pluck('id');
            
            if(count($data)>0){
                $data=Post::whereIn('id',$data)->get();
            }
 

            $title="Search Result";
            $description="";

            return view('front.search', compact('data', 'title','description'));

        }
        //return view('welcome', compact('allSlider'));
        
        return view('front.welcome');
    }
}
