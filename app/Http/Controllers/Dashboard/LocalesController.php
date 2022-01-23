<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use Auth;
use Func;
use DB;
use Datatables;
use Lang;
use File as Dir;
class LocalesController extends IController
{
  protected $viewFolder="dashboard.locales";
    var $metaTitle="Locales";
    //public $model=IModel::class;
    var $methods=[
        'save'=>'Save changes',
        'dataTable2'=>'Data Table Dashboard',
    ];


    public function index()
    {
        $lang=request()->get('l');
        $g=request()->get('g');
        
        if(!isset($lang))$lang=app()->getLocale();
        $files=array_map(function($item){
            
            $paths=explode('/',$item);
            $filename=$paths[count($paths)-1];
            return explode('.',$filename)[0];
        },Dir::allFiles(resource_path("lang/en")));
        $currLang=app()->getLocale();
        //if(!is_array($data)){
            app()->setLocale('en');
            $enData=Lang::get($g);
        //}
        
        app()->setLocale($lang);
        $langData=Lang::get($g);
        $data=$enData;
        if(!is_array($langData)) $langData=$enData;
        if(isset($enData))
        foreach ($enData as $key=>$value)
        $data[$key]=array_key_exists($key,$langData)?$langData[$key]:$value;
        
        app()->setLocale($currLang);
        
        
        return view($this->viewFolder.".index",compact('data','files','g','lang'));
    }
public function save()
    {
        $lang=request()->get('l');
        $g=request()->get('g');
        if(!isset($lang))$lang=app()->getLocale();
        $filename=resource_path("lang/".$lang
           .'/'.$g.'.php');
           
       // return "test";
       file_put_contents(
           $filename, '<?php '.PHP_EOL.'return '.printArray(request()->input('vals')).';');
           return Func::success("Save success");
    }
}
function printArray($arr, $pad = 0, $padStr = "\t") {
    $outerPad = $pad;
    $innerPad = $pad + 1;
    $out = '[' . PHP_EOL;
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            $out .= str_repeat($padStr, $innerPad) ."'". $k ."'". ' => ' . printArray($v, $innerPad)."," . PHP_EOL;
        } else {
            $out .= str_repeat($padStr, $innerPad) ."'". $k ."'". ' => ' ."'".addslashes($v)."',";
            $out .= PHP_EOL;
        }
    }
    $out .= str_repeat($padStr, $outerPad) . ']';
    return $out;

}
