@extends('layouts.master')
@section('title','Store Item')
@section('stylesheet')
	{!! Html::style('public/plugins/datatables/dataTables.bootstrap.css') !!}
	{!! Html::style('public/css/parsley.css') !!}
	{!! Html::style('public/css/select2.min.css') !!}
@endsection
@section('content')

<div class="bs-example">
    {!! Form::open(array('route'=>'store.item.store','data-parsley-validate'=>'')) !!}
    	<div class="row">
    		<div class="col-md-6">
    			<div class="form-group">
      				{{ Form::label('item','Item Name') }}
					{{ Form::text('item',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
    			</div>
    		</div>
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-9">
              {{ Form::label('category','Category') }}
              <select name="category_id" id="category" required="" class="form-control select2">
                <option value="">---------</option>
                @foreach($categories as $category)
                   <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <br><a class="btn btn-primary" href="{{ route('store.category') }}">Category</a>
            </div>
          </div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
              <div class="form-group">
              {{ Form::label('price','Price') }}
              {{ Form::number('price',null,array('class'=>'form-control','required'=>'','step'=>'any')) }}
              </div>
            </div>
          </div>
    		</div>
    		<div class="col-md-6"><br>
    			{{ Form::submit('Create New Item',array('class'=>'btn btn-success')) }}
    		</div>
    	</div>
    {!! Form::close() !!}
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Item <a href="{{ route('store-iten-export') }}" class="btn btn-success">Export Excel</a></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Unit</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Last {{ trans('language.mrr') }}<br>Memo No</th>
          <th>Last {{ trans('language.mrr') }} Date</th>
          <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
        <tr id="{{$item->id}}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->Item }}</td>
          <td>{{ $item->StoreCategory->name }}</td>
          <td>{{ $item->unit }}</td>
          <td>{{ $item->price }}</td>
          <td>{{ $item->qty }}</td>
          @if($item->srrInfo->count()>0)
            <td>{{ $item->srrInfo[0]->id }} </td>
            <td>{{ $item->srrInfo[0]->created_at->format('d-M-Y') }}</td>
          @else
            <th></th>
            <th></th>
          @endif
          <td>
            <div class="btn-group">
              <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$item->id}}"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
              <a class="btn btn-danger btn-xs" href="{{route('store.item.destroy',$item->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
              @if($item->publish == 1)
                <a class="btn btn-info btn-xs" href="{{route('store.ShowHide',$item->id)}}">Show</a>
              @else
                <a class="btn btn-warning btn-xs" href="{{route('store.ShowHide',$item->id)}}">Hide</a>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->


<!-- Modal (Pop up when detail button clicked) -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Item Edit</h4>
                </div>
                <div class="modal-body">
                  <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                    <div class="form-group error">
                        <label for="task" class="col-sm-3 control-label">Item Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="task" name="task" readonly="">
                        </div>
                    </div>
                    <div class="form-group error">
                      <label for="category_id" class="col-sm-3 control-label">Category</label>
                      <div class="col-sm-9">
                          <select name="category_id" id="category_id" class="form-control select2" style="width:100%">
                              <option value="" selected="selected">Present</option>
                              @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="form-group error">
                      <label for="unit" class="col-sm-3 control-label">Unit</label>
                      <div class="col-sm-9">
                          <select name="unit" id="unit" class="form-control">
                            <option value="" selected="selected">Present</option>
                            @foreach(trans('language.unit') as $unit )
                              <option value="{{ $unit }}">{{ $unit }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>                    

                    <div class="form-group">
                        <label for="pprice" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="pprice" name="price" placeholder="Price" value="">
                        </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                        <input type="hidden" id="task_id" name="task_id" value="0">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
	<!-- DataTables -->
	{!! Html::script('public/plugins/datatables/jquery.dataTables.min.js') !!}
	{!! Html::script('public/plugins/datatables/dataTables.bootstrap.min.js') !!}
	{!! Html::script('public/js/parsley.min.js') !!}
	{!! Html::script('public/js/select2.min.js') !!}
	<script>
		$('.select2').select2();

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

    $(function () {
      $("#example1").DataTable();
    });
	</script>
@endsection