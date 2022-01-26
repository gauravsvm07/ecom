@extends('layouts.master')
@section('content')
@if(isset($product) && !empty($product))
@section('title', 'Edit Product')
@else
@section('title', 'Add Product')
@endif

<style>
	select option {
		color: black;
	}

	select option:first-child {
		color: red;
	}
</style>
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
						{!! Form::model($product, ['url' => 'auth/save-display-product','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">



							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Name',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::text('name',old('name'),['class'=>'form-control'])!!}

										@error('name')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Featured Image',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::file('galleryImg',['name'=>'featured_img','class'=>'form-control'])!!}

										@error('featured_img')
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
										['class' => 'form-control chosen-type']) !!}

										@error('status')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>


						</div>

					</div>

					<div class="text-right">
						@if($product)
						{!! Form::hidden('old_featured_img', $product->image) !!}
						<input type="hidden" name="id" value="{{$product->product_id}}">
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
	CKEDITOR.replace('description');
</script>
@stop