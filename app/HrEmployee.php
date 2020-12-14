<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    public function designation(){
    	return $this->hasOne('App\HrDesignation','id','designation_id');
    }
    
    public function department(){
    	return $this->hasOne('App\HrDepartment','id','department_id');
    }

    public function Leave(){
		$sd=date('Y').'-01-01';
    	$ed=date('Y').'-12-31';
    	return $this->hasMany('App\hrLeave','employee_id','id')->where('cancel',0)->whereBetween('leaveFrom', array($sd, $ed));//
    }
}
