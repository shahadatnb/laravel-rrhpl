@extends('layouts.master')
@section('title','Store Item')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'lab.item.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-5">
    			<div class="form-group">
      				{{ Form::label('item','Item Name') }}
					{{ Form::text('item',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
    			</div>
    		</div>
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                {{ Form::label('unit','Select Unit') }}
                <select required="" name="unit" id="" class="form-control">
                  <option value="">---------</option>
                  @foreach(trans('language.unit') as $unit )
                    <option value="{{ $unit }}">{{ $unit }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4"><br>
              {{ Form::submit('Create New Item',array('class'=>'btn btn-success')) }}
            </div>
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
          <th>ID</th>
          <th>Item Name</th>
          <th>Unit</th>
          <th>Drop</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
        <tr id="{{$item->id}}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->Item }}</td>
          <td>{{ $item->unit }}</td>
          <td>{{ $item->publish }}</td>
          <td>
            <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$item->id}}"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
            <a class="btn btn-danger btn-xs" href="{{route('lab.item.destroy',$item->id)}}"><span class="glyphicon glyphicon-trash"></span></a></td>
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

    $(document).ready(function(){

    var url = "{{ route('home') }}";

    //display modal form for task editing
    $('.open-modal').click(function(){
       var task_id = $(this).val();

        $.get(url + '/store/item/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#task_id').val(data.id);
            $('#task').val(data.Item);
            //$('#supplier_id').val(data.supplier_id);
            /*var option = document.createElement("option");
            option.text = "Text";
            option.value = "myvalue";
            var select = document.getElementById("supplier_id");
            select.appendChild(option);*/

            //$("#category_id").prepend("<option value='"+ data.category_id +"' selected='selected'>Corrent</option>");
            //$("#unit").prepend("<option value='"+ data.unit +"' selected='selected'>"+ data.unit +"</option>");

            $('#pprice').val(data.price);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        }) 

    });


    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 

        var formData = {
            task: $('#task').val(),
            category_id: $('#category_id').val(),
            unit: $('#unit').val(),
            price: $('#pprice').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#task_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "POST"; //for updating existing resource
            my_url += '/store/item/edit/' + task_id;
        }

        console.log(formData);
        //console.log(my_url);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var task = '<tr id="item' + data.id + '"><td>' + data.id + '</td><td>' + data.Item + '</td><td>' + data.price + '</td>';
                task += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#tasks-list').append(task);
                }else{ //if user updated an existing record

                    //$("#item" + task_id).replaceWith( task );
                    // gets the <tr> element of the table that contains the table
                    var productRow = document.getElementById(data.id).cells;
                    //productRow[2].innerHTML =  data.price;
                    productRow[3].innerHTML =  data.unit;
                    productRow[4].innerHTML =  data.price;
                }

                $('#frmTasks').trigger("reset");
                
                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
	</script>
@endsection