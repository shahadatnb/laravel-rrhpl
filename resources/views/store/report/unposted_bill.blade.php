@extends('layouts.master_report')
@section('report_title',$title)
@section('report')
<h3>Unposted {{ trans('language.mrr') }}</h3>
<table class="table">
<thead>
<tr>
  <th>{{ trans('language.mrr') }} ID</th>
  <th>Date</th>
  <th>User</th>
</tr>
</thead>
<tbody>
@foreach($mrr as $item)
<tr>
  <td>{{ $item->id }}</td>
  <td>{{ $item->created_at->format('d/m/Y h:i:s A') }}</td>
  <td>{{ $item->user->name }}</td>
</tr>
@endforeach
</tbody>
</table>

<h3>Unposted {{ trans('language.srr') }}</h3>
<table class="table">
<thead>
<tr>
  <th>{{ trans('language.srr') }} ID</th>
  <th>Date</th>
  <th>User</th>
</tr>
</thead>
<tbody>
@foreach($srr as $item)
<tr>
  <td>{{ $item->id }}</td>
  <td>{{ $item->created_at->format('d/m/Y h:i:s A') }}</td>
  <td>{{ $item->user->name }}</td>
</tr>
@endforeach
</tbody>
</table>

@endsection