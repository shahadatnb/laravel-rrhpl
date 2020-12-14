<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HrEmployee;
use App\hrLeave;
use Auth;
use Session;
use DateTime;

class hrLeaveController extends Controller
{	
	private $leaveType = array(
		'cl'=> array('name' =>'Casual Leave','tl'=>'15' ),
		'lwp'=>array('name'=> 'Leave Without Pay','tl'=>'0'),
		'ml'=>array('name'=> 'Maternity Leave','tl'=>'0'),
		'sl'=>array('name'=> 'Sick Leave','tl'=>'0'),
	);

    public function leave($id){
    	$emp=HrEmployee::find($id);
    	$leaveType = $this->leaveType;
    	if($emp->sex != 'Female' ){
    		$leaveType = array_except($leaveType, ['ml']);
    	}

    	foreach ($leaveType as $key => $value) {
    		$leaveType[$key]['lc'] = $emp->Leave->where('leaveType',$key)->sum('le');
    	}
    	

    	//dd($leaveType);

    	$leave = hrLeave::where('employee_id',$emp->id)->latest()->get();
    	return view('hr.leave.leave',compact('emp','leaveType','leave'));
    }

    public function leaveReg(Request $request, $id){
    	$this->validate($request, array(
            'leaveType'=>'required',
            'leaveFrom'=>'required|date',
            'leaveTo'=>'required|date'
            ));

    	$emp=HrEmployee::find($id); //employee_id 	leaveFrom 	leaveTo 	leaveType 	user_id

    	$date = str_replace('/', '-', $request->leaveFrom);
    	$leaveFrom = date('Y-m-d', strtotime($date));
    	$date = str_replace('/', '-', $request->leaveTo);
    	$leaveTo = date('Y-m-d', strtotime($date));

    	$datetime1 = new DateTime($leaveFrom);
		$datetime2 = new DateTime($leaveTo);
		$interval = $datetime1->diff($datetime2);
		$leaveCount = $interval->format('%a');
        $leaveCount ++;
		

    	$data = new hrLeave;
        $data->employee_id=$id;
        $data->leaveFrom=$request->leaveFrom;
        $data->leaveTo=$request->leaveTo;
        $data->leaveType=$request->leaveType;
        $data->le=$leaveCount;
        $data->user_id= Auth::user()->id;
        $data->save();

        Session::flash('success','Successfully Save');
        return redirect()->back(); 
    }

    public function leaveCancel($id){
    	$data = hrLeave::find($id);
        $data->cancel= 1;
        $data->cancel_user_id= Auth::user()->id;
        $data->save();
    	Session::flash('success','Successfully Save');
        return redirect()->back(); 
    }
}
