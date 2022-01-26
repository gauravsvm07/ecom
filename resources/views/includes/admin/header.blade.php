<div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="{{url('auth/index')}}" class="logo">
						<img src="{{URL::asset('admin/img/logo-dark.png')}}" alt="Logo">
					</a>
					<a href="{{url('auth/index')}}" class="logo logo-small">
						<img src="{{URL::asset('admin/img/logo-dark.png')}}" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					<!-- Notifications -->
					
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="{{URL::asset('uploads/users/'.Auth::guard('admin')->user()->image)}}" width="31" alt="Admin User"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="{{URL::asset('uploads/users/'.Auth::guard('admin')->user()->image)}}" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6>{{Auth::guard('admin')->user()->name}}</h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<a class="dropdown-item" href="{{url('auth/my-profile')}}">My Profile</a>
							<a class="dropdown-item" href="{{url('auth/admin-logout')}}">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>