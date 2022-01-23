<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;
class MediaFile extends Model
{
    protected $fillable=['name','model_name','model_id','model_attribute','size','medai_type'];
    public function __construct(array $attributes = [])
    {
        if(count($attributes)>0){
            $this->model_name=$attributes['model'];
            $this->model_id=$attributes['id'];
            $this->model_attribute=$attributes['tag'];
        }


        parent::__construct($attributes);
    }

    public function RelatedObject()
    {
      return $this->belongsTo($this->model_name,'model_id',"id");

    }
    public function upload($img)
    {
        $randName = md5(rand() * time());
        $randName = substr($randName, 0, 5);


        $this->name = $randName.'_'.$img->getClientOriginalName();
        $this->size=$img->getClientSize();
        $this->media_type=$img->getClientMimeType();

        $image_resize = Image::make($img->getRealPath());
        $image_resize->save(public_path('uploads/images/'.$this->name));

        if(substr($this->media_type,0,5)=="image/"){
            list($w_orig, $h_orig) = getimagesize($img->getRealPath());

            $scale_ratio = $w_orig / $h_orig;
            $w=300;
            $h=300;

            if (($w / $h) > $scale_ratio) {
                $w = $h * $scale_ratio;
            } else {
                $h = $w / $scale_ratio;
            }

            $image_resize->resize($w, $h);

            $image_resize->save(public_path('uploads/_thumbs/images/'.$this->name));
        }elseif(substr($this->media_type,0,5)=="video/"){

        }
        $this->save();
        return $this;
    }



}
