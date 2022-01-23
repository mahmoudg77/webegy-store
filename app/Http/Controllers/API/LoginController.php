<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;

use App\Extra\APIHelper;
use Auth;
use App\User ;

/**
 * @group User Session
 *
 * APIs for managing user session
 */
class LoginController extends Controller
{
    use APIHelper;

    /**
	 * Login
     * @bodyParam phone string required Email address Example:01143184244
     * @bodyParam password string required User password Example:123456
	 */
    public function login(Request $request){
        $v=$this->validate($request, [
            'phone' => 'required|string|max:11',
            'password' => 'required|string|min:6',
        ]);

        //if($v->fails()) return $this->error("Validation Error!!",422,$v->messages());
        $user=User::where('phone',$request->get('phone'))->first();
            //dd(\Hash::check($request->password,$user->password));
        if(!$user || !\Hash::check($request->password,$user->password)) return $this->error("Invalid login data !",422);
        //dd($user);
        // if(!$user->verified)   return $this->error(trans("api.login.not-verified"),422);
        // if($user->active<1)   return $this->error(trans("api.login.not-activated"),422);

        $user->api_token=str_random(64);
        if($user->update())
        return $this->success(['token'=>$user->api_token,'user'=>$user]);

        return $this->error("Cannot Authenticate User",500);

    }
    /**
	 * Check User
     * @authenticated 
	 */
    function check(){
        $user=Auth::user();
        if($user)
        return $this->success(['token'=>$user->api_token,'user'=>$user]);

        return $this->error("Not Authenticated User",401);
    }
    /**
	 * Save Firebase Token
     * @authenticated 
     * @bodyParam token string required Firebase idToken 
     * @response {
     *        "isSuccess": true,
     *        "code": 200,
     *        "message": "",
     *        "data":true
     *         }
	 */
    function saveNewToken(Request $request){
        $user=Auth::user();
        $user->device_id=$request->get('token');
       
        if($user->update())
        return $this->success(true);

        return $this->error(false,100);
    }
    /**
	 * Logout
     * @authenticated 
     * @response {
     *        "isSuccess": true,
     *        "code": 200,
     *        "message": "",
     *        "data":true
     *         }
	 */
    function logout(){
        $user=Auth::user();
        $user->api_token=null;
        if($user->update())
        return $this->success(true,"Logout success !");

        return $this->error(false,100);

    }

    
}
