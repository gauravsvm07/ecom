@extends('layouts.master')
@section('content')

@if(isset($user) && !empty($user))
@section('title', 'Edit User')
@else
@section('title', 'Add User')
@endif

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<div class="card-body">
						@if (session('msg'))
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert">×</button>
							{{ session('msg') }}
						</div>
						@endif
						{!! Form::model($user, ['url' => 'auth/save-user','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">

							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','First Name',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('name',old('name'),['class'=>'form-control'])!!}

										@error('name')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>


							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Last Name',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('last_name',old('last_name'),['class'=>'form-control'])!!}

										@error('last_name')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>


							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Email',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('email',old('email'),['class'=>'form-control'])!!}

										@error('email')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','PassCode',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										<input type="password" class="form-control" name="password">
										@error('password')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>



							<div class="col-xl-6">
								<div class="form-group row">
									{!! Form::label('name','Status',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,
										['class' => 'form-control chosen-type', 'placeholder' => 'Please Choose']) !!}

										@error('status')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>





						</div>

					</div>

					<div class="text-right">
						@if($user)
						{!! Form::hidden('id',old('id')) !!}
						@endif
						{!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>


</div>
</div>
<!-- /Main Wrapper -->

@stop