<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;
class PubDateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(!Auth::check())
         $builder->where('is_published',1)
         /*->where(function($query){
                $query->where('is_published',1)->orWhereNULL('is_published');
              }
              */
         ->where('pub_date', '<=',date("Y-m-d H:i",strtotime('+2 hours')));
        
    }
}