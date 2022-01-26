@extends('layouts.master')
@section('content')
@section('title', 'Users List')

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
						<a href="{{url('auth/add-user')}}" class="btn btn-info">Add User</a>
					</div>
					<div class="card-body">

						<form method="get" action="{{url('auth/search-user')}}">
							<div class="row">
								<div class="col-sm-4">
									<input type="text" name="name" class="form-control" placeholder="Enter First Name" value="{{old('name')}}">
								</div>
								<div class="col-sm-4">
									<input type="text" name="email" class="form-control" placeholder="Enter Email Id" value="{{old('email')}}">
								</div>
								<div class="col-sm-4">
									<button type="submit" name="submit" class="btn btn-info">Search</button>
								</div>
							</div>

							<br><br>
						</form>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Name</th>
										<th>Email Id</th>
										<th>Phone</th>
										<th>Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									@foreach($users as $key=>$row)
									<tr row_id="{{$row->id}}" class="get_row_{{$row->id}}">
										<td>{{$key+1+($users->currentPage()-1) * ($users->perPage())}}</td>
										<td>{{$row->name}} {{$row->last_name}}</td>
										<td>{{$row->email}}</td>
										<td>{{$row->phone}}</td>
										<td>{{$row->created_at}}</td>
										<td>
											<div class="status-toggle">
												<input type="checkbox" id="status_{{$row->id}}" class="check statusBtn" @if($row->status==1) checked @endif row_id = "{{$row->id}}">
												<label for="status_{{$row->id}}" class="checktoggle">checkbox</label>
											</div>
										</td>

										<td>
											<div class="actions">
												<a class="btn btn-sm bg-success-light" href="{{url('auth/edit-user/'.$row->id)}}">
													<i class="fe fe-pencil"></i> Edit
												</a>

												<a class="btn btn-sm bg-danger-light deleteBtn" data-toggle="modal" href="#delete_modal" row_id="{{$row->id}}">
													<i class="fe fe-trash"></i> Delete
												</a>

											</div>
										</td>

									</tr>
									@endforeach

								</tbody>

							</table>

							{{$users->links()}}

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
				url: "{{url('auth/delete-user')}}",
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