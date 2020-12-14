@extends('layouts.master_report')
@section('report')
<h1>List of Employee</h1>
<table class="table">
<thead>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Father Name</th>
  <th>Joining Date</th>
  <th>Stating Salary</th>
  <th>Present Salary</th>
  <th>Consume Leave</th>
  <th>Rest Leave</th>
  <th>Mobile No</th>
  <th>Photo</th>
  <th>Comments</th>
</tr>
</thead>
<tbody>
@foreach($data as $item)
<tr>
  <td>{{ $item->id }}</td>
  <td>{{ $item->name }}</td>
  <td>{{ $item->fname }}</td>
  <td>{{ prettyDate($item->joining_date) }}</td>
  <td>{{ $item->statingSalary }}</td>
  <td>{{ $item->currentSalary }}</td>
  <?php $consumLeave = $item->Leave->where('leaveType','cl')->sum('le'); ?>
  <td>{{ $consumLeave }}</td>
  <td>{{ 15-$consumLeave }}</td>
  <td>{{ $item->mobile }}</td>
  <td><img width="80" height="80" src="{{ URL::to('/').'/public/upload/employee/'.$item->photo }}" alt=""></td>
  <td></td>
</tr>
@endforeach
</tbody>
</table>

@endsection