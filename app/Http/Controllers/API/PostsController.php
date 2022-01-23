<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\PostType;
use App\Models\PostProperty;
use App\Models\PostTypeProperty;

use App\Models\Post;
use App\Extra\APIHelper;
use Auth;
use DB;
/**
* @group Posts Managment
*/
class PostsController extends Controller
{
    use APIHelper;
    /**
    * Get Posts by type ID
    * @urlParam id required PostType ID Example:8
    */
    public function getPostsByType($id) {
        //$type=request()->get('type');
        $posts = Post::where('post_type_id', $id)->where('is_published', 1)->orderBy('id', 'asc')->get();
        return $this->success($posts);
    }
    /**
    * Get Posts by type Name
    * @urlParam type required PostType Name Example:8
    */
    public function getPostsByTypeName($type) {
        $limit = request()->get('limit', 20);
        $order = request()->get('order', 'id,desc');
        $offset = request()->get('offset', 0);

        if (!$posttype = PostType::where('name', $type)->first()) return null;
        $posts = Post::with('Category')->where('post_type_id', $posttype->id)->where('is_published', 1)->limit($limit)->offset($offset)->orderBy(explode(',', $order)[0], explode(',', $order)[1])->get();
        return $this->success($posts);
    }
    /**
    * Get Post by post slug
    * @urlParam slug required Post Slug Example:about-us
    */
    public function getPostBySlug($slug) {
        //$type=request()->get('type');
        $post = Post::with('Category')->where('slug', $slug)->where('is_published', 1)->first();
        return $this->success($post);
    }
    /**
    * Get Post by post ID
    * @urlParam id required Post Slug Example:10
    */
    public function getPostByID($id) {
        //$type=request()->get('type');
        $post = Post::with('Category')->find($id);
        return $this->success($post);
    }
    /**
    * Get Posts by category slug
    * @urlParam slug required Category Slug Example:gellary
    */
    public function getPostByCatSlug($slug) {
        //$type=request()->get('type');
        $limit = request()->get('limit', 10);
        $order = request()->get('order', 'pub_date,desc');
        $offset = request()->get('offset', 0);
        
        if (!$cat = cache()->remember('category_details_'.$slug,\Carbon\Carbon::now()->addMinutes(30),function()use($slug) {
            return Category::with('Chields')->where('slug', $slug)->first();
            })
        ) 
            return $this->error("Category Not Found !", 404);



            /////////
            $catids = $cat->Chields()->pluck('id')->toArray();

            foreach ($cat->Chields as $sub) {
                $catids = array_merge($catids, $sub->Chields()->pluck('id')->toArray());

            }
            $catids[] = $cat->id;
            $data = Post::whereIn('category_id', $catids)->where('is_published', 1);
          
            if ($related = request()->get('related')) {
                //$relatesIDs=PostProperty::query()
                $relatesIDs = [];
                if ($postType = PostType::where('name', request()->get('type'))->first()) {

                    foreach ($related as $key => $value) {
                        $property = PostTypeProperty::where('post_type_id', $postType->id)->where('name', $key)->first();
                        if ($property) {
                            //dd($property->id);

                            $query = PostProperty::where('property_id', $property->id)->where('related_post_id', $value);
                            //if(array_count_values($relatesIDs)>0)
                            //->whereIn('post_id',$relatesIDs)
                            $relatesIDs = $query->pluck('post_id')->toArray();
                            //dd($relatesIDs);
                        
                             $data = $data->whereIn('posts.id', $relatesIDs);
           
                        }
                    }
                }
            }
            if ($filter = request()->get('filter')) {
                foreach ($filter as $key => $value) {
                    if (!empty($value) && !is_null($value) && $value != "")
                        if ($key == 'created_at')
                        $data = $data->where($key, '>', $value.'-01-01')->where($key, '<=', $value.'-12-31');
                    else
                        $data = $data->where($key, $value);

                }
            }
            if ($q = request()->get('q')) {
                $data = $data->whereHas('Translations',function($query)use($q){$query->where('body', 'like', '%'.$q.'%');});
            }
            /*if ($sort = request()->get('sort')) {
                $data = $data->orderBy($sort, request()->get('sort_dir'));
            }
            $data = $data->paginate(6);
            if (!$data) {
                return response(view('errors.404'), 404);
            }*/
            /////////
            $total=$data->count();
            $length=($total - $offset)>= $limit?$limit*1:($total - $offset);
            $posts = $data->limit($limit)->offset($offset)->orderBy(explode(',', $order)[0], explode(',', $order)[1]);
            $posts=cache()->remember('category_'.$slug.'_'.$limit.'_'.$offset.'_'.$total.'_posts',\Carbon\Carbon::now()->addMinutes(30),function()use($posts) {
            return $posts->get();
            });
            return $this->success($posts,"",$length,$total);
        

        
    }
    /**
    * Get Posts by category id
    * @urlParam id required Category ID Example:5
    */
    public function getPostByCatID($id) {
        //$type=request()->get('type');
        $limit = request()->get('limit', 10);
        $order = request()->get('order', 'pub_date,desc');
        $offset = request()->get('offset', 0);

        if ($cat = Category::find($id)) {
            $posts = $cat->Posts()->where('is_published', 1)->limit($limit)->offset($offset)->orderBy(explode(',', $order)[0], explode(',', $order)[1])->get();
            return $this->success($posts);
        }

        return $this->error("Category Not Found !", 404);


    }
    public function  topRatesByCatSlug($slug){
         if ($cat = Category::where('slug', $slug)->first()) {

            /////////
            /*$catids = $cat->Chields()->pluck('id')->toArray();

            foreach ($cat->Chields as $sub) {
                $catids = array_merge($catids, $sub->Chields()->pluck('id')->toArray());

            }
            $catids[] = $cat->id;
            */
            $data = Post::CategoryIs($cat->id);//whereIn('category_id', $catids)->where('is_published', 1);
           $data=$data->whereHas('Rates')->orderBy(DB::raw("(select sum(rate)/count(rate) from post_rates where post_id=posts.id )"),"desc")->limit(10)->get();
        
         
           return $this->success($data,"",count($data),count($data));
        }
        return $this->error("Category not found!",404);
        
    }

}

?>