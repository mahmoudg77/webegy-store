<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    public function install(){
        $this->installed=true;
       return $this->save();
    }
    public function uninstall(){
        $this->installed=false;
       return $this->save();
    }
    public function scopeCurrent($query){
        $query->where('installed',1);
    }
    
}
