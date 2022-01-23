<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use Auth;
use Func;
use DB;
use Datatables;
use App\Models\Language;
use App\Extra\APIHelper;
class LanguagesController extends IController
{
    use APIHelper;
  protected $viewFolder="dashboard.language";
    var $metaTitle="Languages";
    //public $model=IModel::class;
    var $methods=[
        'install'=>'Install language',
        'uninstall'=>'Uninstall language',
    ];


    public function index()
    {
        $data=Language::orderBy('installed','desc')->get();
        return view($this->viewFolder.".index",compact('data'));
    }
    public function install(){
        //dd('install function');
        $lang=Language::where('code',request()->get('code'))->first();
        $lang->install();
        
        return $this->success('Installed Success !!');
    }   
    public function uninstall(){
        $lang=Language::where('code',request()->get('code'))->first();
        $lang->uninstall();
        return $this->success('Uninstalled Success !!');
    
    }
}