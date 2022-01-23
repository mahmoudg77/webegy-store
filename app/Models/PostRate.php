<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PostRate extends Model
{


    protected $fillable = ['ip',
        'post_id',
        'rate',
        'created_at'];
    function Post() {
        return $this->belongsTo(\App\Models\Post::class);
    }
    public function getCreatedAtAttribute($date) {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}