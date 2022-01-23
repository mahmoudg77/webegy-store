<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTypeProperty extends Model
{

   public static function getProperties($post_type_id,$category=0){
       if($category==0)
            return self::where('post_type_id',$post_type_id)->get();
       else
            return self::where('post_type_id',$post_type_id)->where('category_id',$category)->get();
   } 
   public function data($post_id){
       if($this->is_single>0){
            return $this->hasMany("App\Models\PostProperty","property_id","id")->where('post_id',$post_id)->first();
       }else{
          return $this->hasMany("App\Models\PostProperty","property_id","id")->where('post_id',$post_id)->get();
       }
   }

   public function relatedDatasource(){
       if($this->related_category_id)
            return $this->hasMany("App\Models\Post","post_type_id","related_post_type_id")->where('category_id',$this->related_category_id);
       else 
            return $this->hasMany("App\Models\Post","post_type_id","related_post_type_id");
        
   }
   public function PostType(){
       return $this->belongsTo('App\Models\PostType');
   }
}
