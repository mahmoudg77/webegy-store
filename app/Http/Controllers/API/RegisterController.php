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
 * @group Register 
 */
class RegisterController extends Controller
{
    use APIHelper;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd($data);
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:6',
            // 'photo' => 'required','mimes:image/jpeg',
        ]);
    }


    protected function create(array $data)
    {
      $location=geoip()->getLocation(\Request::ip());
         return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone'=>$data['phone'],
            'email_token' => base64_encode($data['email']),
            'account_level_id'=>$data['account_level_id']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @bodyParam name string required Full Name
     * @bodyParam email string optional Email Address
     * @bodyParam phone string required Mobile Number
     * @bodyParam country_id int optional Country ID
     * @bodyParam city_id int optional City ID
     * @bodyParam birthdate date required Date Of Birth
     * @bodyParam password required Create Password
     * @bodyParam team_count int optional Team Count 
     * @bodyParam photo file Personal Photo
     * @bodyParam efa_card file optional EFA Card Photo
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
         
       $this->validator($request->all())->validate();

        //dd($request);
        $data=$request->except(['_token','confirm','code']);
        $data['account_level_id']=2;//$data['acc_type'];
        if($data['email']==null || $data['email']==''){
            $data['email']=$data['phone'];
        }
        
        DB::beginTransaction();
        try {
            $user = $this->create($data);
            
             if($request->hasfile('photo')){
            $image=$request->file('photo');
            $imageobj=new MediaFile(['model'=>User::class,'id'=>$user->id,'tag'=>'main']);
            $imageobj->upload($image);
             }
            if($request->hasfile('efa_card')){

                $image=$request->file('efa_card');
                $imageobj=new MediaFile(['model'=>User::class,'id'=>$user->id,'tag'=>'efa']);
                $imageobj->upload($image);
            }
            VerifyMobile::sendCode($user->phone);          
            DB::commit();
        } catch(\Exception $th) {
            DB::rollback();
            //if($contr)$contr->delete();
             return $this->success($th->getMessage(),422);
             //die($th->getMessage());
        }
        

        //event(new Registered($user));

        // try{
            
        // // $email = new EmailVerification($user);

        // // Mail::to($user->email)->send($email);
        

        // }catch(\Exception $ex){
                
        //     return $this->error($ex->getMessage(),500);
        // }
            
        $user->api_token=str_random(64);
        if($user->update())
        return $this->success(['token'=>$user->api_token,'user'=>User::find($user->id)]);

        return $this->error("Cannot Authenticate Use",500);
        
       
    }
    /**
     * Check if exists email
     * @bodyParam email string required Email Addres Example:mahmoudg77@gmail.com
    */
      public function checkEmail(Request $request){
          if(User::where('email',$request->get('email'))->count()>0){
              return $this->error('The email has already been taken',422);
          }
            return $this->success();
        }
    /**
     * Check if exists phone
     * @authenticated 
     * @bodyParam phone string required Mobile number Example:01143184244
    */
      public function checkPhone(Request $request){
          if(User::where('phone','like','%'.$request->get('phone').'%')->count()>0){
              return $this->error('The phone has already been taken',422);
            }
            return $this->success();
        }
     
     /**
     * Verify user phone
     * @authenticated 
     * @bodyParam code string required OTP code Example:996552
    */
        public function verifyMobile($code){
            $user=Auth::user();
           if(VerifyMobile::isVerified($user->phone,$code)){
                $user->verified=1;
               $user->save();
               return $this->success(true);
           } 
            return $this->error("Invalied code !",422);
          
        }
          /**
     * Send OTP Code to user phone for verification
     * @authenticated 
     * @bodyParam code string required OTP code Example:996552
    */
    public function sendOTPCode(){
        $user=Auth::user();
        if($user->verified) return $this->error("Your phone verified already!",422);
        if(VerifyMobile::sendCode($user->phone)){
            return $this->success(true);
        } 
        return $this->error("Error in OTP Service Provider",506);
        
    }
}
