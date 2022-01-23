<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Extra\SMSService;

class VerifyMobile extends Model
{

    protected $table="sec_verify_mobile";
    protected $fillable=['phone','code','used'];

    function isUsed(){
        return $this->used;
    }
    function isExpired(){
        return $this->created_at<strtotime("-10 minutes");
    }

    static function isVerified($phone,$code){
        $row=self::where('phone',$phone)->where('code',$code)->where('used',0)->where('created_at','>=',strtotime('-10 minutes'))->first();
        if($row){
            $row->used=1;
            $row->update();
            return true;
        }
        return false;
    }

    static function sendCode($phone){
        $code = rand(100000, 999999);
        if(self::create(['phone'=>$phone,'code'=>$code]))
        return SMSService::send("Your Access Code is ".$code,$phone);
    }

}
