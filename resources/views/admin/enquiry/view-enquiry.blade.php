@extends('layouts.master')
@section('content')
@section('title', 'View Inquiry')

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
								<tbody>
									<tr>
										<th>Name</th>
										<td>{{$enquiry->name}}</td>
									</tr>

									<tr>
										<th>Email Id</th>
										<td>{{$enquiry->email}}</td>
									</tr>


									<tr>
										<th>Hear About</th>
										<td>{{$enquiry->hear_about}}</td>
									</tr>

									<tr>
										<th>Message</th>
										<td>{{$enquiry->message}}</td>
									</tr>


								</tbody>

							</table>
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

		$('.statusBtn').on('click', function() {
			var row_id = $(this).attr('row_id');
			var _token = $('input[name="csrf_token"]').val();
			$.ajax({
				url: "{{url('auth/update-user-status')}}",
				method: "post",
				data: {
					id: row_id,
					_token: _token
				},
				success: function(data) {}

			});
		});



	});
</script>



@include('admin/category/edit-model')
@include('includes/admin/delete-model')
@stop