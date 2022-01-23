<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\PostType as IModel;
use Func;

class PostTypeController extends IController
{
    var $metaTitle="أنواع المحتوى";
    public $model=IModel::class;
    var $methods=[];
 }
