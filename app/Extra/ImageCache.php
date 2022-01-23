<?php
namespace App\Extra;
use App\Models\MediaFile;
use Image;
use File;

trait ImageCache
{
    //"Cache-Control", "public,max-age=2592000" .


    var $cachTime = 0; //60*60*24*10;

    public function ImageUrl($size = "original", $mode = "scale", $model_tag = "main", $index = "last") {


        $thumb = "120x120";
        $medium = "400x400";
        $large = "800x800";

        $width = 0;
        $height = 0;

        switch (strtolower($size)) {
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
                if (strpos($size, "x") === false)
                    return "";

                $sizeParams = explode('x', $size);

                if (count($sizeParams) < 2)
                    return "";
                if (is_numeric ($sizeParams[0])) $width = $sizeParams[0];
                if (is_numeric ($sizeParams[1])) $height = $sizeParams[1];

                break;
        }
        //if($height*$width==0) return null;

        $imgs = MediaFile::where('model_name', self::class)->where('model_attribute', $model_tag)->where('model_id', $this->id)->get();

        //echo self::class;
        //dd($imgs);

        if (!$imgs) goto noImageHandler;
        $vIndex = 0;
        if (is_numeric($index)) {
            $vIndex = $index;
        } else if ($index == "last") {
            $vIndex = count($imgs) - 1;
        } else
        {
            $vIndex = 0;
        }

        if ($vIndex >= count($imgs)) goto noImageHandler;
        if (count($imgs) == 0) goto noImageHandler;
        $img = $imgs[$vIndex];

        $filePath = $img->name;

        if ($filePath == "") goto noImageHandler;

        $filePath = public_path('uploads/images/'.$filePath);
        //$filePath =str_replace("/","/" ,$filePath );
        //dd($filePath);
        if (!file_exists($filePath)) goto noImageHandler;

        imageHandler:

        $source = Image::make($filePath);


        if ($width * $height == 0) {
            //$reponse=$source->response('png');
            //return response()->download($filePath);
            //return $reponse;// $source->response('png');//->header("Cache-Control", "public,max-age=".$this->cachTime);
            return url('/uploads/images/'.$img->name);
        }

        $path = public_path('uploads/images/'.$mode.'/'.$size);
        File::isDirectory($path) or File::makeDirectory($path, 0755, true, true);

        $target;

        if ($mode == "crope") {
            if (!file_exists($path.'/'.$img->name)) {
                list($sWidth, $sHeight) = getimagesize($filePath);
                $scaleHeight = $height / $sHeight;
                $scaleWidth = $width / $sWidth;

                $scale = max($scaleHeight, $scaleWidth);

                $source->resize($sWidth*$scale, $sHeight*$scale);

                $source->crop($width, $height);
                //echo public_path('uploads/images/'.$mode.'/'.$size.'/'.$img->name);
                $source->save($path.'/'.$img->name);
            }

            //return  url('/uploads/images/'.$mode.'/'.$size.'/'.$img->name);
            // return $source->response()->header("Cache-Control", "public,max-age=".$this->cachTime);

        } else if ($mode == "scale") {
            if (!file_exists($path.'/'.$img->name)) {

                list($sWidth, $sHeight) = getimagesize($filePath);


                $scaleHeight = $height / $sHeight;
                $scaleWidth = $width / $sWidth;

                $scale = min($scaleHeight, $scaleWidth);

                $source->resize($sWidth*$scale, $sHeight*$scale);
                $source->save($path.'/'.$img->name);
            }
            //return  url('/uploads/images/'.$mode.'/'.$size.'/'.$img->name);
            //return $source->response()->header("Cache-Control", "public,max-age=".$this->cachTime);

        }


        //source.Save(ms, ImageFormat.Png);
        // return $source->response()->header("Cache-Control", "public,max-age=".$this->cachTime);
        return url('/uploads/images/'.$mode.'/'.$size.'/'.$img->name);



        noImageHandler:

        // if (System.IO.File.Exists(Server.MapPath("~/Content/imgs/no-image/" + model + "-"+model_tag+".png"))) {
        //     filePath = Server.MapPath("~/Content/imgs/no-image/" + model + "-" + model_tag + ".png");
        //     goto imageHandler;
        // }
        // if (System.IO.File.Exists(Server.MapPath("~/Content/imgs/no-image/any.png"))) {
        //     filePath = Server.MapPath("~/Content/imgs/no-image/any.png");
        //     goto imageHandler;
        // }

        return "";



    }

    public function ImageUrls($size = "original", $mode = "scale", $model_tag = "main", $index = 1) {
        $thumb = "120x120";
        $medium = "400x400";
        $large = "800x800";

        $width = 0;
        $height = 0;

        switch (strtolower($size)) {
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
                if (strpos($size, "x") === false)
                    return [];

                $sizeParams = explode('x', $size);

                if (count($sizeParams) < 2)
                    return [];
                if (is_numeric ($sizeParams[0])) $width = $sizeParams[0];
                if (is_numeric ($sizeParams[1])) $height = $sizeParams[1];

                break;
        }
        //if($height*$width==0) return null;

        $imgs = MediaFile::where('model_name', self::class)->where('model_attribute', $model_tag)->where('model_id', $this->id)->get();

        //echo self::class;
        //dd($imgs);

        if (!$imgs) goto noImageHandler;
        $vIndex = 0;
        if (is_numeric($index)) {
            $vIndex = $index;
        } else if ($index == "last") {
            $vIndex = count($imgs) - 1;
        } else if ($index == 1) {
            $vIndex = count($imgs);
        } else
        {
            $vIndex = 0;
        }

        if ($vIndex >= count($imgs)) goto noImageHandler;
        if (count($imgs) == 0) goto noImageHandler;
        // $img = $imgs[$vIndex];
        // $filePath = $img->name;
        $filePath = [];
        $img_urls = [];
        for ($i = 0; $i < count($imgs); $i++) {
            $img = $imgs[$i];
            //$filePath[$i] = $img->name;
            $filePath[] = public_path('uploads/images/'.$img->name);

            if ($filePath[$i] == "") goto noImageHandler;

            if (!file_exists($filePath[$i])) goto noImageHandler;

            imageHandler:

            
            if ($width * $height == 0) {
                $img_urls[] = url('/uploads/images/'.$img->name);
            } else {
                $path = public_path('uploads/images/'.$mode.'/'.$size);
                File::isDirectory($path) or File::makeDirectory($path, 0755, true, true);

                $target;

                if ($mode == "crope") {
                    if (!file_exists($path.'/'.$img->name)) {
                        list($sWidth, $sHeight) = getimagesize($filePath[$i]);
                        $scaleHeight = $height / $sHeight;
                        $scaleWidth = $width / $sWidth;
                        $scale = max($scaleHeight, $scaleWidth);
                        $source = Image::make($filePath[$i]);
                        $source->resize($sWidth*$scale, $sHeight*$scale);
                        $source->crop($width, $height);
                        $source->save($path.'/'.$img->name);
                    }

                } else if ($mode == "scale") {
                    if (!file_exists($path.'/'.$img->name)) {
                        list($sWidth, $sHeight) = getimagesize($filePath[$i]);
                        $scaleHeight = $height / $sHeight;
                        $scaleWidth = $width / $sWidth;
                        $scale = min($scaleHeight, $scaleWidth);
                        $source = Image::make($filePath[$i]);
                        $source->resize($sWidth*$scale, $sHeight*$scale);
                        $source->save($path.'/'.$img->name);
                    }
                }
                $img_urls[] = url('/uploads/images/'.$mode.'/'.$size.'/'.$img->name);
            }
        }
        //dd($img_url);
        //dd($filePath);
        //if ($filePath == "") goto noImageHandler;

        //$filePath = public_path('uploads/images/'.$filePath);

        //if (!file_exists($filePath)) goto noImageHandler;

        // imageHandler:

        // $source=Image::make($filePath);


        // if ($width * $height == 0)
        // {
        //     return url('/uploads/images/'.$img->name);
        // }

        //return  url('/uploads/images/'.$mode.'/'.$size.'/'.$filePath[$i]['name']);
        return $img_urls;
        noImageHandler:

        return [];



    }
}