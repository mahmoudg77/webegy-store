<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=['location','name'];

    public function Links()
    {
        return $this->hasMany("App\Models\MenuLink","menu_id")->orderBy('sort');
    }

}
