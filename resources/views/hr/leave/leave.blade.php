@extends('layouts.master')
@section('title','Employee Register')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
  {!! Html::style('public/css/bootstrap-datepicker3.min.css') !!}
@endsection
@section('content')

<div class="row">
  <div class="col-md-12">
    <b>Name:</b> {{ $emp->name }} <b>Designation:</b> {{ $emp->designation->designation }} <br>
    <table class="table table-bordered table-striped">
      <tr>
        <th>Leave Type</th>
        <th>Consume</th>
        <th>Left</th>
      </tr>
    @foreach($leaveType as $data)
    <tr>
      <td>{{$data['name']}}</td>
      <td>{{$data['lc']}}</td>
      <td>
        @if($data['tl'] != 0)
          {{$data['tl']-$data['lc']}}
        @endif
      </td>
    </tr>
    @endforeach
    </table>
  
    {!! Form::model($emp,array('route'=>['leave.reg',$emp->id],'method'=>'PUT')) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
             {{ Form::label('leaveType','Leave Type') }}
              <select name="leaveType" id="leaveType" class="form-control">
                @foreach($leaveType as $key => $value)
                  <option value="{{$key}}">{{$value['name']}}</option>
                @endforeach
              </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
             {{ Form::label('leaveFrom','Leave From') }}
             {{ Form::date('leaveFrom',null,array('class'=>'form-control')) }}
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
             {{ Form::label('leaveTo','Leave To') }}
             {{ Form::date('leaveTo',null,array('class'=>'form-control')) }}
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group"><br>
             {{ Form::submit('Submit',array('class'=>'btn btn-success')) }}
          </div>
        </div>
      </div>
    {!! Form::close() !!}
    <div class="row">
      <div class="col-md-12">
        <hr>
        <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Leave Type</th>
          <th>Leave From</th>
          <th>Leave To</th>
          <th>Posted By</th>
          <th>Cancel</th>
          <th>Note</th>
          <th>Cancel By</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leave as $data)
        <tr id="{{$data->id}}">
          <td>{{ array_get($leaveType,$data->leaveType)['name'] }}</td>
          <td>{{ prettyDate($data->leaveFrom) }}</td>
          <td>{{ prettyDate($data->leaveTo) }}</td>
          <td>{{ $data->user->name }}</td>
          <td>{{ $data->cancel }}</td>
          <td>{{ $data->cancel_note }}</td>
          <td>@if($data->cancel ==1){{ $data->cuser->name }} @endif</td>
          <td>
            <a class="btn btn-warning btn-xs" href="{{route('leave.cancel',$data->id)}}">C</a></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
      </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
	<!-- DataTables -->
  {!! Html::script('public/plugins/datatables/jquery.dataTables.min.js') !!}
  {!! Html::script('public/plugins/datatables/dataTables.bootstrap.min.js') !!}
  <script>
    $(function () {
          $("#example1").DataTable();
        });
  </script>
@endsection