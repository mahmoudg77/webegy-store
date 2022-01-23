<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Extra\ImageCache;
use App\Mail\EmailVerification;
use Mail;
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use ImageCache;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','phone','email_token','active','account_level_id'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_token',
    ];

    public function AccountLevel()
    {
      return $this->belongsTo('App\Models\AccountLevel');
    }
    public function hasRoles($value)
    {
      return $this->AccountLevel?$this->AccountLevel->hasRoles($value):false;
    }
    public function name()
    {
      return $this->name;
    }
    public function allow($ctrl,$action)
    {
      return ($this->AccountLevel)?$this->AccountLevel->allow($ctrl,$action):false;
    }
    public function hasRole($role)
    {
        return $this->AccountLevel?$this->AccountLevel->hasRole($role):false;
    }
    public function Posts()
    {
        return $this->hasMany('App\Models\Post','created_by','id');
    }
    
    public function MediaFiles()
    {
      return $this->hasMany("App\Models\MediaFile","model_id","id")->where('model_name',self::class);
    }
    
    public function mainImage($size='original',$mode='scale'){
      return $this->ImageUrl($size ,$mode );
    }

    public function Profile(){
      return $this->hasOne('App\Models\Profile');
    }

    public function getPhotoAttribute()
    {
        $arr=[];
        $arr['sm']= $this->profileImage('100x100','crope');
        $arr['md']= $this->profileImage('400x400','crope');
        $arr['lg']= $this->profileImage('600x600','crope');
        $obj=json_encode($arr);
        return json_decode($obj);
    }
        public function sendEmailVerificationNotification(){
        
        $this->email_token=sha1(time());
        $this->save();
        $email = new EmailVerification($this);

        Mail::to($this->email)->send($email);
        return true;
        
    }

}
