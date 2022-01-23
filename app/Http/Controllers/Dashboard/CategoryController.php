<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\IController;
use App\Models\Category as IModel;
use App\Models\MediaFile;
use App\Models\File;
use Auth;
use Func;
use DB;

class CategoryController extends IController
{
  protected $viewFolder="dashboard.category";
    var $metaTitle="أقسام الموقع";
    public $model=IModel::class;
    var $methods=[];
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => 'destroy']);
    // }
  public function index()
  {
    $data=IModel::where("parent_id",0)->orWhereNull('parent_id')->get();
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
      $category=$request->except(['_token']);
      $category['slug']=str_slug($category['en']['title'],'-');

      DB::beginTransaction();
      try{
        $cat=IModel::create($category);

        if($request->hasfile('image'))
        {
            $image=$request->file('image');
            $imageobj=new MediaFile(['model'=>IModel::class,'id'=>$cat->id,'tag'=>'main']);
            $imageobj->upload($image);
        }
        //   if($request->hasfile('attach'))
        //   {
        //       $file=$request->file('attach');
        //       $fileobj=new File(['model'=>IModel::class,'id'=>$category->id,'tag'=>'main']);
        //       $fileobj->upload($file);
        //   }

        DB::commit();

          return  Func::Success("Save Success");
      }catch (\Exception $ex){
          DB::rollback();
          return  Func::Error("Error while save data !! " .$ex->getMessage(),$this->viewFolder.".create",compact('data'));
      }

  }
  public function update(Request $request,$id)
  {
      //
      $category=$request->except(['_token']);
      $category['updated_by']=Auth::user()->id;

      if(IModel::findOrFail($id)->update($category)){
        if($request->hasfile('image'))
        {
            $image=$request->file('image');
            $imageobj=new MediaFile(['model'=>IModel::class,'id'=>$id,'tag'=>'main']);
            $imageobj->upload($image);
        }
        if($request->hasfile('attach'))
        {
            $file=$request->file('attach');
            $fileobj=new File(['model'=>IModel::class,'id'=>$id,'tag'=>'main']);
            $fileobj->upload($file);
        }
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

        if($data->is_deleted == 0){
              if($data->destroy($id)){
                return  Func::Success("Delete Success");
              }else{
                return  Func::Error("Error while delete data !!");
              }
        }else{
            return  Func::Error("This category don't removed !!");
        }
  }


}
