<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreMrr extends Model
{
    public function transaction(){
    	return $this->hasMany('App\StoreTransaction');
    }

    public function supplier(){
    	return $this->beLongsTo('App\StoreItemSupplier','supplier_id');
    }

    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
