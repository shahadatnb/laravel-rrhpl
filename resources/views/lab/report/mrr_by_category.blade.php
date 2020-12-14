@extends('layouts.master_report')
@section('report')

@foreach($report as $item)
<h4>$item-></h4>

@endforeach

@endsection