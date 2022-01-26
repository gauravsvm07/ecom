@extends('layouts.master')
@section('content')
@if(isset($template) && !empty($template))
@section('title', 'Edit Template')
@else
@section('title', 'Add Template')
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
						{!! Form::model($template, ['url' => 'auth/save-email-template','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">
							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Title',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::text('title',old('title'),['class'=>'form-control'])!!}

										@error('title')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>



							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Description',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::textarea('description',old('description'),['class'=>'form-control'])!!}

										@error('description')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>



							<div class="col-xl-12">
								<div class="form-group row">
									{!! Form::label('name','Status',['class'=>'col-lg-2 col-form-label']) !!}
									<div class="col-lg-10">
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
						@if($template)
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