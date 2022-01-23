<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use App\Http\Controllers\IController;
use App\Models\Post as IModel;
use App\Models\MediaFile;
use App\Models\File;
use App\Models\Category;
use App\Models\PostTypeProperty;
use App\Models\PostProperty;
use Func;
use Auth;
use DB;
use Datatables;
use Validator;



class PostController extends IController
{
    var $metaTitle = "المقالات والصفحات";
    public $model = \App\Models\Post::class;
    var $methods = ['getFreeSlug' => 'Create Free Slug',
        'publish' => 'Go to online post',
        'unpublish' => 'Go to offline post',
        'dataTable' => 'Data Table',
        // 'destroyِAll'=>'Delete All',
        'destroySelected' => 'Delete Selected',
        'publishSelected' => 'Publish Selected',
        'unpublishSelected' => 'UnPublish Selected',
        'moveSelected' => 'Move Selected'
    ];
    protected $viewFolder = "dashboard.post";

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $data = request()->get('data');
        
        if (request()->has("post_type_id")) {
            $post_type_id = request()->get('post_type_id');
            $data = $data->where('post_type_id', request()->get("post_type_id"));
            //$data = \App\Models\Post::where('post_type_id', request()->get("post_type_id"));
            //dd($data);
        }

        $filter_cats = [];
        if ($post_type_id) {
            $postType = \App\Models\PostType::find($post_type_id);
            if ($postType->has_category > 0)$filter_cats = Category::where("parent_id", $postType->has_category)->get();
        }
        $cat = Category::find(request()->get('cat'));
        if (!$cat) {
            $cat = new Category();
            $cat->title = "All";
            $cat->id = 0;
        }

        return view($this->viewFolder.".index", compact('data', 'post_type_id', 'filter_cats', 'cat', 'postType'));
    }

    public function edit($id) {
        $data = request()->get('data');
        $data = $data->find($id);
        //dd($data);
        if (!$data) {
                               return response(view('errors.403'));// return 
            //return Func::Error("Unauthorized !", $this->viewFolder.".edit", compact('data'));
        }
        return view($this->viewFolder.".edit", compact('data'));
    }
    public function create() {
        $post_type_id = request()->get('type');
        //$cat = Category::where('parent_id',0)->orWhereNull('parent_id')->pluck('title','id') ;
        return view($this->viewFolder.".create", compact('post_type_id'));
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        $data = request()->get('data');
        $data = $data->find($id);
        if ($data == null) {
            return Func::Error("Unauthorized !", $this->viewFolder.".edit", compact('show'));
        }
        return view($this->viewFolder.".show", compact('data'));
    }


    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $data = $request->except(['_token']);
        $postType = \App\Models\PostType::find($data['post_type_id']);
        if (!$postType) return Func::Error("Unkown post type !! ", $this->viewFolder.".create", compact('data')); //.$ex->getMessage());

        $data['slug'] =Func::getFreeSlug(IModel::class,$data['en']['title']);

        if ($postType->has_description) {
            $rules['en.description'] = 'required';
            $rules['ar.description'] = 'required';
        }
        if ($postType->has_body) {

            $rules['en.body'] = 'required';
            $rules['ar.body'] = 'required';
        }
        if ($postType->has_meta_tags) {

            $rules['en.meta_title'] = 'required';
            $rules['ar.meta_title'] = 'required';

            $rules['en.meta_description'] = 'required';
            $rules['ar.meta_description'] = 'required';
        }
        if ($postType->has_schedule) {


            $rules['pub_date'] = 'date';
        }
        //'slider_option'=>''
        
        $rules = [
            'image' => 'max:2048',
            'attach' => 'max:25600',
            'en.title'=>'required',
            'ar.title'=>'required',
            'category_id' => 'required',
        ];
        $messages = [
            'en.title.required' => trans('app.title en req'),
            'ar.title.required' => trans('app.title ar req'),
            'en.description.required' => trans('app.description en req'),
            'ar.description.required' => trans('app.description ar req'),
            'en.meta_title.required' => trans('app.meta_title en req'),
            'ar.meta_title.required' => trans('app.meta_title ar req'),
            'en.meta_description.required' => trans('app.meta_description en req'),
            'ar.meta_description.required' => trans('app.meta_description ar req'),
            'en.body.required' => trans('app.body en req'),
            'ar.body.required' => trans('app.body ar req'),
            'category_id.required' => trans('app.category req'),
            'attach.max' => trans('app.attach size'),
            'image.max' => trans('app.image size'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['created_by'] = Auth::user()->id;
        /*if (array_key_exists('is_published', $data) && $data['is_published'] == 1) {
            $data['pub_date'] = date('Y-m-d H:i:n');
        }*/
        if ($postType->publish_on_create == 1){
            $data['is_published'] = 1; //,1)}}
            $data['pub_date']=date('Y-m-d H:i:s');
        }
        if (array_key_exists('pub_date', $data)) {
            $data['is_published'] = 1;
        }

        DB::beginTransaction();
        //try {
        $post = IModel::create($data);
        //dd($post);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageobj = new MediaFile(['model' => IModel::class, 'id' => $post->id, 'tag' => 'main']);
            $imageobj->upload($image);
        }
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                //$image = $request->file('images');
                $imageobj = new MediaFile(['model' => IModel::class, 'id' => $post->id, 'tag' => 'images']);
                $imageobj->upload($image);
            }
        }
        if ($request->hasfile('attach')) {
            $file = $request->file('attach');
            $fileobj = new File(['model' => IModel::class, 'id' => $post->id, 'tag' => 'main']);
            $fileobj->upload($file);
        }
        if (in_array('tags', array_keys($data)))
            $tags = $data['tags'];
        if (isset($tags) && $tags != '' && $tags != null && !empty($tags)) {
            $list = explode(',', $tags);
            foreach ($list as $tag) {
                if (!$dbtag = \App\Models\Tag::where('name', $tag)->first())
                    $dbtag = \App\Models\Tag::create(['name' => $tag]);
                $post->Tags()->attach([$dbtag->id]);
            }
        }

        \App\Models\PostProperty::where('post_id', $post->id)->delete();
        if (in_array('props', array_keys($data))) {
            $props = $data['props'];
            if (isset($props) && $props != null && is_array($props)) {
                foreach ($props as $key => $prop) {
                    if ($dbprop = \App\Models\PostTypeProperty::find($key))
                        \App\Models\PostProperty::create(['property_id' => $dbprop->id, 'post_id' => $post->id, 'related_post_id' => $prop]);
                }

            }
        }

        DB::commit();
        //dd($data);
        if (array_key_exists('next_action', $data) && $data['next_action'] == 'create')
            return Func::Success("Save Success");
        else
            return Func::Success("Save Success", [], route('cp.posts.edit', $post->id));

        return back();
        /*}catch (\Exception $ex) {
             DB::rollback();
            return Func::Error("Error while save data !! ", $this->viewFolder.".create", compact('data')); //.$ex->getMessage());
        }*/

    }
    public function update(Request $request, $id) {

        $reqData = $request->except(['_token']);
        $postType = \App\Models\PostType::find($reqData['post_type_id']);

        $reqData['updated_by'] = Auth::user()->id;
        $data = request()->get('data');

        $rules = [
            'image' => 'max:2048',
            'attach' => 'max:25600',
            'en.title' => 'required',
            'ar.title' => 'required',
            'category_id' => 'required',
        ];
        if ($postType->has_description) {
            $rules['en.description'] = 'required';
            $rules['ar.description'] = 'required';
        }
        if ($postType->has_body) {

            $rules['en.body'] = 'required';
            $rules['ar.body'] = 'required';
        }
        if ($postType->has_meta_tags) {

            $rules['en.meta_title'] = 'required';
            $rules['ar.meta_title'] = 'required';

            $rules['en.meta_description'] = 'required';
            $rules['ar.meta_description'] = 'required';
        }
        if ($postType->has_schedule) {


            $rules['pub_date'] = 'date';
        }
        //'slider
        $messages = [
            'en.title.required' => trans('app.title en req'),
            'ar.title.required' => trans('app.title ar req'),
            'en.description.required' => trans('app.description en req'),
            'ar.description.required' => trans('app.description ar req'),
            'en.meta_title.required' => trans('app.meta_title en req'),
            'ar.meta_title.required' => trans('app.meta_title ar req'),
            'en.meta_description.required' => trans('app.meta_description en req'),
            'ar.meta_description.required' => trans('app.meta_description ar req'),
            'en.body.required' => trans('app.body en req'),
            'ar.body.required' => trans('app.body ar req'),
            'category_id' => trans('app.category'),
            'attach.max' => trans('app.attach size'),
            'image.max' => trans('app.image size'),

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $data->find($id);
        if ($data == null) {
            return Func::Error("Unauthorized !", $this->viewFolder.".edit", compact('data'));
        }
        $post_type_id = $data['post_type_id'];
        if (in_array('pub_date', $reqData) && !empty($reqData['pub_date'])) {
            $reqData['is_published'] = 1;
        }

        DB::beginTransaction();
        try {
            $data->update($reqData);
            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $imageobj = new MediaFile(['model' => IModel::class, 'id' => $data->id, 'tag' => 'main']);
                $imageobj->upload($image);
            }
            if ($request->hasfile('images')) {
                foreach ($request->file('images') as $image) {
                    //$image = $request->file('images');
                    $imageobj = new MediaFile(['model' => IModel::class, 'id' => $data->id, 'tag' => 'images']);
                    $imageobj->upload($image);
                }
            }
            if ($request->hasfile('attach')) {
                $file = $request->file('attach');
                $fileobj = new File(['model' => IModel::class, 'id' => $data->id, 'tag' => 'main']);
                $fileobj->upload($file);
            }

            if (in_array('tags', array_keys($reqData)))
                $tags = $reqData['tags'];
            $data->Tags()->delete();

            if (isset($tags) && $tags != '' && $tags != null && !empty($tags)) {
                $list = explode(',', $tags);
                foreach ($list as $tag) {
                    if (!$dbtag = \App\Models\Tag::where('name', $tag)->first())
                        $dbtag = \App\Models\Tag::create(['name' => $tag]);
                    $data->Tags()->attach([$dbtag->id]);
                }

            }

            \App\Models\PostProperty::where('post_id', $data->id)->delete();

            if (in_array('props', array_keys($reqData))) {
                $props = $reqData['props'];
                if (isset($props) && $props != null && is_array($props)) {
                    foreach ($props as $key => $prop) {
                        if ($dbprop = \App\Models\PostTypeProperty::find($key))
                            \App\Models\PostProperty::create(['property_id' => $dbprop->id, 'post_id' => $data->id, 'related_post_id' => $prop]);
                    }
                }
            }

            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ".$ex->getMessage(), $this->viewFolder.".edit", ['data' => $data, 'post_type_id' => $post_type_id]);
        }


    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {

        $data = IModel::withoutGlobalScopes()->find($id);

        if ($data == null) {
            return Func::Error("Unauthorized !", $this->viewFolder.".index");
        }
        // if($data->destroy($id)){
        //     return redirect()->route('cp.company.index', $data);
        // }else{
        //   return  Func::Error("Error while delete data !!");
        // }
        try {
            $reult = $data->delete($id);
        }catch (\Exception $ex) {
            return Func::Error("Error while save data !! ");
        }
        return Func::Success("Delete Success");

    }

    public function getFreeSlug() {
        $title = \request()->get('title');
        $slug = Func::getFreeSlug(IModel::class, $title);
        return Func::Success("Success", compact('slug'));
    }

    // public function getFreeSlug(){
    //   $title=\request()->get('title');

    //   $slug=Func::make_slug($title);
    //   dd($slug);
    //   return Func::Success("Success",compact('slug'));
    // }

    public function publish() {
        $data = request()->get('data');
        $id = request()->get('id');

        $data = $data->find($id);

        if ($data == null) {
            return Func::Error("Unauthorized !");
        }

        DB::beginTransaction();
        try {
            $data->is_published = 1;
            $data->pub_date = date("Y-m-d H:i:n");
            $data->save();

            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ");
        }
    }
    public function unpublish() {
        $data = request()->get('data');
        $id = request()->get('id');

        $data = $data->find($id);

        if ($data == null) {
            return Func::Error("Unauthorized !");
        }

        DB::beginTransaction();
        try {
            $data->is_published = 0;
            $data->pub_date = null;
            $data->save();

            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ");
        }
    }

    /**
    * Process datatables ajax request.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function dataTable() {
        $data = request()->get('data');
        
        //IModel::withoutGlobalScope(\App\Scopes\PubDateScope::class)->where('id','>',0);//
        //return (count($data));
        //return count($data);
        if (request()->has('related')) {
            
            foreach (request()->get('related') as $key => $value) {
                
                $property = PostTypeProperty::where('post_type_id', request()->get("post_type_id"))->where('name', $key)->first();
                if ($property) {
                    $relatesIDs = PostProperty::where('property_id', $property->id)->where('related_post_id', $value)->pluck('post_id')->toArray();
                     //if($relatesIDs && count($relatesIDs)>0)
                    $data= $data->whereIn('id', $relatesIDs);
                    //return response()->json($relatesIDs);
                }
                
            }
            
            //$data = $data->related(request()->get("type"), $key, $value);
        }
        if (request()->has("post_type_id")) {
            $data = $data->where('post_type_id', request()->get("post_type_id"));
            //$data = \App\Models\Post::where('post_type_id', request()->get("post_type_id"))->get();
        }
        if (request()->has("cat") && request()->get("cat") != '0') {
            $catids = [];
            if ($cat = Category::find(request()->get('cat'))) {

                $catids = $cat->Chields()->pluck('id')->toArray();

                foreach ($cat->Chields as $sub) {
                    $catids = array_merge($catids, $sub->Chields()->pluck('id')->toArray());
                }
                $catids[] = $cat->id;
                //$catIds[]=request()->get("cat");
            }
            $data = $data->whereIn('category_id', $catids);
        }


        return Datatables::of(IModel::where('post_type_id', request()->get("post_type_id"))->withTranslation())
        ->addColumn('select', function ($post) {
            return "";
        })
        ->addColumn('action', function ($post) {
            $postype = \App\Models\PostType::find($post->post_type_id);
            return Func::actionLinks('posts', $post->id, "tr",
                ["edit" => ['class' => (strpos($postype->buttons, 'edit') === FALSE?'d-none':'')],
                    "delete" => ['class' => (strpos($postype->buttons, 'delete') === FALSE?'d-none':'')],
                    "view" => ['class' => (strpos($postype->buttons, 'view') === FALSE?'d-none':''), "target" => "_blank", 'href' => "/".app()->getLocale()."/".$post->slug]
                ]);
        })
        ->addColumn('pub_date', function ($data) {
          return Func::time_string($data->pub_date);// date('Y-m-d', strtotime($data->pub_date));
        })
        ->addColumn('created_at', function ($data) {
            return date('Y-m-d', strtotime($data->created_at));
        })
        ->addColumn('category', function ($post) {
            if ($post->Category) {
                return $post->Category->title;
            }
            return "";
        })
        // ->addColumn('creator',function ($post) {
        //     return $post->Creator->name;
        // })
        /*->addColumn('image',
            function ($post) {
                return '<img src="'.$post->mainImage().'" class="img-responsive" width="100px"/>';
            })*/
        // ->addColumn('file',function ($post) {
        //     return ($post->mainFile()? '<a href="/uploads/files/'.$post->mainFile().'">Download</a>':'');
        // })
        ->addColumn('visits',
            function ($post) {
                return $post->Visits()->count();
            })
        ->addColumn('status',
            function ($item) {
                return '<a href="#" title="Publish/UnPublish Post" data-id="'.$item->id.'" class="bt-n btn-def-ault '.($item->is_published?"unpublish":"publish").'"><span class="fa fa-2x '.($item->is_published?"fa-toggle-on":"fa-toggle-off").' '.($item->is_published?"text-success":"text-danger").'"></span></a>';
            })
        ->rawColumns([
            //'image',
            'file',
            'action',
            'status'])
        ->toJson();
    }

    //   public function destroyِAll()
    //   {
    //     $request=\request()->get('data');

    //     $data=IModel::whereIn('id',$request['ids']);

    //     if($data==null){
    //         return  Func::Error( "Unauthorized !",$this->viewFolder.".index" );
    //     }

    //     try{
    //         foreach ($data as $item) {
    //             $data->destroy($item->id);
    //         }
    //     }catch (\Exception $ex){
    //         return  Func::Error("Error while save data !! ".$ex->getMessage());
    //     }
    //     return  Func::Success("Delete Success");
    //   }
    public function destroySelected() {
        $request = \request()->get('ids');
        //dd($request);
        $data = IModel::withoutGlobalScopes()->whereIn('id',
            $request)->get();

        if ($data == null) {
            return Func::Error("Unauthorized !", $this->viewFolder.".index");
        }
        //dd($data);
        try {
            foreach ($data as $item) {
                IModel::delete($item->id);
            }
        }catch (\Exception $ex) {
            return Func::Error("Error while save data !! ".$ex->getMessage());
        }
        return Func::Success("Delete Success");
    }

    public function unpublishSelected() {
        $request = \request()->get('ids');
        //dd($request);
        $data = IModel::withoutGlobalScopes()->whereIn('id', $request)->get();

        if ($data == null) {
            return Func::Error("Unauthorized !");
        }

        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                $item->is_published = 0;
                $item->pub_date = null;
                $item->save();
            }
            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ");
        }
    }
    public function publishSelected() {
        $request = \request()->get('ids');
        //dd($request);
        $data = IModel::withoutGlobalScopes()->whereIn('id', $request)->get();

        if ($data == null) {
            return Func::Error("Unauthorized !");
        }

        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                $item->is_published = 1;
                $item->pub_date = date("Y-m-d H:i:n");;
                $item->save();
            }
            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ");
        }
    }
    public function moveSelected() {
        $request = \request()->get('ids');
        $cat = \request()->get('cat');
        //dd($request);
        $data = IModel::withoutGlobalScopes()->whereIn('id', $request)->get();

        if ($data == null) {
            return Func::Error("Unauthorized !");
        }

        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                $item->category_id = $cat;
                $item->save();
            }
            DB::commit();
            return Func::Success("Save Success");
        }catch (\Exception $ex) {
            DB::rollback();
            return Func::Error("Error while save data !! ".$ex->getMessage());
        }
    }
}