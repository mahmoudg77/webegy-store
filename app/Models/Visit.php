<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Visit extends Model
{
    protected $fillable=['client_ip','client_country','client_city','model_name','model_id'];

    public function RelatedObject()
    {
        return $this->belongsTo($this->model_name,'model_id',"id");

    }
    public static function log($model,$id){
        //$location=geoip()->getLocation(\Request::ip());
       // Next get the name of the useragent yes seperately and for good reason
    $user_agent=\Request::header('User-Agent');
    $bname="social";
    if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$user_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$user_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$user_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$user_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    //echo $bname;
       
       if($bname=="social") return;
        $result=@file_get_contents("http://www.geoplugin.net/json.gp?ip=".\Request::ip());
        //dd($result);
        $location = @json_decode($result);    
        $obj=new Visit();
        if($location){
        $obj->country=$location->geoplugin_countryName;
        $obj->city=$location->geoplugin_city;
        $obj->region=$location->geoplugin_region;
        $obj->country_code=$location->geoplugin_countryCode;
        
        $obj->longitude=$location->geoplugin_longitude;
        $obj->latitude=$location->geoplugin_latitude;
        }
        //$obj->agent=\Request::header('User-Agent');
        $obj->client_ip=\Request::ip();
        //$obj->client_country=$location['country'];
        //$obj->client_city=$location['city'];
        $obj->model_name=$model;
        $obj->model_id=$id;
        $obj->save();

    }
}
