<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSrr extends Model
{
    public function transaction(){
    	return $this->hasMany('App\StoreTransaction');
    }

    public function recipient(){
    	return $this->beLongsTo('App\StoreRecipient','recipient_id');
    }
    
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
