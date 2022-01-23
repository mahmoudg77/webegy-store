<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Category;
use App\Extra\APIHelper;
use App\Models\Post;
use App\Models\PostRate;
use Func;
use Validator;
class RateController extends Controller
{    
    use APIHelper;
     
    public function rate()
    {
        
        /*$validator = Validator::make(request()->all(),['rate'=>'required|numeric','post_id'=>'required|numeric']);
        if ($validator->fails()) {
            return $this->error('Invalid Request !',412);
        }*/
        $rate=request()->input('rate');
        $postid=request()->input('post_id');
        if (!$rate || !$postid) {
            return $this->error('Invalid Request !',412);
        }
        $ip=request()->ip();
        
        $post=Post::find($postid);
        if(!$post)return $this->error('Invalid Post ID !',412);
        if(!$post->PostType->can_rate && ($rate>=3 && !$post->PostType->can_like) && ($rate<3 && !$post->PostType->can_dislike)) return Func::error('Not Support Rate Feature!');
        
        if($rateRec=PostRate::where('post_id',$postid)->where('ip',$ip)->first()){
            $rateRec->rate=$rate;
            $rateRec->save();
            return $this->success(trans("app.Rate Success"));
        }
        $rateRec=new PostRate();
        $rateRec->ip=$ip;
        $rateRec->rate=$rate;
        $rateRec->post_id=$post->id;
         //$location=geoip()->getLocation($ip);
        $location = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
        $rateRec->country=$location->geoplugin_countryName;
        $rateRec->city=$location->geoplugin_city;
        $rateRec->region=$location->geoplugin_region;
        $rateRec->country_code=$location->geoplugin_countryCode;
        
        $rateRec->longitude=$location->geoplugin_longitude;
        $rateRec->latitude=$location->geoplugin_latitude;
        
        //return json_encode($location);
        //PostRate::create(['rate'=>$rate,'post_id'=>$postid,'ip'=>$ip]);
        $rateRec->save();
        return $this->success(trans("app.Rate Success"));
    }
}
