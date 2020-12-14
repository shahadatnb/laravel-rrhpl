@extends('layouts.master')
@section('title','User Manager')
@section('content')
	<div class="row">
		<div class="col-md-10">
			<a href="{{ route('register') }}" class="btn btn-primary">New User</a>
			<table class="table">
				<thead>
					<tr>
						<th>Namre</th>
						<th>Email</th>
						<th>Store</th>
						<th>Lab</th>
						<th>HR</th>
						<th>Admin</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($users as $user)
				<form action="{{ route('admin-assign') }}" method="post">
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
						<td><input type="checkbox" {{ $user->hasRole('Store') ? 'checked' : '' }} name="role_store"></td>
						<td><input type="checkbox" {{ $user->hasRole('Lab') ? 'checked' : '' }} name="role_lab"></td>
						<td><input type="checkbox" {{ $user->hasRole('HR') ? 'checked' : '' }} name="role_hr"></td>
						<td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"></td>
						{{ csrf_field() }}
						<td><button class="btn btn-primary" type="submit">Assign Role</button></td>
					</tr>
				</form>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
