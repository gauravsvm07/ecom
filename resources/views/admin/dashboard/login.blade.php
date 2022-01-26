<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>{{env('APP_NAME')}} - Login</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="admin/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{URL::asset('admin/css/bootstrap.min.css')}}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{URL::asset('admin/css/font-awesome.min.css')}}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{URL::asset('admin/css/style.css')}}">

</head>
<body>
	
	<!-- Main Wrapper -->
	<div class="main-wrapper login-body">
		<div class="login-wrapper">
			<div class="container">
				<div class="loginbox">
					<div class="login-left">
						<img class="img-fluid" src="{{URL::asset('admin/img/logo-white.png')}}" alt="Logo">
					</div>
					<div class="login-right">
						<div class="login-right-wrap">
							<h1>Login</h1>
							<p class="account-subtitle">Access to our dashboard</p>

							<!-- Form -->
							@if (session('msg'))
							<div class="alert alert-danger" role="alert">
								<button type="button" class="close" data-dismiss="alert">×</button>
								{{ session('msg') }}
							</div>
							@endif
							<form action="{{url('auth/authenticate')}}" method="post">
								@csrf
								<div class="form-group">
									<input class="form-control" type="text" name="email" placeholder="Email" value="{{old('email')}}">
									@error('email')
									<span class="text-danger">{{$message}}</span>
									@enderror
								</div>
								
								<div class="form-group">
									<input class="form-control" type="password" name="password" placeholder="Password" value="{{old('password')}}">
									@error('password')
									<span class="text-danger">{{$message}}</span>
									@enderror
								</div>

								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit">Login</button>
								</div>
							</form>
							<!-- /Form -->

							<div class="text-center forgotpass"><a href="{{url('auth/forgot-password')}}">Forgot Password?</a></div>




						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{URL::asset('admin/js/jquery-3.2.1.min.js')}}"></script>
	<!-- Bootstrap Core JS -->
	<script src="{{URL::asset('admin/js/popper.min.js')}}"></script>
	<script src="{{URL::asset('admin/js/bootstrap.min.js')}}"></script>
	<!-- Custom JS -->
	<script src="{{URL::asset('admin/js/script.js')}}"></script>

</body>

</html>