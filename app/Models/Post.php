<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Collective\Html\Eloquent\FormAccessible;
use \Astrotomic\Translatable\Translatable;
use App\Models\Category;
use App\Models\PostType;
use App\Extra\ImageCache;
use App\Models\PostRate;
use App\Scopes\PubDateScope;
use App\Models\PostProperty;
use App\Models\PostTypeProperty;
use Func;
class Post extends Model
{
    //
    use Translatable;
    use ImageCache;
    protected $fillable = ['pub_date',
        'post_type_id',
        'category_id',
        'is_published',
        'created_by',
        'slug',
        'icon',
        'description',
        'slider_option',
        'external_url'];
    public $translatedAttributes = ['title',
        'body',
        'description',
        'meta_title',
        'meta_description'];
    protected $appends = [
        'image',
        'file',
        'related',
        'rate',
        'cat',
        'images',
        'writer',
        'pub_date_str'
    ];
    protected $hidden = ['updated_at',
        'created_by',
        'updated_by',
        'Rates'];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new PubDateScope);
    }
    public function scopeRelated($query, $type, $key, $value) {
        $relatesIDs = [];
        $property = PostTypeProperty::where('post_type_id', $type)->where('name', $key)->first();
        if ($property) {
            $relatesIDs = PostProperty::where('property_id', $property->id)->where('related_post_id', $value)->pluck('post_id')->toArray();
        }
        return $query->whereIn('posts.id', $relatesIDs);
    }
    public function scopeCategoryIs($query,$category_id){
        $category = \App\Models\Category::find($category_id);

        if(!$category){
            return $query->where('category_id',$category_id);
            }
        $catids=$category->Chields()->pluck('id')->toArray();
        
       foreach ($category->Chields as $cat){
           $catids=array_merge($catids,$cat->Chields()->pluck('id')->toArray());
           
       }
       
        $catids[]=$category->id;
        return $query->whereIn('category_id',$catids);//->where('pub_date', '<=',date("Y-m-d H:i",strtotime('+2 hours')));
        
    }
    public function scopeIsPublished($query){
        return $query->where('is_published',1);//->where('pub_date', '<=',date("Y-m-d H:i",strtotime('+2 hours')));
        
    }

    public function PostType() {
        return $this->belongsTo("App\Models\PostType", "post_type_id");
    }
    public function Category() {
        return $this->belongsTo("App\Models\Category", "category_id")->withTrashed();
       //dd(coun$cat->get());
        /*if(count($cat->get())>0)
        return $cat;
        else
        return new \App\Models\Category();
    */
    }
    public function Tags() {
        return $this->belongsToMany("App\Models\Tag", "posts_tags_relationship");
    }
    public function strTags() {
        return implode(",", $this->Tags()->pluck('name')->toArray());
    }
    public function Files() {
        return $this->hasMany("App\Models\File", "model_id", "id")->where('model_name', self::class);
    }
    public function MediaFiles() {
        return $this->hasMany("App\Models\MediaFile", "model_id", "id")->where('model_name', self::class);
    }
    public function Properties() {
        $cat = $this->category_id;
        return $this->hasMany("App\Models\PostTypeProperty", "post_type_id", "post_type_id")
        ->where(
            function($t)use($cat) {
                return $t->where('category_id', $cat)->orWhere('category_id', 0)->orWhereNull('category_id');
            }
        );
    }
    public function RelatedPost($name) {
        $prop = $this->properties();
        if (!$prop) return new Post();

        $prop = $prop->where('name', $name)->first();

        if (!$prop) return new Post();

        $data = $prop->data($this->id);

        if (!$data) {
            if ($prop->is_single == 0) return [new Post()];
            if ($prop->is_single == 1) return new Post();
            if ($prop->is_single == 2) return "";
        }
        if ($prop->is_single == 2) {
            return $data->related_post_id;
        }

        if ($prop->related_post_type_id == null) {

            return $data->related_post_id;
        }
        return $data->RelatedPost;
    }
    public function RelatedPosts($name) {
        $prop = $this->properties();

        if (!$prop) return [];

        $prop = $prop->where('name', $name)->first();

        if (!$prop) return [];

        $data = $prop->data($this->id);
        if (!$data) return [];

        $ids = [];
        foreach ($data as $d)$ids[] = $d->related_post_id;

        $data = self::whereIn('id', $ids)->get();

        return $data;
    }
    public function Creator() {
        return $this->belongsTo("App\User", "created_by", "id")->withTrashed();
    }
    public function mainImage($size = 'original', $mode = 'scale') {
        return $this->ImageUrl($size, $mode);
    }

    public function mainImages($size = 'original', $mode = 'scale') {
        //dd($this->ImageUrls($size ,$mode ));
        return $this->ImageUrls($size, $mode);
    }
    public function images($size = 'original', $mode = 'scale', $slug = 'main') {
        //dd($this->ImageUrls($size ,$mode ));
        return $this->ImageUrls($size, $mode, $slug);
    }
    public function mainFile() {
        $file = $this->Files()->where('model_attribute', 'main')->orderBy('id', 'desc')->first();
        if (!$file) {
            return null;
        }

        return $file->name;
    }
    public function Visits() {
        return $this->hasMany(\App\Models\Visit::class, "model_id", "id")->where('model_name', self::class);
    }
    function link() {
    
    if($this->slug=="")
          return route('getPostByID', $this->id);
  
      else 
          return route('getPostBySlug', $this->slug);
  
   
    }

    function getImageAttribute() {
       // if (strpos(request()->url(), '/api/')===FALSE) 
        //    return null;

        $arr = [];
        //if (strpos(request()->url(), '/api/') > 0) {

        if ($postType = PostType::find($this->post_type_id)) {
            $arr['sm'] = $this->mainImage($postType->img_size_sm, 'crope');
            $arr['md'] = $this->mainImage($postType->img_size_md, 'crope');
            $arr['lg'] = $this->mainImage($postType->img_size_lg, 'crope');
        } else {
            $arr['sm'] = $this->mainImage('300x200', 'crope');
            $arr['md'] = $this->mainImage('600x500', 'crope');
            $arr['lg'] = $this->mainImage('800x600', 'crope');

        }
        //}
        $obj = json_encode($arr);
        return json_decode($obj);
    }
    function Rates() {
        return $this->hasMany(PostRate::class);
    }
    function calcRate() {
        try {
            if (!$this->Rates()->count() > 0) return 0;
            return round(array_sum($this->Rates()->pluck('rate')->toArray())/$this->Rates()->count(), 1);
        } catch (Exception $ex) {
            return 0;
        }
    }
    function getRelatedAttribute() {
        try {
            if (strpos(request()->url(), '/api/')===FALSE) 
            return null;


            $arr = [];
            $cat = $this->category_id;
            $props = PostTypeProperty::where("post_type_id", $this->post_type_id)
            ->where(
                function($t)use($cat) {
                    return $t->where('category_id', $cat)->orWhere('category_id', 0)->orWhereNull('category_id');
                }
            )->get();
            foreach ($props as $prop) {
                $arr[$prop->name] = $this->RelatedPost($prop->name);
            }
            $this->Properties = [];
            return $arr;

        } catch (Exception $ex) {
            return [];
        }
    }
    function getFileAttribute() {
        $arr = [];
        if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        $file = $this->Files()->where('model_attribute', 'main')->orderBy('id', 'desc')->first();
        if (!$file) {
            return null;
        }
        $arr['url'] = url('/uploads/files/'.$file->name);

        $arr['size'] = $file->size;

        return $arr;
    }
    function getRateAttribute() {
        $arr = [];
        if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        $arr['value'] = $this->calcRate();
        $arr['count'] = $this->Rates()->count();
        $arr['like'] = $this->calcLikes();
        $arr['dislike'] = $this->calcDisLikes();

        return $arr;
    }
    function calcLikes() {
        try {
            return $this->Rates()->where('rate', '>=', 3)->count();

        } catch (Exception $e) {
            return 0;
        }
    }
    function calcDisLikes() {
        try {
            return $this->Rates()->where('rate', '<', 3)->count();
        } catch (Exception $e) {

            return 0;
        }
    }
    function getCatAttribute() {
        $arr = [];
        //try {
        if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        if ($obj = Category::find($this->category_id)) {

            $arr['title'] = $obj->title;
            $arr['id'] = $obj->id;
        } else {
            return null;
        }
        /* } catch (\Exception $ex) {
            return $arr;

        }*/

        return $arr;
    }
    function getImagesAttribute() {
        $arr = [];
        if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        if (strpos(request()->url(), '/api/') > 0) {

            if ($postType = PostType::find($this->post_type_id)) {
                $arr['sm'] = $this->images($postType->img_size_sm, 'crope', 'images');
                $arr['md'] = $this->images($postType->img_size_md, 'crope', 'images');
                $arr['lg'] = $this->images($postType->img_size_lg, 'crope', 'images');
            } else {
                $arr['sm'] = $this->images('300x200', 'crope', 'images');
                $arr['md'] = $this->images('600x500', 'crope', 'images');
                $arr['lg'] = $this->images('800x600', 'crope', 'images');

            }
        }
        $obj = json_encode($arr);
        return json_decode($obj);

        //return $this->images('300x215')
    }
    function getWriterAttribute() {
        if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        if ($writer = \App\User::find($this->created_by))return $writer;
    }
    function getPubDateStrAttribute(){
      if (strpos(request()->url(), '/api/')===FALSE) 
            return null;

        return Func::time_string($this->pub_date);
    }
    
}

class PostTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['title',
        'body',
        'description',
        'meta_title',
        'meta_description'];

}