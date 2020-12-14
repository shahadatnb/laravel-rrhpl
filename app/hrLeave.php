<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hrLeave extends Model
{
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
    public function cuser(){
    	return $this->hasOne('App\User','id','cancel_user_id');
    }
}
