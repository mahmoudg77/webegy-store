<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Extra\APIHelper;
 /**
  * @group Setting
  */
class SettingController extends Controller
{
    use APIHelper;

    /**
     * Get All Settings
     */
    public function all(){
        return $this->success(Setting::all());
    }
    /**
     * Get Setting by key
     * @urlParam key required Setting Key
     */
    public function get($key){
        return $this->success(Setting::where('key',$key)->first());
    }
    /**
     * Get Setting by Group Key
     * @urlParam key required Group Key
     */
    public function group($key){
        $arr=[];
        foreach(Setting::where('group',$key)->select('key','id')->get() as $p)$arr[$p->key]=$p->value;
        return $this->success($arr);
    }
}
