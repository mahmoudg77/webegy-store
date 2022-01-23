<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\Menu as IModel;
use Auth;
use Func;
class MenuController extends IController
{

  protected $viewFolder="dashboard.menu";
    var $metaTitle="القوائم";
    public $model=IModel::class;
    var $methods=[];

  public function index()
  {
      $data=request()->get('data');
      $data=$data->get();
    return view($this->viewFolder.".index",compact('data'));
  }

  public function edit($id)
  {
      $data=request()->get('data');
      $data=$data->find($id);
      if($data==null){
          return  Func::Error( "Unauthorized !",$this->viewFolder.".edit",compact('data') );
      }
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
      $data=request()->get('data');
      $data=$data->find($id);
      if($data==null){
          return  Func::Error( "Unauthorized !",$this->viewFolder.".edit",compact('show') );
      }
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
      $category['created_by']=Auth::user()->id;

      if(IModel::create($category)){
        return  Func::Success("Save Success");
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
      $data=IModel::find($id);

      if($data==null){

          return  Func::Error( "Unauthorized !",$this->viewFolder.".index" );
      }
      if($data->destroy($id)){
        return  Func::Success("Delete Success");
      }else{
        return  Func::Error("Error while delete data !!");
      }
  }


}
