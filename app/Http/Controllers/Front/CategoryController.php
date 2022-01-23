<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;
use App\Models\PostProperty;
use App\Models\PostTypeProperty;

class CategoryController extends Controller
{
    
    public function getPostsByCatSlug($slug){
        
        $category = \App\Models\Category::where('slug', $slug)->first();

        if(!$category){
            return response(view('errors.404'),404);
        }
        $catids=$category->Chields()->pluck('id')->toArray();
        
       foreach ($category->Chields as $cat){
           $catids=array_merge($catids,$cat->Chields()->pluck('id')->toArray());
           
       }
       
        $catids[]=$category->id;
        $data =  Post::whereIn('category_id',$catids)->where('is_published',1);//->where('pub_date', '<=',date("Y-m-d H:i",strtotime('+2 hours')));
        
        if($related=request()->get('related')){
            //$relatesIDs=PostProperty::query()
            /*$relatesIDs=[];
            foreach ($related as $key=>$value){
                $property=PostTypeProperty::where('post_type_id',request()->get('type'))->where('name',$key)->first();
                if($property){
                    
                $query=PostProperty::where('property_id',$property->id)->where('related_post_id',$value);
                if(array_count_values($relatesIDs)>0)
                $query->whereIn('post_id',$relatesIDs);
                $relatesIDs=$query->pluck('post_id')->toArray();
                //dd($relatesIDs);
                }
                $data=$data->related(request()->get('type'),$key,$value);
            }
            
            $data=$data->whereIn('posts.id',$relatesIDs);
        */
          $relatesIDs = [];
                if ($postType = PostType::where('name', request()->get('type'))->first()) {

                    foreach ($related as $key => $value) {
                        $property = PostTypeProperty::where('post_type_id', $postType->id)->where('name', $key)->first();
                        if ($property) {

                            $query = PostProperty::where('property_id', $property->id)->where('related_post_id', $value);
                            //if(array_count_values($relatesIDs)>0)
                            //->whereIn('post_id',$relatesIDs)
                            $relatesIDs = $query->pluck('post_id')->toArray();
                            //dd($relatesIDs);
                        }
                    }
                }
                $data = $data->whereIn('posts.id', $relatesIDs);
           
        }
        
        if($filter=request()->get('filter')){
            foreach ($filter as $key=>$value){
             if(!empty($value) && !is_null($value) && $value!="") 
                 if($key=='created_at')
                   $data=$data->where($key,'>',$value.'-01-01')->where($key,'<=',$value.'-12-31');
                else
                $data=$data->where($key,$value);
               
            }
        }
        if($q=request()->get('q')){
            $data=$data->listsTranslations('body')->where('body','like','%'.$q.'%');
        }
        if($sort=request()->get('sort')){
            $data=$data->orderBy($sort,request()->get('sort_dir'));
        }
        $data=$data->orderBy('pub_date','desc')->paginate(12);
        if(!$data){
            return response(view('errors.404'),404);
        }

        $title=$category->title;
        $description=$category->description;
        $image=$category->mainImage();

        \App\Models\Visit::log(\App\Models\Category::class,$category->id);

        if(view()->exists('front.category.' . strtolower($slug))){
            return view('front.category.' . strtolower($slug), compact('data', 'title','description','slug','category'));
        }elseif($category->parent_id>0 && view()->exists('front.category.catparent_' . strtolower($category->Parent->slug)) ){
            return view('front.category.catparent_' . strtolower($category->Parent->slug), compact('data', 'title', 'image','description','slug','category'));
        }elseif($category->Parent &&  $category->Parent->parent_id>0 && view()->exists('front.category.catsub_' . strtolower($category->Parent->Parent->slug)) ){
            return view('front.category.catsub_' . strtolower($category->Parent->Parent->slug), compact('data', 'title', 'image','description','slug','category'));
        }elseif(view()->exists('front.category.' . $slug)){
            return view('front.category.' . $slug, compact('data', 'title','description','slug','category'));
        }else{
            return view('front.category.category', compact('data', 'title','description','slug'));
        }
        
    }

    public function getConentBySlug($slug){

        $data = \App\Models\Category::where('slug', $slug)->first();
        if(!$data){
            return response(view('errors.404'),404);
        }
        $title=$data->title;
        $description=$data->description;
        $body=$data->body;
        
        return view('front.content.body', compact('data', 'title','description','body'));
    }

    public function getPostsByTag($tag){

        $tagobj=\App\Models\Tag::where('name',$tag)->first();
        if(!$tagobj){
            return response(view('errors.404'),404);
        }
        $data =$tagobj->Posts()->where('is_published',1)->orderBy('id','desc')->paginate(6);
        
        \App\Models\Visit::log(\App\Models\Tag::class,$tagobj->id);

        $title=$tag;
        $description=$tag;
        $slug=$tag;
        if(view()->exists('front.category.' . strtolower($tag))){
            return view('front.category.' . strtolower($tag), compact('data', 'title','description','slug'));
        }elseif(view()->exists('front.category.' . $tag)){
            return view('front.category.' . $tag, compact('data', 'title','description','slug'));
        }else{
            return view('front.category.category', compact('data', 'title','description','slug'));
        }

    }
}
