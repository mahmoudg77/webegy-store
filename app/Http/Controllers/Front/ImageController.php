<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\MediaFile;
use Image;
class ImageController extends Controller
{   
        //"Cache-Control", "public,max-age=2592000" . 
       
       
        var $cachTime =60*60*24*10;
        
        public function item($model, $model_id, $mode="scale", $size = "original", $model_tag = "main", $index = "0")
        {

           
            $thumb = "120x120";
            $medium = "400x400";
            $large = "800x800";

            $width = 0;
            $height = 0;

            switch (strtolower($size))
            {
                case "original":
                    $width = 0;
                    $height = 0;
                    break;
                case "large":
                    $width = 800;
                    $height = 800;
                    break;
                case "meduim":
                    $width = 400;
                    $height = 400;
                    break;
                case "thumb":
                    $width = 120;
                    $height = 120;
                    break;
                case "thumb":
                    $width = 0;
                    $height = 0;
                    break;
                default:
                    if (strpos($size,"x")===false)
                        return null;

                    $sizeParams =explode('x',$size);
                     
                    if (count($sizeParams) < 2)
                        return null;
                    if (is_numeric ($sizeParams[0])) $width=$sizeParams[0];
                    if (is_numeric ($sizeParams[1])) $height=$sizeParams[1];
                        
                    break;
            }
            //if($height*$width==0) return null;
                
              $imgs = MediaFile::where('model_name' ,'App\\Models\\'.$model)->where('model_attribute',$model_tag)->where('model_id',$model_id)->get();

             //dd($imgs);

                if (!$imgs) goto noImageHandler;
                $vIndex = 0;
                if (is_numeric($index))
                {
                    $vIndex=$index;
                }else if ($index == "last")
                {
                    $vIndex = count($imgs) - 1;
                }
                else
                {
                    $vIndex = 0;
                }

                if ($vIndex >= count($imgs)) goto noImageHandler;
                if (count($imgs) == 0) goto noImageHandler;
                $img = $imgs[$vIndex];
                  
                $filePath = $img->name;
                    
                if ($filePath == "") goto noImageHandler;

                $filePath = public_path('uploads/images/'.$filePath);

                if (!file_exists($filePath)) goto noImageHandler;
                
                imageHandler:

                $source=Image::make($filePath);

                if ($width * $height == 0)
                {
                    //$source->resize($width, $height);

                    return $source->response()->header("Cache-Control", "public,max-age=".$this->cachTime);
                    
                }
                $target;
                if($mode == "crope")
                {

                    list($sWidth,$sHeight) = getimagesize($filePath);

                    
                    $scaleHeight = $height / $sHeight;
                    $scaleWidth = $width / $sWidth;
        
                    $scale = max($scaleHeight, $scaleWidth);
        
                    $source->resize($sWidth*$scale, $sHeight*$scale);

                    $source->crop($width, $height);
                     
                     //$source->text(date('D, d M Y H:i:s',time()),10,10);
                         return $source->response() ->header("Cache-Control", "public,max-age=".$this->cachTime)
                                                    ->header("last-modified",date('D, d M Y H:i:s \G\M\T',time()) )
                                                    ->header("age",$this->cachTime)
                                                    ->header("cf-cache-status", "HIT");
                    
                }
                else if($mode == "scale")
                {
                    list($sWidth,$sHeight) = getimagesize($filePath);

                    
                    $scaleHeight = $height / $sHeight;
                    $scaleWidth = $width / $sWidth;
        
                    $scale = min($scaleHeight, $scaleWidth);
        
                    $source->resize($sWidth*$scale, $sHeight*$scale);
                    //$source->text(date('D, d M Y H:i:s',time()),10,10);
                        return $source->response() ->header("Cache-Control", "public,max-age=".$this->cachTime)
                                                    ->header("last-modified",date('D, d M Y H:i:s \G\M\T',time()) )
                                                    ->header("age",$this->cachTime)
                                                    ->header("cf-cache-status", "HIT");                    
                }

                
                    //source.Save(ms, ImageFormat.Png);
                    // Cache::put(request()->url,$source);
                    // $db=$source->response()->header("Cache-Control", "must-revalidate,max-age=".$this->cachTime);
                        return $source->response() ->header("Cache-Control", "public,max-age=".$this->cachTime)
                                                    ->header("last-modified",date('D, d M Y H:i:s \G\M\T',time()) )
                                                    ->header("age",$this->cachTime)
                                                    ->header("cf-cache-status", "HIT");                    
               
                     

            noImageHandler:

                // if (System.IO.File.Exists(Server.MapPath("~/Content/imgs/no-image/" + model + "-"+model_tag+".png"))) {
                //     filePath = Server.MapPath("~/Content/imgs/no-image/" + model + "-" + model_tag + ".png");
                //     goto imageHandler;
                // }
                // if (System.IO.File.Exists(Server.MapPath("~/Content/imgs/no-image/any.png"))) {
                //     filePath = Server.MapPath("~/Content/imgs/no-image/any.png");
                //     goto imageHandler;
                // }

                    return null;

            
        
    }
}