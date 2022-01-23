<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\SecGroup as IModel;
use Auth;
use Func;
class SecGroup extends IController
{
  protected $viewFolder="dashboard.sec.group";

    var $metaTitle="Security Groups";
    public $model=IModel::class;
    var $methods=[];
  public function index()
  {
    $data=IModel::all();
    return view($this->viewFolder.".index",compact('data'));
  }

  public function edit($id)
  {
    $data=IModel::find($id);
    return view($this->viewFolder.".edit",compact('data'));
  }
  public function create()
  {
      return view($this->viewFolder.".create");
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
       $data=IModel::find($id);
       return view($this->viewFolder.".show", compact('data'));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
      $category=$request->except(['_token']);

      if(IModel::create($category)){
        return  Func::Success("Save Success",$category);
      }else{
        return  Func::Error("Error while save data !!");
      }

  }
  public function update(Request $request,$id)
  {
      //
      $category=$request->except(['_token']);
      $category['updated_by']=Auth::user()->id;
      //$category['id']=$id;
      //print_r($category);

      if(IModel::findOrFail($id)->update($category)){
        return  Func::Success("Save Success",$category);
      }else{
        return  Func::Error("Error while save data !!");
      }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
      $data=IModel::find($id);
      //$data->deleted_by=Auth::user()->id;
      //$data->save();

      if($data->destroy($id)){
        return  Func::Success("Delete Success",$data);
      }else{
        return  Func::Error("Error while delete data !!");
      }
  }
}
