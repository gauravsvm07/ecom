<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title">
					<span>Main</span>
				</li>
				<li class="active">
					<a href="{{url('auth/index')}}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
				</li>


				<li class="submenu">
					<a href="#"><i class="fe fe-layout"></i> <span> Manage Category</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="{{url('auth/category-list')}}">General Category</a></li>
						<li><a href="{{url('auth/custom-category-list')}}">Custom Category</a></li>
					</ul>
				</li>


				<li class="submenu">
					<a href="#"><i class="fe fe-layout"></i> <span> Manage Products</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="{{url('auth/general-product-list')}}">General Products</a></li>
						<li><a href="{{url('auth/custom-product-list')}}">Custom Products</a></li>
						<li><a href="{{url('auth/display-product-list')}}">Display Products</a></li>
						<li><a href="{{url('auth/madel-price-list')}}">Medal Prices</a></li>
					</ul>
				</li>

				<li><a href="{{url('auth/user-list')}}"><i class="fe fe-table"></i> <span>Manage Users</span></a></li>

				<li><a href="{{url('auth/coupon-list')}}"><i class="fe fe-table"></i> <span>Manage Coupons</span></a></li>


				<li><a href="{{url('auth/payment-list')}}"><i class="fe fe-table"></i> <span>Manage Payments</span></a></li>

				<li><a href="{{url('auth/order-list')}}"><i class="fe fe-table"></i> <span>Manage Orders</span></a></li>
				<li><a href="{{url('auth/custom-order')}}"><i class="fe fe-table"></i> <span>Custom Orders</span></a></li>

				<li><a href="{{url('auth/enquiry-list')}}"><i class="fe fe-table"></i> <span>Manage Vendors</span></a></li>

				<li class="submenu">
					<a href="#"><i class="fe fe-layout"></i> <span> Manage CMS</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="{{url('auth/banner-list')}}"> <span>Manage Banner</span></a></li>
						<li><a href="{{url('auth/page-list')}}"> <span>Manage Pages</span></a></li>
						<li><a href="{{url('auth/state-list')}}"> <span>Manage States</span></a></li>
					</ul>
				</li>




				<li class="menu-title">
					<span>Settings</span>
				</li>

				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="{{url('auth/general-settings')}}">General</a></li>
						<li><a href="{{url('auth/my-profile')}}">My Profile</a></li>
						<li><a href="{{url('auth/admin-logout')}}">Logout</a></li>
					</ul>
				</li>


			</ul>
		</div>
	</div>
</div>