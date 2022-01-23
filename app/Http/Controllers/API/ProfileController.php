<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;

use App\Extra\APIHelper;
use Auth;
use App\User ;
use App\Models\UserData ;
use App\Models\MediaFile;

/**
 * @group Profile Management
 */
class ProfileController extends Controller
{
    use APIHelper;
    /**
     * Get My Profile 
     * @authenticated 
     */
    function myProfile(){
        return $this->success(UserData::with('User')->with('Category')
        ->with('Nationality')->with('Country')->with('City')->where('user_id',Auth::user()->id)->first());

    }
    /**
     * Get Profile By ID
     * @urlParam id required Profile ID Example:14
     */
    function getProfile($id){
        return $this->success(UserData::with('User')->with('Category')
        ->with('Nationality')->with('Country')->with('City')->where('user_id',$id)->first());

    }
    
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
    public function uploadPersonalImage(Request $request)
    {
                $image=$request->file('img');
                $imageobj=new MediaFile(['model'=>User::class,'id'=>Auth::user()->id,'tag'=>'main']);
                $imageobj->upload($image);

        return $this->success(true);
  
    }
    
}
