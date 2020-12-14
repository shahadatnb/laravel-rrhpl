@extends('layouts.master')
@section('stylesheet')
  {!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
  {!! Html::style('public/css/parsley.css') !!}
  {!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('title') 
<div class="row">
<div class="col-md-4">{{ trans('language.labmrr') }} :: 
@if($mrr->post==0)
  <span class="label label-warning">Unposted</span>
@else
  <span class="label label-success">Posted</span>
@endif
<br>{{ trans('language.labmrr') }} No - {{ $mrr->buy_id }}
</div>
<div class="col-md-4">
  Bill Date: {{ $mrr->created_at->format('d/m/Y h:i:s A') }} <br>Updated Date: {{ $mrr->updated_at->format('d/m/Y h:i:s A') }}
</div>
<div class="col-md-4">
{!! Form::open(array('route'=>'lab.mrr.find')) !!}
  <div class="input-group">
    <span class="input-group-btn"><?php $back=$mrr->buy_id; $ford=$mrr->buy_id;  ?>
      <a href="{{ route('lab.mrr.edit', --$back) }}" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></a>
    </span>
    <input type="text" name="bill_id" class="form-control" value="{{ $mrr->buy_id }}">
    <span class="input-group-btn">
      <a href="{{ route('lab.mrr.edit',++$ford) }}" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></a>
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
    {!! Form::open(array('route'=>'lab.mrr.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-4">
    			<div class="form-group">
      				{{ Form::label('item','Item Name') }}
					 <select name="item" id="" class="form-control select2">
              @foreach($items as $item)
              <option value="{{ $item->id }}">{{ $item->Item }}</option>
              @endforeach
            </select>
          {{ Form::hidden('id', $mrr->id) }}
          {{ Form::hidden('buy_id', $mrr->buy_id) }}
          {{ Form::hidden('bill_status', $mrr->post) }}
    			</div>
    		</div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('qty','Quantity') }}
            {{ Form::number('qty',null,array('class'=>'form-control','required'=>'','step'=>'any')) }}
          </div>
        </div>
    		<div class="col-md-3">
          <div class="form-group">
            {{ Form::label('expiryDate','Expiry Date') }}
            {{ Form::text('expiryDate',null,array('class'=>'form-control','required'=>'','step'=>'any','placeholder'=>'YYYY-MM-DD')) }}
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            {{ Form::label('Add',' ') }}
            {{ Form::submit('Add Item',array('class'=>'form-control btn btn-success')) }}
          </div> 
        </div>
    	</div>
    {!! Form::close() !!}
    {!! Form::open(array('route'=>'lab.mrr.billPost','data-parsley-validate'=>'')) !!} 
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group">
            <a href="{{ URL::to('lab/mrr/create')}}" class="btn btn-default"><span class="glyphicon glyphicon-file"> New</a>
          </div>
          <div class="btn-group">
            {{ Form::hidden('id', $mrr->id) }}
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
          <th>Quantity</th>
          <th>Expiry Date</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transaction as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->labItem->Item }}</td>
          <td>{{ $item->qty }}</td>
          <td>{{ $item->expiryDate }}</td>
          <td><a href="{{ route('lab.mrr.remove',$item->id) }}"><span class="glyphicon glyphicon-remove"></a></td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection

@section('scripts')
	<!-- DataTables -->
	{!! Html::script('public/plugins/datatables/jquery.dataTables.min.js') !!}
	{!! Html::script('public/plugins/datatables/dataTables.bootstrap.min.js') !!}
	{!! Html::script('public/js/parsley.min.js') !!}
	{!! Html::script('public/js/select2.min.js') !!}
	<script>
		$('.select2').select2();
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