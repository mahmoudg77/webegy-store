<?php

namespace App\Models;

use Illuminate\Http\UploadedFile ;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable=['name','size','model_name','model_id','model_attribute'];
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

    public function upload(UploadedFile $file)
    {
        $randName = md5(rand() * time());
        $randName = substr($randName, 0, 5);


        $this->name = $randName.'_'.$file->getClientOriginalName();
        $this->size=$file->getClientSize();
        $this->file_type=$file->getClientMimeType();



        //$extension = $file->getClientOriginalExtension();
        //$sha1 = sha1($file->getClientOriginalName());
        //$this->name = date('Y-m-d--h-i-s')."_".$sha1.".".$extension;
        $path = public_path('uploads/files/');
        $file->move($path, $this->name);


        //Storage::disk('local')->put('uploads/files/'.$this->name, $file, 'public');
        //Storage::put($this->name,$file);
        //$file->store("attach");


        $this->save();
        return $this;
    }
}
