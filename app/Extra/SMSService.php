<?php

namespace App\Extra;

class SMSService 
{
   protected $sender="";
   protected $username="";
   protected $password="";
   protected $sendUrl="https://smssmartegypt.com/sms/api/?username={@username}&password={@password}&sendername={@sender}&message={@message}&mobiles={@mobiles}";
   protected $balanceUrl="https://smssmartegypt.com/sms/api/getBalance?username={@username}&password={@password}";
   
    static function send($message,$mobiles){
        $strMobiles="";
        if(is_array($mobiles)){
            $strMobiles=implode(',',$mobiles);
        }else{
            $strMobiles=$mobiles;
        }
        $obj= new self();
        $url=$obj->sendUrl;
        $url=str_replace('{@username}',$obj->username,$url);
        $url=str_replace('{@password}',$obj->password,$url);
        $url=str_replace('{@sender}',$obj->sender,$url);
        $url=str_replace('{@mobiles}',$strMobiles,$url);
        $url=str_replace('{@message}',urlencode($message),$url);

        return json_decode(@file_get_contents($url));
    }
    
}
