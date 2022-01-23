<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;

class SingleController extends Controller
{
    //get posts by id
    public function getPostByID($id){
        $singlePost= post::where('id', '=', $id)->where('is_published',1)->first();
      /*  if(!$singlePost){
            return view('errors.404');
        }
        \App\Models\Visit::log(\App\Models\Post::class,$id);
        $lastPosts = Post::where('post_type_id', 2)->where('is_published',1)->orderBy('id', 'desc')->take(4)->get();
        
        $allcats = Category::where('parent_id', '<>',null)->get();
        
        return view('singleBlog', compact('singlePost', 'lastPosts', 'allcats'));
   **/
   //$singlePost= post::where('slug', $slug)->where('is_published',1)->first();
        if(!$singlePost){
            return view('errors.404');
        }
        \App\Models\Visit::log(\App\Models\Post::class,$singlePost->id);
        $lastPosts = Post::where('post_type_id', 2)->where('is_published',1)->orderBy('id', 'desc')->take(4)->get();

        $allcats = Category::where('parent_id', '<>',null)->get();
        
        //get related posts
        $related_posts = Post::where('id', '!=', $singlePost->id)->where('is_published',1)
            ->where('category_id', '=', $singlePost->category_id)->take(3)->get();
        
        if(view()->exists('front.single.' . strtolower($singlePost->slug))){
            return view('front.single.' . strtolower($singlePost->slug), compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }elseif(view()->exists('front.single.' . strtolower($singlePost->PostType->name))){
            return view('front.single.' . strtolower($singlePost->PostType->name), compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }
        else{
            return view('front.single.single', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }

    }
    
    
    //get posts by slug
    public function getPostBySlug($slug){

        $singlePost= cache()->remember('post_details_'.$slug,\Carbon\Carbon::now()->addMinutes(30),function()use($slug){
         return Post::where('slug', $slug)->first();});
        
        //dd($singlePost);
        if(!$singlePost){
            return view('errors.404');
        }
        \App\Models\Visit::log(\App\Models\Post::class,$singlePost->id);
        $lastPosts = [];//Post::where('post_type_id', 2)->where('is_published',1)->orderBy('id', 'desc')->take(4)->get();

        $allcats =[];// Category::where('parent_id', '<>',null)->get();
        
        //get related posts
        $related_posts =[];// Post::where('id', '!=', $singlePost->id)->where('is_published',1)
           // ->where('category_id', '=', $singlePost->category_id)->take(3)->get();
        
        if(view()->exists('front.single.' . strtolower($singlePost->slug))){
            return view('front.single.' . strtolower($singlePost->slug), compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }elseif(view()->exists('front.single.' . strtolower($singlePost->PostType->name))){
            return view('front.single.' . strtolower($singlePost->PostType->name), compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }
        else{
            return view('front.single.single', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
        }

//
//        if($singlePost->post_type_id==1 || $singlePost->post_type_id==3 ){
//            return view('page', compact('singlePost', 'lastPosts', 'allcats'));
//        }elseif($singlePost->post_type_id==2 || $singlePost->post_type_id==4){
//            return view('singleBlog', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
//        }else{
//            return view('singleBlog', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
//        }

    }
    //get posts by slug
    public function viewPostFileBySlug($slug){

        $singlePost= post::where('slug', $slug)->where('is_published',1)->first();
        if(!$singlePost){
            return view('errors.404');
        }
        
        
            return view('front.pdf', compact('singlePost'));
        

//
//        if($singlePost->post_type_id==1 || $singlePost->post_type_id==3 ){
//            return view('page', compact('singlePost', 'lastPosts', 'allcats'));
//        }elseif($singlePost->post_type_id==2 || $singlePost->post_type_id==4){
//            return view('singleBlog', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
//        }else{
//            return view('singleBlog', compact('singlePost', 'lastPosts', 'allcats', 'related_posts'));
//        }

    }
     //get posts by slug
    public function getConentBySlug($slug){

        $singlePost= post::where('slug', $slug)->where('is_published',1)->first();
        
        return $singlePost->body;
    }
     public function getInfoBySlug($slug){

        $singlePost= post::where('slug', $slug)->where('is_published',1)->first();
        
        return view('front.content.book-info',compact('singlePost'));
    }

}
