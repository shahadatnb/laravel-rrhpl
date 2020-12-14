@extends('layouts.master')
@section('title','Lab Home')
@section('content')

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
				  <th>ID</th>
				  <th>Item Name</th>
				  <th>Quantity</th>
				  <th>Current Stock</th>
				  <th>Entry Date</th>
				  <th>Expiry Date</th>
				  <th>Action</th>
				</tr>
				</thead>
				<tbody>
				@foreach($report as $item)
				@if($item->expiryDate < '2017-12-11')
				<tr class="danger"> 
				@else
				<tr> 
				@endif
				  <td>{{ $item->invoice_id }}</td>
				  <td>{{ $item->labItem->Item }}</td>
				  <td>{{ $item->qty }}</td>
				  <td>{{ $item->labItem->qty }}</td>
				  <td>{{ $item->created_at->format('d-M-Y') }}</td>
				  <td>{{ date('d-M-Y', strtotime($item->expiryDate)) }}</td>
				  <td><a href="{{ route('lab.exp',$item->id) }}" class="btn btn-primary btn-xs">Finish</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection