<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\MenuLink as IModel;
use Auth;
use Func;
class MenuLinkController extends IController
{
   protected $viewFolder="dashboard.menulink";
   var $metaTitle="عناصر القائمة";
   public $model=IModel::class;
   var $methods=[];
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if(request()->has("m")){
      $m=request()->get('m');

      $data= IModel::where(function ($query) {
          $query->where('parent_id', '=', 0)
              ->orWhereNull('parent_id');
      })->where('menu_id',request()->get("m"))->get();
    }else{
      return "404 File not found !!";
    }
      return view($this->viewFolder.".index",compact('data','m'));
  }

  public function edit($id)
  {
    $data=IModel::find($id);
    return view($this->viewFolder.".edit",compact('data'));
  }
  public function create()
  {
    if(request()->has("m")){
      $m=request()->get('m');
      $data=IModel::where('menu_id',request()->get("m"))->get();
    }else{
      return "404 File not found !!";
    }
       return view($this->viewFolder.".create",compact('m'));
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
      $data=$request->except(['_token']);

      if($data['type']==0)$data['category_id']=null;
      if($data['type']==1)$data['customlink']=null;
      
       
      $data['display_title']=($request->has('display_title'))?1:0;
      $data['display_icon']=($request->has('display_icon'))?1:0;

      if(IModel::create($data)){
        return  Func::Success("Save Success",$data);
      }else{
        return  Func::Error("Error while save data !!");
      }

  }
  public function update(Request $request,$id)
  {
      //
      $data=$request->except(['_token']);
      $data['updated_by']=Auth::user()->id;
      if($data['type']==0)$data['category_id']=null;
      if($data['type']==1)$data['customlink']=null;
 
      $data['display_title']=($request->has('display_title'))?1:0;
      $data['display_icon']=($request->has('display_icon'))?1:0;

      if(IModel::findOrFail($id)->update($data)){
        return  Func::Success("Save Success",$data);
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

      if($data->destroy($id)){
        return  Func::Success("Delete Success");
      }else{
        return  Func::Error("Error while delete data !!");
      }
  }

}
