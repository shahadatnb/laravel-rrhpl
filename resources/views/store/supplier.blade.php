@extends('layouts.master')
@section('title','Store Supplier')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'store.supplier.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-5">{{ Form::text('name',null,array('class'=>'form-control','required'=>'','placeholder'=>'Supplier Name')) }}</div>
    		<div class="col-md-5">{{ Form::text('address',null,array('class'=>'form-control','placeholder'=>'Supplier Address')) }}</div>
    		<div class="col-md-2">{{ Form::submit('Create New Supplier',array('class'=>'btn btn-success')) }}</div>
    	</div>
    {!! Form::close() !!}
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Suppliers</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Supplier Name</th>
          <th>Address</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($suppliers as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->address }}</td>
          <td><a class="btn btn-danger btn-xs" href="{{ route('store.supplier.rm',$item->id)}}"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
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
	    $("#example1").DataTable();
	    /*$('#example2').DataTable({
	      "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false
	    });*/
	  });
	</script>
@endsection