<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>{{env('APP_NAME')}} - Lock Screen</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('admin/img/favicon.png')}}">

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
							<img class="img-fluid" src="{{URL::asset('admin/img/logo.png')}}" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								<div class="lock-user">
									<img class="rounded-circle" src="{{URL::asset('admin/img/profiles/avatar-02.jpg')}}" alt="User Image">
									<h4>John Doe</h4>
								</div>
								
								<!-- Form -->
								<form action="" method="post">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Password">
									</div>
									<div class="form-group mb-0">
										<button class="btn btn-primary btn-block" type="submit">Enter</button>
									</div>
								</form>
								<!-- /Form -->
								
								<div class="text-center dont-have">Sign in as a different user? <a href="{{url('admin/logout')}}">Login</a></div>
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