<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\User as IModel;
 
use Auth;
use Func;
use DB;
use Datatables;
use Validator;
use Redirect;
use Session;
 
class UserController extends IController
{
  protected $viewFolder="dashboard.user";
    var $metaTitle="Users";
    public $model=IModel::class;
    var $methods=[
        'dataTable'=>'Data Table',
        'publish'=>'publish',
        'unpublish'=>'unpublish',
        'resendVerifyMail'=>'Resend verification mail'
      ];
  public function index()
  {
    $data=request()->get('data');
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
       //dd($data);
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

      $category=$request->except(['_token']);
      $category['created_by']=Auth::user()->id;
      if($category['confirm-password']!=$category['password']) 
       return  Func::Error("The passwords not matches !!");
      
      $category['password']=bcrypt($category['password']);

      if(IModel::create($category)){
          
        return  Func::Success("Save Success");
      }else{
        return  Func::Error("Error while save data !!");
      }

  }

  public function update(Request $request,$id)
  {
    $reqData=$request->except(['_token','_method']);
    $data=request()->get('data');
    $data=$data->find($id);
    if($data==null){
        return  Func::Error( "Unauthorized !",$this->viewFolder.".edit",compact('data') );
    }
    $data['updated_by']=Auth::user()->id;

    DB::beginTransaction();
    try{
        $data->update([
            "name" => $reqData['name'],
            //"country" => $reqData['country'],
            "city" => $reqData['city'],
            "account_level_id" => $reqData['account_level_id']
            ]
        );
        
        DB::commit();
        Session::flash('success', 'Save Success.');
        return redirect()->route('cp.user.edit',$id);
    }catch (\Exception $ex){
        DB::rollback();
        Session::flash('error', $ex->getMessage());
        return redirect()->route('cp.user.edit', $id)->withErrors("Error while save data !!");;
        //return  Func::Error("Error while save data !! ".$ex->getMessage() ,$this->viewFolder.".edit");
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

      if($data==null){

          return  Func::Error( "Unauthorized !",$this->viewFolder.".index" );
      }
      try{
          $data->destroy($id);
          $data->Profile->destroy();
      }catch (\Exception $ex){
          return  Func::Error("Error while save data !! ");
      }
      return  Func::Success("Delete Success");

  }
    public function dataTable()
    {
        //$data=\request()->get('data');
        $data=IModel::all();
        //dd($data);
        return Datatables::of($data)
            /*->addColumn('action', function ($item) {
                return Func::actionLinks('user',$item->id,"tr",["edit"=>['class'=>"edit"],"view"=>['class'=>"view"]]);
            })*/
            ->addColumn('account_level', function ($item) {
                return ($item->AccountLevel)?$item->AccountLevel->role:"None";
            })
            ->addColumn('action2', function ($item) {
                return ($item->verified == 1)?'<a class="btn btn-sm btn-success">'.trans('app.verifed').'</a>':'<a class="btn btn-sm btn-danger resendVerify" data-rowid="'.$item->id.'">'.trans('app.not verifed').'</a>';
            })
            ->rawColumns(['image','file','action2','status'])
            ->make(true);
    }
    
     public function resendVerifyMail()
    {
         $id=request()->get('id');
         $user=\App\User::find($id);
        if($user){
            try{
                $user->sendEmailVerificationNotification();  
                return  Func::Success("Vreification mail sent successfuly.");
            }catch(\Exception $ex){
                return  Func::Error($ex->getMessage());
            }
        } 
        
      return  Func::Error("Cannot find this user details !");

            
    }
    
}
