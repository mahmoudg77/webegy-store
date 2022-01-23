<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;

class TVController extends Controller
{

    
    //get posts by slug
    public function ajaxGetCategory(){
         $id=request()->input("id");
         $sort=request()->input("sort");
        $videos= post::where('category_id',$id)->where('is_published',1);
        if($sort==1)$videos=$videos->orderBy('id','des');
         if($sort==2)$videos=$videos->orderBy('id');
        $data=$videos->paginate(6);
        if($data)foreach ($data as $i)$i->videoId=explode('/',$i->external_url)[count(explode('/',$i->external_url))-1];
       return response()->json($data);
        }
/*function getCategory($slug){
    $cat=Category::where('slug',$slug)->fitst();
    $ids=$cat->Chields()->pluck('id');
    $post=Post::where('is_published',1)->whereIn('category_id',$ids)->first();
    return redirect(route('getPostBySlug',$post->slug));
}
*/
}
