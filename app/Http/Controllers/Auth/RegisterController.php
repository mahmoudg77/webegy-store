<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Mail;
use Socialite;
use Auth;
use DB;
use App\Mail\EmailVerification;
use App\Models\MediaFile;
use Setting;
class RegisterController extends Controller
{
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
        $this->middleware('guest');
        $this->redirectTo= route('cp.dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            //'name' => 'required|string|max:255',
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,0,id,deleted_at,NULL',
            'phone'=>'required|string|max:11|unique:users,phone,0,id,deleted_at,NULL',
            'password' => 'required|string|min:6|confirmed',
            // 'speciality_id'=>'integer',
            // 'education_id'=>'integer',
            // 'department_id'=>'integer',
            // 'school'=>'string|max:255',
            // 'country_id'=>'integer',
            // 'city_id'=>'integer',
            // 'area'=>'string|max:150',
            // 'father_mobile'=>'string|max:11',
            // 'address'=>'string|max:255',
            
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      $location=geoip()->getLocation(\Request::ip());
        return User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone'=>$data['phone'],
            'active'=>1,
            'email_token' => base64_encode($data['email']),
            'account_level_id'=>($data['type']=="teacher"?2:3),
        ]);
    }


    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    // public function register(Request $request)
    // {
    //     $this->validator($request->all())->validate();
    //     event(new Registered($user = $this->create($request->all())));
    //     //dispatch(new SendVerificationEmail($user));
    //     $email = new EmailVerification($user);
    //     Mail::to($user->email)->send($email);
    //     return view('auth.verification');
    // }
    public function register(Request $request)
    {
        // dd($request->type);
        $validator = $this->validator($request->except(['_token','confirm','code']));
        // if ($validator->fails()) {
        //     if($request->ajax()){
        //         return json_encode(['type'=>'error','message'=>$validator->errors()->first(),'data'=>$validator->errors()]);
        //     }
        // }
        $validator->validate();
        $data=$request->except(['_token','confirm','code']);
        
        $data['mobile_phone']=$data['phone'];
        $data['ms_username']=$data['phone'].'@'.Setting::getIfExists('ms_domain','onlineacademia.com');
        $data['approved_profile']=-1;
        $data['active']=-1;

        $profile=null;

        DB::beginTransaction();
        
        try {
            $user = $this->create($data);
            $data['user_id']=$user->id;
            // if($request->get('acc_level_id')==2){
            $profile=  Profile::create($data);
           
            if($request->hasFile('img_user')){
                
                $image=$request->file('img_user');
                $imageobj=new MediaFile(['model'=>User::class,'id'=>$user->id,'tag'=>'img_user']);
                $imageobj->upload($image);
            }
                
            DB::commit();
        } catch(\Exception $th) {
            DB::rollback();
            if($profile)$profile->delete();
            if($request->ajax()){
                return json_encode(['type'=>'error','message'=>$th->getMessage()]);
            }
            //die($th->getMessage());
             return redirect()->back()->withErrors(['backend'=>$th->getMessage()])->withInput($data);
        }
        
        event(new Registered($user));

        try{
            
        $email = new EmailVerification($user);

        Mail::to($user->email)->send($email);
        }catch(\Exception $ex){
                
        }
        if($request->ajax()){
            return json_encode(['type'=>'success']);
        }
        return redirect('/'.app()->getLocale().'/register-confirm');
    }
    
    public function registerConfirm(){
        return view('auth.verification');
    }
    
    public function redirectToRegister(){
        return redirect('/'.app()->getLocale().'/register/teacher');
    }
    public function showRegistrationForm(){
        $type=request()->get('type');
        // dd($type);
        return view('auth.register',compact('type'));
    }
    public function showRegistrationByType($type){
        //$type=request()->get('type');
        // dd($type);
        return view('auth.register',compact('type'));
    }
    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
      $user = User::where('email_token',$token)->first();
      $user->verified = 1;

      if($user->save()){
          return redirect('/'.app()->getLocale().'/email-verified'); //view('auth.emailconfirm',['user'=>$user]);
      }

    }
    public function redirectToProvider($next='/'){
           // session()->set('req',$requset);
           return Socialite::driver('facebook')->redirect();
    }

    // public function handleProviderCallback(){
    //     $user=Socialite::driver('facebook')->user();
    //     $data=['name'=>$user->name,'email'=>$user->email,'password'=>$user->token,'phone'=>(isset($user->phone)?$user->phone:'')];
    //     $userDB=User::where('email',$user->email)->first();

    //     if(!is_null($userDB)){
    //         Auth::login($userDB);
    //     }else{
    //     $location=geoip()->getLocation(\Request::ip());
    //     $data['country']=$location['country'];
    //     $data['city']=$location['city'];
    //     Auth::login($this->create($data));
    //     }
    //         return redirect($this->redirectTo);
    // }

    // public function redirectToProviderTwitter($next='/'){
    //     // session()->set('req',$requset);
    //     return Socialite::driver('twitter')->redirect();
    // }

    // public function handleProviderCallbackTwitter(){
    //     $user=Socialite::driver('twitter')->user();
    //     $data=['name'=>$user->name,'email'=>$user->email,'password'=>$user->token,'phone'=>(isset($user->phone)?$user->phone:'')];
    //     $userDB=User::where('email',$user->email)->first();

    //     if(!is_null($userDB)){
    //         Auth::login($userDB);
    //     }else{
    //     $location=geoip()->getLocation(\Request::ip());
    //     $data['country']=$location['country'];
    //     $data['city']=$location['city'];
    //     Auth::login($this->create($data));
    //     }

    //     /*if(session()->has('req')){
    //         $request=session()->get('req');
    //         session()->forget('req');
    //         return redirect($request);
    //     }else{*/
    //         return redirect($this->redirectTo);
    //     // }

    // }

}
