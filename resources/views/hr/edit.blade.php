@extends('layouts.master')
@section('title','Employee Edit')
@section('stylesheet')
	{!! Html::style('public/css/select2.min.css') !!}
  {!! Html::style('public/css/bootstrap-datepicker3.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::model($employee,array('route'=>['employee.update',$employee->id],'method'=>'PUT', 'files' => true )) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('name','Name') }}
             {{ Form::text('name',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('joining_date','Joining Date') }}
             <div class="input-group date" id="joining_date" data-provide="datepicker">
                {{ Form::date('joining_date',null,array('class'=>'form-control')) }}
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('designation_id','Designation') }}
             {{ Form::select('designation_id',$desig, null, ['class'=>'form-control select2','required'=>'','placeholder' => 'Designation']) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('department_id','Department') }}
             {{ Form::select('department_id',$dept, null, ['class'=>'form-control select2','required'=>'','placeholder' => 'Department']) }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('statingSalary','Stating Salary') }}
             {{ Form::number('statingSalary',null,array('class'=>'form-control','required'=>'','step'=>'any')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('currentSalary','Present Salary') }}
             {{ Form::number('currentSalary',null,array('class'=>'form-control','required'=>'','step'=>'any')) }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('fname','Father Name') }}
             {{ Form::text('fname',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('mname','Mother name') }}
             {{ Form::text('mname',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('dob','Date Of Birth') }}
             <div class="input-group date" id="dob" data-provide="datepicker">
                {{ Form::date('dob',null,array('class'=>'form-control')) }}
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('blood_group','Blood Group') }}
             {{ Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-',
                                              'B+' => 'B+', 'B-' => 'B-',
                                              'O+' => 'O+', 'O-' => 'O-',
                                              'AB+' => 'AB+', 'AB-' => 'AB-',
                                              'U' => 'Unknown'
                                              ], null, ['class'=>'form-control','required'=>'','placeholder' => 'Blood Group']) }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            {{ Form::label('pre_address','Present Address') }}
            {{ Form::textarea('pre_address',null,array('class'=>'form-control','rows'=>'3')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {{ Form::label('par_address','Parmanent Address') }}
            {{ Form::textarea('par_address',null,array('class'=>'form-control','rows'=>'3')) }}
          </div>
        </div>
      </div>      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('post','Post Office') }}
             {{ Form::text('post',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('ps','Police Station') }}
             {{ Form::text('ps',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
      </div>      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('nid','National ID') }}
             {{ Form::text('nid',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
             {{ Form::label('mobile','Mobile No') }}
             {{ Form::text('mobile',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
          </div>
        </div>
      </div>
    	<div class="row">
    		<div class="col-md-6">
    			<div class="form-group">
      			   {{ Form::label('photo','Photo') }}
              {{ Form::file('photo',null,array('class'=>'form-control','maxlenth'=>'255')) }}
    			</div>
          <img width="80" height="80" src="{{ URL::to('/').'/public/upload/employee/'.$employee->photo }}" alt="">
    		</div>
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                 {{ Form::label('sex','Sex') }}
                 {{ Form::select('sex',['Male' => 'Male', 'Female' => 'Female', 'Others' => 'Others'], null, ['class'=>'form-control select2','required'=>'','placeholder' => 'Sex']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> <br>
                 {{ Form::submit('Update',array('class'=>'btn btn-success')) }}            
              </div>
            </div>
          </div>
    		</div>
    	</div>
    {!! Form::close() !!}
  </div>

@endsection

@section('scripts')
	{!! Html::script('public/js/select2.min.js') !!}
  {!! Html::script('public/js/bootstrap-datepicker.min.js') !!}
  <script>
    $('.select2').select2();
    $('#joining_date').datepicker({
        format: 'yyyy-mm-dd',
        //startDate: '-3d'
    });
    $('#dob').datepicker({
        format: 'yyyy-mm-dd',
        //startDate: '-3d'
    });
  </script>
@endsection