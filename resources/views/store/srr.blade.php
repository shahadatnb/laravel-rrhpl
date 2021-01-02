@extends('layouts.master')
@section('stylesheet')
  {!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
  {!! Html::style('public/css/parsley.css') !!}
  {!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('title') 
<div class="row">
<div class="col-md-4">{{ trans('language.srr') }} :: 
@if($srr->post==0)
  <span class="label label-warning">Unposted</span>
@else
  <span class="label label-success">Posted</span>
@endif
<br>{{ trans('language.srr') }} No - {{ $srr->id }}
</div>
<div class="col-md-4">
  Bill Date: {{ $srr->created_at->format('d/m/Y h:i:s A') }} <br>Updated Date: {{ $srr->updated_at->format('d/m/Y h:i:s A') }}
</div>
<div class="col-md-4">
{!! Form::open(array('route'=>'store.srr.find')) !!}
  <div class="input-group">
    <span class="input-group-btn"><?php $back=$srr->id; $ford=$srr->id;  ?>
      <a href="{{ route('store.srr.edit', --$back) }}" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></a>
    </span>
    <input type="text" name="bill_id" class="form-control" value="{{ $srr->id }}">
    <span class="input-group-btn">
      <a href="{{ route('store.srr.edit',++$ford) }}" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></a>
    </span>
    <span class="input-group-btn">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
    </span>
  </div><!-- /input-group -->
  {!! Form::close() !!}
</div>
</div>
@endsection

@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'store.srr.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-6">
    			<div class="form-group">
      				{{ Form::label('item','Item Name') }}
					 <select name="item" id="" class="form-control select2">
            <option></option>
              @foreach($items as $item)
              <option value="{{ $item->id }}">{{ $item->Item }}</option>
              @endforeach
            </select>
          {{ Form::hidden('id', $srr->id) }}
          {{ Form::hidden('bill_status', $srr->post) }}
    			</div>
    		</div>
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                {{ Form::label('qty','Quantity') }}
                {{ Form::number('qty',null,array('class'=>'form-control','required'=>'','step'=>'any')) }}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('Add',' ') }}
                {{ Form::submit('Add',array('class'=>'form-control btn btn-success')) }}
              </div> 
            </div>
          </div>    			
    		</div>
    	</div>
    {!! Form::close() !!}
    {!! Form::model($srr,array('route'=>'store.srr.billPost','data-parsley-validate'=>'')) !!} 
    	<div class="row">
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-8">
            {{ Form::label('recipient_id', trans('language.recipient') ) }}
            {{ Form::select('recipient_id',$recipients,null,['class'=>'form-control select2', 'required'=>'']) }}
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <br>
                <a href="{{ route('store.recipient') }}" class="btn btn-primary">Add {{ trans('language.recipient') }}</a>
              </div>               
            </div>
          </div>
    		</div>
    		<div class="col-md-6">
      			<div class="form-group">
              {{ Form::label('remark','Remark') }}
              {{ Form::text('remark',null,array('class'=>'form-control')) }}
            </div>
            {{ Form::hidden('id', $srr->id) }}
    		</div>
    	</div>
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group">
            <a href="{{ URL::to('store/srr/create')}}" class="btn btn-default"><span class="glyphicon glyphicon-file"> New</a>
          </div>
          <div class="btn-group">
            <button type="submit" name="bill_post" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"> Post</button>
            <button type="button" class="btn btn-default">View</button>
            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"> Print</button>
          </div>

        </div>
      </div>
    {!! Form::close() !!}
  </div>

  <div class="box">
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Unit</th>
          <th>Price</th>
          <th>Sub Total</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @php $total=0 @endphp
        @foreach($transaction as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->storeItem->Item }}</td>
          <td>{{ $item->qty }}</td>
          <td>{{ $item->price }}</td>
          <td>{{ $sub_total = $item->qty*$item->price }}@php $total  +=$sub_total @endphp</td>
          <td><a href="{{ route('store.srr.remove',$item->id) }}"><span class="glyphicon glyphicon-remove"></a></td>
        </tr>
        @endforeach
        </tbody>
      </table>
      <table class="table table-bordered">
        <tr>
          <td>Total:</td>
          <td>{{ $total }}</td>
        </tr>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection

@section('print')
@include('partials.report_header')
<div class="row">
  <div class="col-md-6 col-sm-3"><b>{{ trans('language.srr') }} No:</b> @if($srr->post==1){{ $srr->id }} @else Druft @endif </div>
  <div class="col-md-6 col-sm-4"><b>Remark:</b> {{ $srr->remark }}</div>
  <div class="col-md-6 col-sm-5 text-right"><b>Date Time:</b> {{ $srr->updated_at->format('d/m/Y h:i:s A') }}</div>
</div>
<p><b>Recipient:</b> @if($srr->post==1){{ $srr->recipient->name }}@endif</p>
<table class="table table-bordered table-striped">
  <thead>
  <tr>
    <th>ID</th>
    <th>Item Name</th>
    <th>Unit</th>
    <th>Price</th>
    <th>Subtotal</th>
  </tr>
  </thead>
  <tbody>
  @foreach($transaction as $item)
  <tr>
    <td>{{ $item->id }}</td>
    <td>{{ $item->storeItem->Item }}</td>
    <td>{{ $item->qty }}</td>
    <td>{{ $item->price }}</td>
    <td>{{ $item->price*$item->qty }}</td>
  </tr>
  @endforeach
  <tr>
    <td colspan="4" class="text-right">Total: </td>
    <td>{{ $total }}</td>
  </tr>
  </tbody>
</table>
@endsection

@section('scripts')
	<!-- DataTables -->
	{!! Html::script('public/plugins/datatables/jquery.dataTables.min.js') !!}
	{!! Html::script('public/plugins/datatables/dataTables.bootstrap.min.js') !!}
	{!! Html::script('public/js/parsley.min.js') !!}
	{!! Html::script('public/js/select2.min.js') !!}
	<script>
		$(".select2").select2({
        placeholder: "",
        allowClear: true
    });
		$(function () {
	    //$("#example1").DataTable();
	    $('#example2').DataTable({
	      "paging": false,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": false,
	      "autoWidth": false
	    });
	  });
	</script>
@endsection
