@extends('layouts.master')
@section('title','Employee')
@section('stylesheet')
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'employee.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-6">
    			<div class="form-group">
      			 {{ Form::label('name','Name') }}
					   {{ Form::text('name',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
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
             {{ Form::label('designation_id','Designation') }}
             {{ Form::select('designation_id',$desig, null, ['class'=>'form-control select2','required'=>'','placeholder' => 'Designation']) }}
          </div>
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
                 {{ Form::submit('Create',array('class'=>'btn btn-success')) }}             
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
	<script>
		$('.select2').select2();
	</script>
@endsection