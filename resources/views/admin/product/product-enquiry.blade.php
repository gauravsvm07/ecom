@extends('layouts.master')
@section('content')
@section('title', 'Product Inquiry')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						&nbsp;
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Name</th>
										<th>Email Id </th>
										<th>Mobile Number</th>
										<th>Product Name</th>
										<th>Size</th>
										<th>Border</th>
										<th>Shape</th>
										<th>Image</th>
											<th>Date</th>

									</tr>
								</thead>

								<tbody>

									@foreach($enq as $key=>$row)
									<tr row_id="{{$row->id}}" class="get_row_{{$row->id}}">
										<td>{{$key+1+($enq->currentPage()-1) * ($enq->perPage())}}</td>
										<td>{{$row->name}}</td>
										<td>{{$row->email_id}}</td>
										<td>{{$row->mobile}}</td>
										<td>{{$row->product_name}}</td>
										<td>{{$row->size}}</td>
										<td>{{$row->border}}</td>
										<td>{{$row->shape}}</td>
										<td><a href="{{URL::asset('uploads/enquiry/'.$row->image)}}" target="_blank"><img src="{{URL::asset('uploads/enquiry/'.$row->image)}}" style="height:70px; width:70px;"></a></td>
										<td>{{$row->created_at}}</td>
									</tr>
									@endforeach

								</tbody>

							</table>
							{{$enq->links()}}
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