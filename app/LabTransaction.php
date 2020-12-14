<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTransaction extends Model
{
    public function labItem(){
    	return $this->beLongsTo('App\LabItem','Item_id');
    }
}
