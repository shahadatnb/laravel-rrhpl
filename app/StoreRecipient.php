<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreRecipient extends Model
{
    public function StoreTransaction(){
    	return $this->beLongsToMany('App\StoreTransaction');
    }
}
