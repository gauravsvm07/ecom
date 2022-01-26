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
						{!! Form::model($product, ['url' => 'auth/save-general-product','method' => 'post','enctype'=>'multipart/form-data']) !!}
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




							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Price',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::text('price',old('price'),['class'=>'form-control'])!!}

										@error('price')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>



							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Size',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										{!!Form::text('size',old('size'),['class'=>'form-control'])!!}

										@error('size')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

	@if($product)

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Price/Size',['class'=>'col-lg-2 col-form-label'])!!}
									<div class="col-lg-10">
										@foreach($variations as $variation)
										<button class="btn btn-default" type="button">Price: {{$variation->price}} , Size: {{$variation->size}} <a class="btn btn-sm bg-danger-light deleteBtn" data-toggle="modal" href="#delete_modal" row_id="{{$variation->pid}}">
												<i class="fe fe-trash"></i>
											</a></button>
										@endforeach
										<a href="{{url('auth/copy-general-product/'.$product->product_id)}}" class="btn btn-sm bg-success-light"><i class="fe fe-plus">Add</i></a>
									</div>
								</div>
							</div>

@endif

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
										['class' => 'form-control status_opt']) !!}

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
						{!! Form::hidden('old_featured_img', $product->featured_img) !!}
						{!! Form::hidden('product_id',old('product_id')) !!}
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
		$(".add_more_size").click(function() {
			var size_html = $(".copy_size").html();
			$(".after_add_more_size").after(size_html);
		});

		$("body").on("click", ".remove_size", function() {
			$(this).parents(".control-group").remove();
		});

	});
</script>


<script>
	CKEDITOR.replace('description');
</script>

<script>
	$(document).ready(function() {


		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
			}
		});


		$('.deleteBtn').on('click', function() {
			var row_id = $(this).attr('row_id');
			$('.get_row_id').val(row_id);
		});

		$('.deleteBtnYs').on('click', function() {
			var row_id = $('.get_row_id').val();
			var csrf_token = $('input[name="csrf_token"]').val();
			$.ajax({
				url: "{{url('auth/delete-product')}}",
				method: "post",
				data: {
					id: row_id,
					_token: csrf_token
				},
				beforeSend: function() {
					$('.get_msg').text('deleting...');
					$(".get_msg").fadeOut("slow");
				},
				success: function(data) {
					window.location.reload();
					$('#delete_modal').modal('hide');
					$('.get_row_' + row_id).remove();


				}

			});

		});

	});
</script>

@include('includes/admin/delete-model')
@stop