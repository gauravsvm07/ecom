@extends('layouts.master')
@section('content')
@section('title', 'My Profile')

<!-- Page Wrapper -->
<div class="page-wrapper">
<div class="content container-fluid">

<!-- Page Header -->
@include('includes/admin/breadcrumb')
<!-- /Page Header -->

<div class="row">
<div class="col-md-12">
<div class="profile-header">
<div class="row align-items-center">
<div class="col-auto profile-image">
<a href="#">
<img class="rounded-circle" alt="User Image" src="{{URL::asset('uploads/users/'.$user->image)}}">
</a>
</div>
<div class="col ml-md-n2 profile-user-info">
<h4 class="user-name mb-0">{{$user->name}}</h4>
<h6 class="text-muted">{{$user->email}}</h6>
<div class="user-Location"><i class="fa fa-map-marker"></i> {{$user->address}}</div>
<div class="about-text">{{$user->about}}</div>
</div>
<!-- <div class="col-auto profile-btn">

<a data-toggle="modal" href="#edit_personal_details" class="btn btn-primary">
	Edit
</a>
</div> -->
</div>
</div>
<div class="profile-menu">
<ul class="nav nav-tabs nav-tabs-solid">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
</li>
</ul>
</div>	
<div class="tab-content profile-tab-cont">

<!-- Personal Details Tab -->
<div class="tab-pane fade show active" id="per_details_tab">
@if (session('msg'))
<div class="alert alert-success" role="alert">
<button type="button" class="close" data-dismiss="alert">×</button>
{{ session('msg') }}
</div>
@endif
<!-- Personal Details -->
<div class="row">
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title d-flex justify-content-between">
				<span>Personal Details</span> 
				<a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
			</h5>
			<div class="row">
				<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
				<p class="col-sm-10">{{$user->name}}</p>
			</div>
			
			<div class="row">
				<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Email ID</p>
				<p class="col-sm-10">{{$user->email}}</p>
			</div>
			<div class="row">
				<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
				<p class="col-sm-10">{{$user->phone}}</p>
			</div>
			<div class="row">
				<p class="col-sm-2 text-muted text-sm-right mb-0">Address</p>
				<p class="col-sm-10 mb-0">{{$user->address}}</p>
			</div>
		</div>
	</div>
	
	<!-- Edit Details Modal -->
	@include('admin.dashboard.edit-profile')
	<!-- /Edit Details Modal -->
	
</div>


</div>
<!-- /Personal Details -->

</div>
<!-- /Personal Details Tab -->

<!-- Change Password Tab -->
<div id="password_tab" class="tab-pane fade">
@include('admin.dashboard.change-password')
</div>
<!-- /Change Password Tab -->

</div>
</div>
</div>

</div>			
</div>
<!-- /Page Wrapper -->

@stop