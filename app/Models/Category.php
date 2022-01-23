<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Astrotomic\Translatable\Translatable;
use App\Extra\ImageCache;

class Category extends Model
{
    use softDeletes;
    use Translatable;
    use ImageCache;
    protected $fillable=['parent_id','created_by','slug','body'];
    public $translatedAttributes = ['title','description','body','meta_title','meta_description'];
    protected $appends=[
        'image',
        ];
    public function Posts()
    {
      return $this->hasMany('App\Models\Post');
    }
    public function Parent()
    {
      return $this->belongsTo(self::class,"parent_id");
    }
    public function Chields()
    {
      return $this->hasMany(self::class,"parent_id")->orderBy('sort');
    }
    public function Files()
    {
      return $this->hasMany("App\Models\File","model_id","id")->where('model_name',self::class);;
    }
    public function MediaFiles()
    {
      return $this->hasMany("App\Models\MediaFile","model_id","id")->where('model_name',self::class);;
    }
    public function Creator()
    {
        return $this->belongsTo("App\User","created_by","id")->withTrashed();
    }
    public function Profiles()
    {
      return $this->hasMany('App\Models\Profile');
    }


    public function mainImage($size='original',$mode='scale'){
      return $this->ImageUrl($size ,$mode );
    }
    public function mainFile(){
        $file=$this->Files()->where('model_attribute','main')->orderBy('id', 'desc')->first();
        if(!$file){
            return null;
        }
        return $file->name;
    }
    public function Visits(){
        return $this->hasMany(\App\Models\Visit::class,"model_id","id")->where('model_name',self::class);
    }
    function link(){
        return route('categoryBySlug',$this->slug);
    }
    function getImageAttribute(){
        $arr=[];
        $arr['sm']= $this->mainImage('300x200','crope');
        $arr['md']= $this->mainImage('600x500','crope');
        $arr['lg']= $this->mainImage('800x600','crope');
        $obj=json_encode($arr);
        return json_decode($obj);
    }
}

class CategoryTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['title','description','body','meta_title','meta_description'];

}
