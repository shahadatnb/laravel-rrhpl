@extends('layouts.master')
@section('title','Store Recipient')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'store.category.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-8">{{ Form::text('name',null,array('class'=>'form-control','required'=>'','placeholder'=>'Category Name')) }}</div>
    		<div class="col-md-4">{{ Form::submit('Create New Category',array('class'=>'btn btn-success')) }}</div>
    	</div>
    {!! Form::close() !!}
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Categories</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Categories Name</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td><a class="btn btn-danger btn-xs btn-delete delete-task" href="{{ route('store.category.rm',$item->id)}}">Delete</a></td>
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