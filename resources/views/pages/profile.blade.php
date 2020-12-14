@extends('admin.admin-master')
@section('title','User Profile')
@section('content')


<div class="row">
	<div class="col-sm-12">
		<h1>Change Password</h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		{!! Form::open(['url' => 'passChange']) !!}
			<input type="password" class="input-lg form-control" name="current-password" id="current-password" placeholder="Old Password" required="required" autocomplete="off">

			<input type="password" class="input-lg form-control" name="password" id="password" placeholder="New Password" required="required" autocomplete="off">
			<div class="row"><!--
				<div class="col-sm-6">
					<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 6 Characters Long
				</div>
				<div class="col-sm-6">
					<br>
					<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase Letter
					<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase Letter<br>
					<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
				</div> -->
			</div>
			<input type="password" class="input-lg form-control" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" required="required" autocomplete="off">
			<input type="submit" class="col-xs-12 btn btn-primary btn-load" value="Change Password">
		{!! Form::close() !!}
	</div><!--/col-sm-6-->
</div><!--/row-->

@endsection('content')