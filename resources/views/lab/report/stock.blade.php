@extends('layouts.master_report')
@section('report')
<table class="table">
<thead>
<tr>
  <th>ID</th>
  <th>Item Name</th>
  <th>Unit</th>
  <th>Price</th>
  <th>Qty</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
@php $total=0; @endphp
@foreach($report as $item)
<tr>
  <td>{{ $item->id }}</td>
  <td>{{ $item->Item }}</td>
  <td>{{ $item->unit }}</td>
  <td>{{ $item->price }}</td>
  <td>{{ $item->qty }}</td>
  <td>{{ $sub_total = $item->qty*$item->price }}@php $total  +=$sub_total @endphp</td>
</tr>
@endforeach
</tbody>
</table>

@endsection