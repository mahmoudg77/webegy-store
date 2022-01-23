<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\MediaFile as IModel;
use Func;
class MediaFileController extends IController
{
    var $metaTitle = "ملفات المالتيميديا";
    public $model = IModel::class;
    var $methods = ['deleteImage'=>'Delete image'];
    function deleteImage() {
       $data= IModel::where('model_name',request()->input('model'))
       ->where('model_attribute',request()->input('tag'))
       ->where('model_id',request()->input('model_id'))
       ->where('name',request()->input('img'))->first();
       $data->delete();
        return Func::success('Image deleted success!');
    }
}