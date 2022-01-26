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
						{!! Form::model($product, ['url' => 'auth/save-custom-product','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">




							<div class="col-xl-12">
								<div class="form-group row">
									{!! Form::label('name','Product Category',['class'=>'col-lg-2 col-form-label']) !!}
									<div class="col-lg-10">
										{!! Form::select('category_id',[''=>'--Select Category--'] +$product_category ,old('category_id'),['class'=>'form-control pageCat','id'=>'category_id']) !!}

										@error('category_id')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>



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





							<!-- 		<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Quantity',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::text('quantity',old('quantity'),['class'=>'form-control'])!!}

										@error('quantity')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div> -->





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

							<!-- <div class="input-group control-group after-add-more">  
								<div class="col-xl-12">
									<div class="form-group row">
										{!!Form::label('name','Product Images',['class'=>'col-lg-2 col-form-label'])!!}
										<div class="col-lg-8">
											{!!Form::file('galleryImg',['name'=>'image[]','class'=>'form-control'])!!}	
										</div>

										<div class="col-lg-2">
											<div class="input-group-btn">   
												<button class="btn btn-success add-more" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>  
											</div>
										</div>

									</div>
								</div>
							</div> -->


							<!-- <div class="copy hide" style="display: none;">
								<div class="control-group input-group" style="margin-top:10px">
									<div class="col-xl-12">

										<div class="form-group row">
											{!!Form::label('name','Product Images',['class'=>'col-lg-2 col-form-label'])!!}
											<div class="col-lg-8">
												{!!Form::file('galleryImg',['name'=>'image[]','class'=>'form-control'])!!}	
											</div>

											<div class="col-lg-2">
												<div class="input-group-btn">   
													<button class="btn btn-danger remove" type="button"><i class="fa fa-times" aria-hidden="true"></i> Remove</button>   
												</div>
											</div>

										</div>
									</div>
								</div>
							</div> -->

							<!-- 	@if($product)
							<div class="row my-5 w-100">
								@foreach($product_images as $image)	
								<div class="col-xl-2">
									<div class="products-icon">
										<img src="{{URL::asset('uploads/products/'.$image->file_name)}}">
										<span><a href="{{url('auth/delete-product-image/'.$image->id)}}"><i class="fa fa-times"></i></a></span>
									</div>
								</div>	
								@endforeach

							</div>
							@endif -->




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



<script type="text/javascript">
	$(document).ready(function() {
		$(".add-more").click(function() {
			var html = $(".copy").html();
			$(".after-add-more").after(html);
		});

		$("body").on("click", ".remove", function() {
			$(this).parents(".control-group").remove();
		});

	});
</script>




<script>
	CKEDITOR.replace('description');
</script>
@stop