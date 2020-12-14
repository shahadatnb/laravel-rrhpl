<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $table = 'store_items';

    public function StoreCategory(){
    	return $this->beLongsTo('App\StoreCategory','category_id');
    }

    public function srrInfo(){
    	return $this->belongsToMany('App\StoreMrr','store_transactions','item_id','mrr_id')->latest()->take(1);
    }
}
