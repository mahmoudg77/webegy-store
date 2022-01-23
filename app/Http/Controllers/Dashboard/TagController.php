<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\Tag as IModel;
use Func;
class TagController extends IController
{
    var $metaTitle="Post Tags";
    public $model=IModel::class;
    var $methods=['getTags'=>'Get Recommended Tags'];

    public function getTags(){

        return  \GuzzleHttp\json_encode(IModel::where('name','like','%'.request()->get('term').'%')->pluck('name')->toArray());
    }
}
