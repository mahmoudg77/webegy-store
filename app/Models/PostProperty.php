<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostProperty extends Model
{
       protected $fillable=['property_id','post_id','related_post_id'];

   public function Post(){
       return $this->belongsTo("App\Models\Post","post_id");
   }
   
   public function RelatedPost(){
       return $this->belongsTo("App\Models\Post","related_post_id");
   }
}
