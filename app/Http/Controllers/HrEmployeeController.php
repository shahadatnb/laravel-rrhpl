<?php

namespace App\Http\Controllers;
use App\HrEmployee;
use App\HrDesignation;
use App\HrDepartment;
use Auth;
use Session;

use Illuminate\Http\Request;

class HrEmployeeController extends Controller
{

    public function index()
    {
        $data = HrEmployee::all();
        return view('hr.index')->withData($data);
    }

    public function list()
    {
        $data = HrEmployee::where('status',1)->get();
        return view('hr.report.list')->withData($data);
    }


    public function create()
    {
        $desig = HrDesignation::all();
        $dept = HrDepartment::all();
        $desigs=array();
        foreach ($desig as $data) {
            $desigs[$data->id]= $data->designation;
        }
        $depts=array();
        foreach ($dept as $data) {
            $depts[$data->id]= $data->department;
        }
        return view('hr.create')->withDesig($desigs)->withDept($depts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name'=>'required|max:255',
            'designation_id'=>'required',
            'department_id'=>'required',
            'sex'=>'required'
            ));

        $data = new HrEmployee;
        $data->name=$request->name;
        $data->designation_id=$request->designation_id;
        $data->department_id=$request->department_id;
        $data->sex=$request->sex;
        $data->user_id= Auth::user()->id;
        $data->save();

        Session::flash('success','Successfully Save');
        return redirect()->route('employee.edit',$data->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emp=HrEmployee::find($id);
        $desig = HrDesignation::all();
        $dept = HrDepartment::all();
        //$recipient = StoreRecipient::where('publish',1)->get();
        $desigs=array();
        foreach ($desig as $data) {
            $desigs[$data->id]= $data->designation;
        }
        $depts=array();
        foreach ($dept as $data) {
            $depts[$data->id]= $data->department;
        }
        return view('hr.edit')->withEmployee($emp)->withDesig($desigs)->withDept($depts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'name'=>'required|max:255',
            'designation_id'=>'required',
            'department_id'=>'required',
            'sex'=>'required'
            ));

        $date = str_replace('/', '-', $request->joining_date);
        $joining_date = date('Y-m-d', strtotime($date));
        $date = str_replace('/', '-', $request->dob);
        $dob = date('Y-m-d', strtotime($date));

        $data=HrEmployee::find($id);

        $data->name=$request->name;
        $data->joining_date=$joining_date;
        $data->designation_id=$request->designation_id;
        $data->department_id=$request->department_id;
        $data->fname=$request->fname;
        $data->mname=$request->mname;
        $data->statingSalary=$request->statingSalary;
        $data->currentSalary=$request->currentSalary;
        $data->dob=$dob;
        $data->blood_group=$request->blood_group;
        $data->pre_address=$request->pre_address;
        $data->par_address=$request->par_address;
        $data->post=$request->post;
        $data->ps=$request->ps;
        $data->nid=$request->nid;
        $data->mobile=$request->mobile;
        $data->sex=$request->sex;
        $data->user_id= Auth::user()->id;
        $image = $request->file('photo');
        if ($image) {
            $upload = 'public/upload/employee';
            $filename = time() . '_' . $image->getClientOriginalName();
            $success = $image->move($upload, $filename);

            if ($success) {
                $data->photo = $filename;
                $data->save();
                Session::flash('success','Employee Name was Successfully Save');
            } else {
                Session::flash('success', "Image couldn't be uploaded.");
            }
        } else {
        $data->save();
        }
        Session::flash('success','Updated');
        //return redirect()->route('employee.edit',$id);
        return redirect()->route('employee.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
