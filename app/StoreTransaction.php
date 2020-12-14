<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreTransaction extends Model
{
    public function mrr(){
    	return $this->beLongsTo('App\StoreMrr','mrr_id');
    }

    public function srr(){
    	return $this->beLongsTo('App\StoreSrr','srr_id');
    }

    public function storeItem(){
    	return $this->beLongsTo('App\StoreItem','Item_id');
    }

    public function StoreRecipient(){
    	return $this->belongsToMany('App\StoreRecipient','store_srrs','id','recipient_id');
    }
}
