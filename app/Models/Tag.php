<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    public function Posts()
    {
      return $this->belongsToMany('App\Models\Post',"posts_tags_relationship");
    }
}
