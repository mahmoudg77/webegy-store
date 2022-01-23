<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    //
    public function Posts()
    {
      return $this->hasMany('App\Models\Post');
    }
    public function Roles()
    {
      return $this->belongsToMany('App\Models\SecGroup');
    }
}
