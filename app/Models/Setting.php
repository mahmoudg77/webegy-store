<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Astrotomic\Translatable\Translatable;
class Setting extends Model
{
    use Translatable;
    protected $fillable=['name', 'hint', 'key', 'type', 'availables', 'group'];
    public $translatedAttributes = ['value'];

    public static function getIfExists($key,$default=""){
       $setting=self::where('key',$key)->first();

       return ($setting && !empty($setting->value) && $setting->value!="" )?$setting->value:$default;
    }
}

class SettingTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['value'];

}
