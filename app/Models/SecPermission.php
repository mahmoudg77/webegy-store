<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecPermission extends Model
{
   protected $fillable=['sec_group_id','controller','action','created_by'];

  public function Groups()
  {
    return $this->belongsToMany('App\Models\SecGroup');
  }
  public function Group(){
      return $this->belongsTo('App\Models\SecGroup','sec_group_id');
  }
  

}
