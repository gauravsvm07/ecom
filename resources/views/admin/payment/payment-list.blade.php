@extends('layouts.master')
@section('content')
@section('title', 'Payment List')

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
										<th>Name</th>
										<th>Email Id</th>
										<!-- <th>SubTotal</th>
										<th>Discount</th> -->
										<th>Total</th>
										<th>Payment Status</th>
									</tr>
								</thead>

								<tbody>
									@if(count($payments) > 0)
									@foreach($payments as $row)
									<tr>
										<td>{{$row->name}} {{$row->last_name}}</td>
										<td>{{$row->email}}</td>
										<!-- td>${{$row->subtotal}}</td>
										<td>${{$row->discount}}</td> -->
										<td>${{$row->total}}</td>
										<td>@if($row->pay_status==1) <button class="btn btn-success btn-sm">Completed </button> @else <button class="btn btn-danger btn-sm"> Pending </button> @endif</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td colspan="6">No record found..</td>
									</tr>
									@endif
								</tbody>

							</table>
							{{$payments->links()}}


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
				url: "{{url('auth/delete-role')}}",
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