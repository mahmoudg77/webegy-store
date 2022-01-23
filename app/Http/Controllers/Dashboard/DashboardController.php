<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\IController;
use Illuminate\Http\Request;
use Func;
class DashboardController extends IController
{
    //
    var $metaTitle="لوحة التحكم";
    public $model=null;
    var $methods=[];
    public function index()
    {
      # code...
      return view("dashboard.dashboard");
    }
}
