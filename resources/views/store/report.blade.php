@extends('layouts.master')
@section('title','Store Report')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
  {!! Html::style('public/css/select2.min.css') !!}
	{!! Html::style('public/css/bootstrap-datepicker3.min.css') !!}
@endsection
@section('content')
<div class="bs-example">
    {!! Form::model($report,array('route'=>'store.report','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('from_date','From Date') }}
                <div class="input-group date" id="from_date" data-provide="datepicker">
                  {{ Form::text('from_date',null,array('class'=>'form-control')) }}
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
                  {{ Form::text('to_date',null,array('class'=>'form-control')) }}
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
    		</div>
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('item','Item Name') }}
                {{ Form::select('item',$items,null,['class'=>'form-control select2']) }}
              </div>
            </div>
            <div class="col-md-6"><br>{{ Form::submit('Set',array('class'=>'btn btn-success')) }}
			<a class="btn btn-default" target="_blank" href="{{ route('store.report.view','item_ledger')}}">Item Ledger</a></div>
          </div>        
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
          <tr>
            <td><a target="_blank" href="{{ route('store.report.view','item_ledger')}}">Item Ledger</a></td>
          </tr>
          <tr>
            <td><a target="_blank" href="{{ route('store.report.view','unposted_bill')}}">Unposted Bill</a></td>
          </tr>
          <tr>
            <td><a href="{{ route('store.updatestock')}}">Update Stock</a></td>
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
        format: 'yyyy-mm-dd',
        //startDate: '-3d'
    });
    $('#to_date').datepicker({
        format: 'yyyy-mm-dd',
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