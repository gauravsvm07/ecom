@extends('layouts.master')
@section('content')
@if(isset($banner) && !empty($banner))
@section('title', 'Edit Banner')
@else
@section('title', 'Add Banner')
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
						{!! Form::model($banner, ['url' => 'auth/save-banner','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">


							<div class="col-xl-6">
								<div class="form-group row">
									{!! Form::label('name','Banner Type',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('banner_type',['home'=>'Home Page','custom'=>'Custom Products','display'=>'Display Products'],null,
										['class' => 'form-control chosen-type', 'placeholder' => 'Please Choose']) !!}

										@error('banner_type')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>


							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Title',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('title',old('title'),['class'=>'form-control'])!!}

										@error('title')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>





							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Image',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::file('galleryImg',['name'=>'image','class'=>'form-control'])!!}
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
						@if($banner)
						{!! Form::hidden('old_image', $banner->image) !!}
						{!! Form::hidden('old_video_image', $banner->video_image) !!}
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
<script>
	galleryImg.onchange = evt => {
		const [file] = galleryImg.files
		if (file) {
			getGalleryImg.src = URL.createObjectURL(file)
			$('.preview_image').show();
		}
	}
</script>
@stop