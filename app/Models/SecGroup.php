<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecGroup extends Model
{
  protected $fillable=['name','groupkey'];

    public function Permissions()
    {
      return $this->hasMany('App\Models\SecPermission');
    }
    public function Accounts()
    {
      return $this->belongsToMany('App\Models\User')->withTrashed();
    }
    public function PostTypes()
    {
      return $this->hasMany('App\Models\PostTypes');
    }
}
