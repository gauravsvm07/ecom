@extends('layouts.master')
@section('content')
@section('title', 'View Member')

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
										<td>{{$user->name}}</td>
									</tr>

									<tr>
										<th>Email Id</th>
										<td>{{$user->email}}</td>
									</tr>


									<tr>
										<th>Phone</th>
										<td>{{$user->phone}}</td>
									</tr>

									<tr>
										<th>Company Name</th>
										<td>{{$user->company_name}}</td>
									</tr>

									<tr>
										<th>City</th>
										<td>{{$user->city}}</td>
									</tr>


									<tr>
										<th>State</th>
										<td>{{$user->state}}</td>
									</tr>

									<tr>
										<th>URL</th>
										<td>{{$user->social_url}}</td>
									</tr>

									<tr>
										<th>Address</th>
										<td>{{$user->address}}</td>
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
	$(document).ready(function(){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
			}
		});

		$('.statusBtn').on('click',function(){
			var row_id =$(this).attr('row_id');	
			var _token = $('input[name="csrf_token"]').val();
			$.ajax({
				url: "{{url('auth/update-user-status')}}",
				method: "post",
				data: {id:row_id,_token: _token},
				success:function(data)
				{
				}

			});
		});



	});	
</script>



@include('admin/category/edit-model')
@include('includes/admin/delete-model')
@stop
