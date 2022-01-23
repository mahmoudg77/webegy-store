<?php

namespace App\Extra;

trait APIHelper{
    
    public static function success($data=null,$message="",$length=1,$total=1){
        $res = [];
        $res['isSuccess']=true;
        $res['code']=200;
        $res['message']=$message;
        $res['length']=$length;//(is_array($data)?count($data):1);
        $res['total']=$total;
        $res['data']=$data;
        return response()->json($res,200);
    }
    public static function error($message,$code,$data=null){
        $res = [];
        $res['isSuccess']=false;
        $res['code']=$code;
        $res['message']=$message;
        $res['length']=0;
        $res['total']=0;
        $res['data']=$data;
       
        return response()->json($res,$code);
    }
}