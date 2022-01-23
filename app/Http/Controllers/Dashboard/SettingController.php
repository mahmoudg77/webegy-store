<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\Setting as IModel;

use Func;
use Auth;
use DB;
class SettingController extends IController
{
    protected $viewFolder = "dashboard.setting";
    var $metaTitle = "Website Settings";
    public $model = IModel::class;
    var $methods = ['editGroup'=>'Edit by group'];
    var $postmethods=['updateGroup'=>'editGroup'];

    public function index()
    {
        return view("dashboard.setting.index");
    }

    public function show()
    {
        $data=request()->get('data');
        //dd($data);
        $data=$data->get();//->orderBy('id');
        if($data==null){
            return  Func::Error( "Unauthorized !",$this->viewFolder.".edit",compact('data') );
        }
        return view($this->viewFolder.".edit",compact('data'));
    }

    public function update(Request $request)
    {

        $reqData=$request->get('setting');

        //$reqData['updated_by']=Auth::user()->id;

        $data=request()->get('data');

 //
 //       $data=$data->where('group',$group);
        if($data==null){
            return  Func::Error( "Unauthorized !",$this->viewFolder.".edit",compact('data') );
        }


        DB::beginTransaction();
        try{

            foreach ($reqData as $key=>$item){
                 $db_item=$data->find($key);
                 if($db_item)
                    $db_item->update($item);
            }

            DB::commit();
            return  Func::Success("Save Success");
        }catch (\Exception $ex){
            DB::rollback();
            return  Func::Error("Error while save data !! " ,$this->viewFolder.".edit",compact('data'));
        }


    }

}
