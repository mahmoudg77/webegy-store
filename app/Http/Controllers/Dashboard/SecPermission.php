<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\SecPermission as IModel;
use Func;
use Auth;
class SecPermission extends IController
{
  protected $viewFolder="dashboard.sec.permission";
  var $methods=['getActionsList'=>'Get Action List'];
    var $metaTitle="Security Permissions";
    public $model=IModel::class;

  public function index()
  {
    /*if(request()->get('group')==null){
        return "Invalid Request !!";
    }*/
    if(request()->has('group'))
    $data=IModel::where('sec_group_id',request()->get('group'))->get();
    else
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
      $data=$request->except(['_token']);
      $data['created_by']=Auth::user()->id;

      //dd($data);
      IModel::where('controller',$data['ctrl'])->where('sec_group_id',$data['groupid'])->delete();

      $data_to_save=[];

      foreach ($data as $key=>$value){
          if(is_numeric($key) && in_array('action',array_keys($value))) {
                $value['created_by']=Auth::user()->id;
                $value['created_at']=date('Y-m-d H:i:n');
                $data_to_save[] = $value;
              }
      }
    //dd($data_to_save);
      if(IModel::insert($data_to_save)){
        return  Func::Success("Save Success",$data);
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
        return  Func::Success("Delete Success");
      }else{
        return Func::Error("Error while delete data !!");
      }
  }
  public function getActionsList()
  {

    $ctrl=request()->get('ctrl');
    $group=request()->get('group');

    if(!isset($ctrl) || $ctrl=='' || !isset($group) || $group=='')
        return json_encode(['success'=>false,'message'=>"Invalid request !!"]);
    if(!in_array($ctrl,array_keys(Func::controllers())))
        return json_encode(['success'=>false,'message'=>"Invalid request !!"]);

    $obj=new $ctrl;
    if(!isset($obj->methods)) return json_encode(['success'=>true,'data'=>null]);
    $methods=$obj->methods;

      $newarray=[];
      foreach ($methods as $key => $value) {
          $obj=IModel::where('action',$key)->where('controller',$ctrl)->where('sec_group_id',$group)->first();
          if(!$obj){
              $obj=new IModel();
              $obj->id=0;
              $obj->controller=$ctrl;
              $obj->action=$key;
              $obj->force_filter="";
              $obj->sec_group_id=$group;
          }
          $obj->force_filter=$obj->force_filter==null?"":$obj->force_filter;
          $newarray[]=$obj;
      }

    return json_encode(['success'=>true,'data'=>$newarray]);
  }

  public function getForceFilter(Request $request){
      $ctrl=$request->get('ctrl');
      $action=$request->get('action');
      $data=IModel::where('controller',$ctrl)->where('action',$action)->first();

      return json_encode(['success'=>true,'data'=>$data]);
  }
}
