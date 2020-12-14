@extends('layouts.master')
@section('title','Employee')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Employee List
        <a href="#{{-- route('store-iten-export') --}}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('employee.create') }}" class="btn btn-success">Add New</a>
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Designation</th>
          <th>Department</th>
          <th>Mobile</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $data)
        <tr id="{{$data->id}}">
          <td>{{ $data->id }}</td>
          <td>{{ $data->name }}</td>
          <td>{{ $data->designation->designation }}</td>
          <td>{{ $data->department->department }}</td>
          <td>{{ $data->mobile }}</td>
          <td>
            <a class="btn btn-success btn-xs" href="{{ route('leave.index',$data->id)}}">Leave</a>
            <a class="btn btn-warning btn-xs" href="{{ route('employee.edit',$data->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
            <a class="btn btn-danger btn-xs" href="{{--route('hrd.employee.destroy',$data->id)--}}"><span class="glyphicon glyphicon-trash"></span></a></td>
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
        });
	</script>
@endsection