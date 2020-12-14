@extends('layouts.master_report')
@section('from')
@php  echo date_format(date_create(Session::get('from_date')),'d-M-Y') @endphp
@endsection
@section('report')

<table class="table">
<thead>
<tr>
  <th>Date</th>
  <th>Item Name</th>
  <th>{{ trans('language.mrr') }} No</th>
  <th>Unit</th>
  <th>Qty</th>
  <th>Price</th>
  <th>Amount</th>
</tr>
</thead>
<tbody>
@php $total=0; @endphp
@foreach($report as $item)
<tr>
  <td>{{ $item->created_at->format('d-M-Y') }}</td>
  <td>{{ $item->storeItem->Item }}</td>
  <td>{{ $item->mrr_id }}</td>
  <td>{{ $item->storeItem->unit }}</td>
  <td>{{ $item->qty }}</td>
  <td>{{ $item->price }}</td>
  <td>{{ $sub_total = $item->qty*$item->price }}@php $total  +=$sub_total @endphp</td>
</tr>
@endforeach
</tbody>
</table>

@endsection