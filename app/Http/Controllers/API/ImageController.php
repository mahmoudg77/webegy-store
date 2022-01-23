<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\VerifyMobile;
use App\Models\UserData;
use App\Models\MediaFile;
use Mail;
use Socialite;
use Auth;
use DB;
use Datatables;
use Setting;
use App\Extra\APIHelper;
use App\Mail\EmailVerification;
/**
 * @group Images
 *
 * APIs for managing images
 */
class ImageController extends Controller
{
    use APIHelper;
    /*
   

   /**
	 * Upload Image
     * @authenticated 
     * @response {
     *        "isSuccess": true,
     *        "code": 200,
     *        "message": "",
     *        "data":true
     *         }
	 */   
    public function upload(Request $request)
    {

                $image=$request->file('img');
                $imageobj=new MediaFile(['model'=>$request->model,'id'=>$request->model_id,'tag'=>$request->model_tag]);
                $imageobj->upload($image);

        return $this->success(true);
  
    }
 
      
      
}
