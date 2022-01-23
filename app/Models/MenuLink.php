<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Astrotomic\Translatable\Translatable;

class MenuLink extends Model
{
    use Translatable;
    protected $fillable = ['menu_id','customlink','category_id','parent_id','hasSubs','icon','display_icon','display_title'];
    public $translatedAttributes = ['title'];

    public function Menu()
    {
      return $this->belongsTo("App\Models\Menu");
    }
    public function Links()
    {
      return $this->hasMany('App\Models\MenuLink','parent_id')->orderBy('sort');
    }
    public function Category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}


class MenuLinkTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['title'];

}
