@extends('layouts.master')
@section('content')
@section('title', 'Product List')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-head-cl">
						<div class="add-product-class">
							<a href="{{url('auth/add-general-product')}}" class="btn btn-info">Add Product</a>
						</div>
						<div class="header-search-box">
							<form method="get" action="{{url('auth/search-products')}}">
								@csrf
								<input type="text" class="from-control" name="keyword" placeholder="Enter Product Title">
								<button type="submit" class="btn btn-info btn-sm">Search</button>
							</form>
						</div>
					</div>



					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Name</th>
										<th>Image</th>
										<th>Price</th>
										<th>Size</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									@foreach($products as $key=>$row)
									<tr row_id="{{$row->product_id}}" class="get_row_{{$row->product_id}}">
										<td>{{$key+1+($products->currentPage()-1) * ($products->perPage())}}</td>
										<td>{{$row->name}}</td>
										<td><img src="{{URL::asset('uploads/products/'.$row->featured_img)}}" height="120px; width:120px;"></td>
										<td>{{$row->price}}</td>
										<td>{{$row->size}}</td>
										<td>@if($row->status==1)Active @else Inactive @endif</td>
										<td>
											<div class="actions">
												@if($row->parent_id == 0) <a class="btn btn-sm bg-info-light" href="{{url('auth/copy-general-product/'.$row->product_id)}}">
													<i class="fe fe-copy"></i> Add Variation
												</a>@else &nbsp;&nbsp;&nbsp; @endif
												<a class="btn btn-sm bg-success-light" href="{{url('auth/edit-general-product/'.$row->product_id)}}">
													<i class="fe fe-pencil"></i> Edit
												</a>
												<a class="btn btn-sm bg-danger-light deleteBtn" data-toggle="modal" href="#delete_modal" row_id="{{$row->product_id}}">
													<i class="fe fe-trash"></i> Delete
												</a>
											</div>
										</td>
									</tr>
									@endforeach

								</tbody>

							</table>
							{{$products->appends(request()->query())->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- /Main Wrapper -->


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
					$('#delete_modal').modal('hide');
					$('.get_row_' + row_id).remove();
				}

			});

		});

	});
</script>

@include('includes/admin/delete-model')
@stop