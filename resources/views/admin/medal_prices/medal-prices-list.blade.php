@extends('layouts.master')
@section('content')
@section('title', 'Medal Price List')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-sm-12">
				<div class="card">

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Size</th>
										<th>Price</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									@foreach($medals as $key=>$row)
									<tr row_id="{{$row->id}}" class="get_row_{{$row->id}}">
										<td>{{$key+1+($medals->currentPage()-1) * ($medals->perPage())}}</td>
										<td>{{$row->medal_size}}</td>
										<td>${{$row->medal_price}}</td>
										<td>
											<div class="actions">
												<a class="btn btn-sm bg-success-light" href="{{url('auth/edit-madel-price/'.$row->id)}}">
													<i class="fe fe-pencil"></i> Edit
												</a>

											</div>
										</td>
									</tr>
									@endforeach

								</tbody>

							</table>
							{{$medals->links()}}
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
				url: "{{url('auth/delete-coupon')}}",
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