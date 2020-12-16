@extends('layouts.master_report')
@section('from')
@php  echo date_format(date_create(Session::get('from_date')),'d-M-Y') @endphp
@endsection
@section('report_title',$title)
@section('report')
<table class="table">
<thead>
<tr>
  <th>Sl</th>
  {{-- <th>ID</th> --}}
  <th>Item Name</th>
  <th>Opening</th>
  <th>Receive</th>
  <th>Issue</th>
  <th>Balance</th>
  <th>Unit <br> Price</th>
  <th>Cost of <br> Issued goods</th>
  <th>Cost of <br> Closing Balance</th>
</tr>
</thead>
<tbody>
@php $total=0; @endphp
@foreach($report as $key=>$item)
<tr>
  <td>{{ ++$key}}</td>
  {{-- <td>{{ $item['id']}}</td> --}}
  <td>{{ $item['Item'] }}</td>
  <td>{{ $item['opening'] }}</td>
  <td>{{ $item['receive'] }}</td>
  <td>{{ $item['issue'] }}</td>
  <td>{{ $item['balance'] }}</td>
  <td>{{ $item['price'] }}</td>
  <td>{{ $item['costIssue'] }}</td>
  <td>{{ $item['costClosing'] }}</td>
</tr>
@endforeach
<tr>
  <td></td>
  {{-- <td>{{ $item['id']}}</td> --}}
  <td>Total:</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>{{ $totalCostIssue}}</td>
  <td>{{ $totalCostClosing}}</td>
</tr>
</tbody>
</table>

@endsection