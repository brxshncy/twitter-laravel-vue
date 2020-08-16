<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded =[];

    public function users(){
        return $this->belongsTo(TwitterUser::class,'user_id');
    }
}
