@extends('layouts.master')
@section('content')
@if(isset($category) && !empty($category))
@section('title', 'Edit Category')
@else
@section('title', 'Add Category')
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
						{!! Form::model($category, ['url' => 'auth/save-category','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">
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
										{!!Form::file('categoryImg',['name'=>'image','class'=>'form-control','id'=>'categoryImg'])!!}			
									</div>
								</div>
							</div>

							<div class="col-xl-6 preview_image" style="display: none">
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Image Preview</label>
									<div class="col-lg-9">
										<img id="getcategoryImg" src="#" alt="your image" style="height: 150px;width: 150px;">
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
						@if($category)
						{!! Form::hidden('old_image', $category->image) !!}   
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
	categoryImg.onchange = evt => {
		const [file] = categoryImg.files
		if (file) {
			getcategoryImg.src = URL.createObjectURL(file)
			$('.preview_image').show();
		}
	}	
</script>
@stop


