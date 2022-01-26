@extends('layouts.master')
@section('content')

@if(isset($admin) && !empty($admin))
@section('title', 'Edit Admin User')
@else
@section('title', 'Add Admin User')
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
						{!! Form::model($admin, ['url' => 'auth/save-admin','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">

							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Name',['class'=>'col-lg-3 col-form-label'])!!}
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
									{!!Form::label('name','Password',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!! Form::input('password', 'password', old('password'),['class'=>'form-control']) !!}

										@error('password')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-6">
								<div class="form-group row">
									{!! Form::label('name','Role',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('role_id',[''=>'--Select Role--'] +$roles ,old('role_id'),['class'=>'form-control']) !!}

										@error('role_id')
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
						@if($admin)
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


