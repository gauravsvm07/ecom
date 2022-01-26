@extends('layouts.master')
@section('content')

@if(isset($permission) && !empty($permission))
@section('title', 'Edit Permission')
@else
@section('title', 'Add Permission')
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
						{!! Form::model($permission, ['url' => 'auth/save-permission','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">

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
									{!! Form::label('name','Module',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('module_id',[''=>'--Select Module--'] +$modules ,old('module_id'),['class'=>'form-control']) !!}

										@error('module_id')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>


							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Permission',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!! Form::checkbox('can_add', '1', null,['id'=>'add']) !!}
										{!! Form::label('add','Add') !!}<br>
										{!! Form::checkbox('can_view', '1', null,['id'=>'view']) !!}
										{!! Form::label('view', 'View'); !!}<br> 
										{!! Form::checkbox('can_update', '1', null,['id'=>'update']) !!}
										{!! Form::label('update', 'Update'); !!}<br>
										{!! Form::checkbox('can_delete', '1', null,['id'=>'delete']) !!}
										{!! Form::label('delete', 'Delete'); !!} 


									</div>
								</div>
							</div>



						</div>

					</div>

					<div class="text-right">
						@if($permission)
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


