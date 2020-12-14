@if(Session::has('success'))
	<div class="alert alert-success">
		<strong>Success: </strong>{{ Session::get('success') }}
	</div>

@endif

@if(Session::has('warning'))
	<div class="alert alert-danger">
		<strong>Warning: </strong>{{ Session::get('warning') }}
	</div>

@endif

@if(count($errors)>0)
	<div class="alert alert-danger">
		<strong>Errors: </strong>
		<ul>
			@foreach($errors->all() as $errors)
			<li>{{ $errors }}</li>
			@endforeach
		</ul>
	</div>
@endif