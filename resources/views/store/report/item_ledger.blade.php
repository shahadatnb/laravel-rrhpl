@extends('layouts.master_report')
@section('report_title',$title)
@section('from')
@php  echo date_format(date_create(Session::get('from_date')),'d-M-Y') @endphp
@endsection
@section('report')
<br><p><b>Item Name: </b>{{$itemname}}</p>
<table class="table">
<thead>
<tr>
  <th>Date</th>
  <th>{{ trans('language.mrr') }} No</th>
  <th>{{ trans('language.srr') }} No</th>
  <th>{{ trans('language.mrr') }} Qty</th>
  <th>{{ trans('language.srr') }} Qty</th>
  <th>Recipient Name</th>
  <th>Recipient Dept</th>
  <th>Stock</th>
  <th>Remark</th>
</tr>
</thead>
<tbody>
<tr>
  <td colspan="3">To Date: </td>
  <td>{{ $total }}</td>
</tr>
@foreach($report as $item)
<tr>
  <td>{{ $item->created_at->format('d-M-Y') }}</td>
  <td>{{ $item->mrr_id }}</td>
  <td>{{ $item->srr_id }}</td>
  <td>
    @if($item->mrr_id)
    {{ $item->qty }}
    @endif
  </td>
  <td>
    @if($item->srr_id)
    {{ $item->qty }}
    @endif
  </td>
  <td>@if($item->srr_id)
    {{ $item->srr->recipient->name }}
    @endif
  </td>
  <td>@if($item->srr_id)
    {{ $item->srr->recipient->address }}
    @endif
  </td>
  <td>@php if($item->srr_id >0){$total +=$item->qty;}
  else{$total -=$item->qty;} @endphp {{ $total }}</td>
  <td>@if($item->srr_id)
    {{ $item->srr->remark }}
    @endif
  </td>
</tr>
@endforeach
</tbody>
</table>

@endsection