<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use Thumbnail;
use App\User;
use App\Models\UserData;
use App\Models\File;
use App\Models\MediaFile;
use App\Extra\APIHelper;
use App\Models\Category;
use Auth;
/**
 * @group Talent Videos
 */
class TalentController extends Controller
{
    use APIHelper;
    /**
     * 
     */
    public function get($id){
        return $this->success(UserData::with(['User'=>function($query){
            return $query->select('id','name');
        }])->whereHas('User',function($query){
            return $query->where('account_level_id',2)->where('approved_talent',1);
        })->with('Category')->with('Country')->with('City')->find($id));
    }
    public function all(){
        return $this->success(UserData::with(['User'=>function($query){
            return $query->select('id','name');
        }])->whereHas('User',function($query){
            return $query->where('account_level_id',2)->where('approved_talent',1);
        })->with('Category')->with('Nationality')->with('Country')->with('City')->get());
    }
    
    public function upload(Request $request){
      
 
       if(!$request->hasfile('attach')){
        return $this->error('Invalid file !!',422);
       }

        $user=Auth::user();
 
        // if($user->approved_talent==0){
        //     return $this->error('Your talent file already submited and waiting review',422);
        // }
        // if($user->approved_talent==1){
        //     return $this->error('Your talent file already accepted, And you don\'t need submit more files',422);
        // }
        // if($user->approved_talent==3){
        //     return $this->error('Your talent file rejected, And you cannot submit another files',422);
        // }


        $videos=[ 
            // "video/x-flv",
            "video/mp4",
            // "application/x-mpegURL",
            // "video/MP2T",
            "video/3gpp",
            // "video/quicktime",
            // "video/x-msvideo",
            // "video/x-ms-wmv",
            // "video/avi",
            "video/webm",
        
          // "audio/basic",
          // "auido/L24",
          // "audio/mid",
          // "audio/mid",
          "audio/mpeg",
           "audio/m4a",
          // "audio/mp4",
          // "audio/x-aiff",
          // "audio/x-aiff",
          // "audio/x-aiff",
          // "audio/x-mpegurl",
          // "audio/vnd.rn-realaudio",
          // "audio/vnd.rn-realaudio",
          "audio/ogg",
          // "audio/vorbis",
          "audio/vnd.wav",
          "audio/*",
        ];
        

    //   if(!in_array($request->file('attach')->getMimeType(),$videos)){
    //       return $this->error("Not Supported File.".$request->file('attach')->getMimeType(),422);
    //   }

        $this->validate($request,[
            'attach' => 'max:25600',"mimes:audio/*,video/*"
            ]);
        //    "mimes:flv,avi,mp4,mp3,asf,3gp"

//"mimes:flv,avi,mp4,mp3,asf,3gp,m4a,webm,3gpp,mpeg,ogg,wav,wma"

        try{

            $file=$request->file('attach');
            $thumbnail_path   = public_path('/uploads/images');
            
            // $thumb=$request->file('thumb');
            $fileobj=new File(['model'=>User::class,'id'=>$user->id,'tag'=>'talent']);
            
            
            if($fileobj->upload($file)){
                
            $thumbnail_image  = $user->id.".".$fileobj->id.".jpg";
            Thumbnail::getThumbnail(storage_path('app/attach/' . $fileobj->name),$thumbnail_path,$thumbnail_image,1);
            // $image=new MediaFile(['model'=>\App\Models\Videos::class,'id'=>$fileobj->id,'tag'=>'talent']);
            // $image->upload($thumb);
                // $user->approved_talent=0;
                // $user->save();
                $fileobj->title=$request->title;
                $fileobj->category_id=$request->category_id;
                $fileobj->description=$request->description;
                $fileobj->image="/uploads/images/".$thumbnail_image;
                // $fileobj->image="/uploads/images/video-thumb.jpg";
                $fileobj->save();
            }else{
                return $this->error('Error while upload',500);
            }
                  
           // Session::flash('success', 'Your talent uploaded.');
            return $this->success('Your talent uploaded.');
        }catch (\Exception $ex){
          return $this->error($ex->getMessage(),500);
           //return redirect()->back()->with('error', $ex->getMessage());;

        }

    }
    public function status(){
        $user=Auth::user();
        if($user->approved_talent==-1){
            return $this->success(['status'=>-1,'name'=>'New','message'=>'']);
        }
        if($user->approved_talent==0){
            return $this->success(['status'=>0,'name'=>'Waiting','message'=>'']);
        }
        if($user->approved_talent==1){
            return $this->success(['status'=>1,'name'=>'Accepted','message'=>'']);
        }
        if($user->approved_talent==3){
            return $this->success(['status'=>3,'name'=>'Rejected','message'=>$user->UserData->message]);
        }
        if($user->approved_talent==2){
            return $this->success(['status'=>2,'name'=>'Commented','message'=>$user->UserData->message]);
        }
        return $this->error("Status Error",500);
    }
      /**
     * Get videos by category id
     * @urlParam id required Category ID Example:5
     */
    public function getVideosByCatID($id){
        //$type=request()->get('type');
        $limit=request()->get('limit',20);
        $order=request()->get('order','id,desc');
        $offset=request()->get('offset',0);

        if($cat=Category::find($id)){
            //dd($cat->Videos);
            $posts=$cat->Videos()->limit($limit)->offset($offset)->orderBy(explode(',',$order)[0],explode(',',$order)[1])->get();
            return $this->success($posts);
        }

        return $this->error("Category Not Found !",404);

        
    }
 }
