@extends('layouts.master')
@section('title','Store Report')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
  {!! Html::style('public/css/select2.min.css') !!}
	{!! Html::style('public/css/bootstrap-datepicker3.min.css') !!}
@endsection
@section('content')
@php
  $from_date = Session::get('from_date');
  $to_date = Session::get('to_date');
  //$from_date = date_format(Session::get('from_date'), 'd/m/Y');
  //$to_date = date_format(Session::get('to_date'), 'd/m/Y');
@endphp
<div class="bs-example">
    {!! Form::open(array('route'=>'store.report','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('from_date','From Date') }}
                <div class="input-group date" id="from_date" data-provide="datepicker">
                  <input type="text" value="{{ $from_date }}" name="from_date" class="form-control">
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('to_date','To Date') }}
                <div class="input-group date" id="to_date" data-provide="datepicker">
                  <input type="text" value="{{ $to_date }}" name="to_date" class="form-control">
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
              </div>
            </div>
          </div>
    		</div>
    		<div class="col-md-6"><br>
    			{{ Form::submit('Set',array('class'=>'btn btn-success')) }}
    		</div>
    	</div>
    {!! Form::close() !!}
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Item</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Report Name</th>
        </tr>
        </thead>
        <tbody>
          <tr>
            <td><a target="_blank" href="{{ route('store.report.view','cureent_stock')}}">Current Stock</a></td>
          </tr>
          <tr>
            <td><a target="_blank" href="{{ route('store.report.view','mrr_period')}}">{{ trans('language.mrr') }} of a Period</a></td>
          </tr>
          <tr>
            <td><a target="_blank" href="{{ route('store.report.view','srr_period')}}">{{ trans('language.srr') }} of a Period</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection

@section('scripts')
	{!! Html::script('public/js/parsley.min.js') !!}
  {!! Html::script('public/js/select2.min.js') !!}
	{!! Html::script('public/js/bootstrap-datepicker.min.js') !!}
	<script>
		$('.select2').select2();
    $('#from_date').datepicker({
        format: 'dd/mm/yyyy',
        //startDate: '-3d'
    });
    $('#to_date').datepicker({
        format: 'dd/mm/yyyy',
        //startDate: '-3d'
    });
    $("#from_date").on("dp.change", function (e) {
            $('#to_date').data("datepicker").minDate(e.date);
    });
    $("#to_date").on("dp.change", function (e) {
        $('#from_date').data("datepicker").maxDate(e.date);
    });
	</script>
@endsection