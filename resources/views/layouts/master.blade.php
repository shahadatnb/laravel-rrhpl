<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Admin Panel - {{ trans('language.company_name') }}</title>

		{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"> --}}
		{!! Html::style('public/css/bootstrap-3.3.6.min.css') !!}
		@yield('stylesheet')
		{!! Html::style('public/css/style.css') !!}


		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	<nav class="navbar navbar-default navbar-static-top hidden-print">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
			MENU
			</button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ URL::to('/')}}">
				{{ trans('language.company_name') }}
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">
					
				</a>
			</div>      
			@if (Auth::check())
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Hello {{Auth::user()->name}}
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">SETTINGS</li>
							<li class=""><a href="{{ URL::to('/profile')}}">Profile</a></li>
							<li class="divider"></li>
							<li>
								<a href="{{ route('logout') }}"
									onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
									Logout
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
					</li>
				</ul>
				@endif
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>  	
	<div class="container-fluid main-container hidden-print">
		<div class="col-md-2 sidebar">
			<div class="row">
			<!-- uncomment code for absolute positioning tweek see top comment in css -->
			<div class="absolute-wrapper"> </div>
			<!-- Menu -->
			<div class="side-menu">
				<nav class="navbar navbar-default" role="navigation">
					<!-- Main Menu -->
					<div class="side-menu-container">
						<ul class="nav navbar-nav">
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-lfl1">
									<span class="glyphicon glyphicon-user"></span> Store <span class="caret"></span>
								</a>

								<!-- Dropdown level 1 -->
								<div id="dropdown-lfl1" class="panel-collapse collapse in">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="{{ URL::to('store/item')}}">Product</a></li>
											<li><a href="{{ URL::to('store/mrr')}}">{{ trans('language.mrr') }}</a></li>
											<li><a href="{{ URL::to('store/srr')}}">{{ trans('language.srr') }}</a></li>
											<li><a href="{{ URL::to('store/report')}}">Report</a></li>
										</ul>
									</div>
								</div>
							</li>
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-lfl2">
									<span class="glyphicon glyphicon-user"></span> Lab <span class="caret"></span>
								</a>

								<!-- Dropdown level 1 -->
								<div id="dropdown-lfl2" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="{{ URL::to('lab/index')}}">Lab</a></li>
											<li><a href="{{ URL::to('lab/item')}}">Lab Item</a></li>
											<li><a href="{{ URL::to('lab/mrr')}}">{{ trans('language.labmrr') }}</a></li>
											<li><a href="{{ URL::to('lab/srr')}}">{{ trans('language.labsrr') }}</a></li>
										</ul>
									</div>
								</div>
							</li>
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-lfl3">
									<span class="glyphicon glyphicon-user"></span> HRD <span class="caret"></span>
								</a>

								<!-- Dropdown level 1 -->
								<div id="dropdown-lfl3" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="{{url('hrd/employee')}}">All Emplyee</a></li>
											<li><a href="{{url('hrd/employee/create')}}">New</a></li>
											<li><a target="_blank" href="{{url('hrd/employeeList')}}">List</a></li>
										</ul>
									</div>
								</div>
							</li>
							</li>
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-lfl4">
									<span class="glyphicon glyphicon-signal"></span> Admin <span class="caret"></span>
								</a>

								<!-- Dropdown level 1 -->
								<div id="dropdown-lfl4" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="{{ url('/basic-settings')}}">Setting</a></li>
											<li><a href="{{ URL::to('admin')}}">User Role</a></li>
										</ul>
									</div>
								</div>
							</li>

							<!--
							<li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li> -->

							<!-- Dropdown--><!--
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-2vl1">
									<span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
								</a>

								<!-- Dropdown level 1 --><!--
								<div id="dropdown-2vl1" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>

											<!-- Dropdown level 2 --><!--
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#dropdown-2vl2">
													<span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span>
												</a>
												<div id="dropdown-2vl2" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="#">Link</a></li>
															<li><a href="#">Link</a></li>
															<li><a href="#">Link</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</li>

							<li><a href="#"><span class="glyphicon glyphicon-signal"></span> Link</a></li>
							-->
						</ul>
					</div><!-- /.navbar-collapse -->
				</nav>

			</div>
		</div>
		</div>
		 <div class="col-md-10 content">
			<div class="panel panel-default">
				<div class="panel-heading">
					<b>@yield('title')</b>
				</div>
				<div class="panel-body">
					@include('partials._message')
					@yield('content')
				</div>
			</div>
		 </div>
	<footer class="pull-left footer col-md-12">
		<p class="">
			<hr class="divider">
			Devoloped By <a href="http://asiancoder.com">AsianCoder</a>
		</p>
	</footer>
</div>
<div class="visible-print">
@yield('print')
</div>
 
		<script src="{{ URL::to('/public/js/jquery-1.11.3.min.js')}}"></script>
		<script src="{{ URL::to('/public/js/bootstrap-3.3.6.min.js')}}"></script>
		{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
		@yield('scripts')
	</body>
</html>
