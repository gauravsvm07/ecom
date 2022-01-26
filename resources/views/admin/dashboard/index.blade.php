@extends('layouts.master')
@section('content')
@section('title', 'Dashboard')



<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">

	<div class="content container-fluid">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Welcome Admin!</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Dashboard</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="row">
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
				    
				    <a href="{{url('auth/user-list')}}">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon text-primary border-primary">
								<i class="fe fe-users"></i>
							</span>
							<div class="dash-count">
								<h3>{{$user_count}}</h3>
							</div>
						</div>
						<div class="dash-widget-info">
							<h6 class="text-muted">Users</h6>
							<div class="progress progress-sm">
								<div class="progress-bar bg-primary w-50"></div>
							</div>
						</div>
					</div>
					</a>
					
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
				    
				    <a href="{{url('auth/display-order')}}">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon text-success">
								<i class="fe fe-users"></i>
							</span>
							<div class="dash-count">
								<h3>{{$enquiry_count}}</h3>
							</div>
						</div>
						<div class="dash-widget-info">

							<h6 class="text-muted">Inquiry</h6>
							<div class="progress progress-sm">
								<div class="progress-bar bg-success w-50"></div>
							</div>
						</div>
					</div>
					</a>
					
					
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
				    
				     <a href="{{url('auth/page-list')}}">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon text-danger border-danger">
								<i class="fe fe-money"></i>
							</span>
							<div class="dash-count">
								<h3>{{$page_count}}</h3>
							</div>
						</div>
						<div class="dash-widget-info">

							<h6 class="text-muted">Page</h6>
							<div class="progress progress-sm">
								<div class="progress-bar bg-danger w-50"></div>
							</div>
						</div>
					</div>
					 </a>
					
					
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
				    
				      <a href="{{url('auth/payment-list')}}">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon text-warning border-warning">
								<i class="fe fe-folder"></i>
							</span>
							<div class="dash-count">
								<h3>${{$user_payment}}</h3>
							</div>
						</div>
						<div class="dash-widget-info">

							<h6 class="text-muted">Revenue</h6>
							<div class="progress progress-sm">
								<div class="progress-bar bg-warning w-50"></div>
							</div>
						</div>
					</div>
					</a>
					
					
					
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12">

				<!-- Recent Orders -->
				<div class="card card-table">
					<div class="card-header">
						<h4 class="card-title">Latest Inquiry</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email Id</th>
										<th class="text-right">Date</th>
									</tr>
								</thead>
								<tbody>

									@if(count($enquiries) > 0 )
									@foreach($enquiries as $row)
									<tr>
										<td>
											{{$row->name}}
										</td>
										<td>{{$row->email_id}}</td>

										<td class="text-right">
											{{$row->created_at}}
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td colspan="4">Data not found.. </td>
									</tr>
									@endif

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /Recent Orders -->

			</div>
		</div>

	</div>
</div>
<!-- /Page Wrapper -->


<!-- /Main Wrapper -->

@stop