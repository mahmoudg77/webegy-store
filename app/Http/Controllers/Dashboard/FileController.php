<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\File as IModel;
use Illuminate\Support\Facades\Storage as Storage;

use Func;
class FileController extends IController
{
    var $metaTitle="الملفات";
    public $model=IModel::class;
    var $methods=['getFile'=>'Download Files'];

    public function getFile($filename){
        //dd($filename);
        return  response()->download(public_path("storage/attach/{$filename}")); //Storage::download($filename);
    }

}
