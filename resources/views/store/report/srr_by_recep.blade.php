@extends('layouts.master_report')
@section('from')
@php  echo date_format(date_create(Session::get('from_date')),'d-M-Y') @endphp
@endsection
@section('report')

<table class="table">
<thead>
<tr>
  <th>Date</th>
  <th>{{ trans('language.srr') }} No</th>
  <th>Item Name</th>
  <th>{{ trans('language.recipient') }}</th>
  <th>Department</th>
  <th>Unit</th>
  <th>Qty</th>
  <th>Amount</th>
  <th>Remark</th>
</tr>
</thead>
<tbody>
@php $total=0; @endphp
@foreach($report as $item)
<tr>
  <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
  <td>{{ $item->srr_id }}</td>
  <td>{{ $item->Item }}</td>
  <td>{{ $item->name }}</td>
  <td>{{ $item->address }}</td>
  <td>{{ $item->unit }}</td>
  <td>{{ $item->qty }}</td>
  <td>{{ $sub_total = $item->qty*$item->price }}@php $total  +=$sub_total @endphp</td>
  <td>{{ $item->remark }}</td>
</tr>
@endforeach
</tbody>
</table>

@endsection