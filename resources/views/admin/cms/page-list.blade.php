@extends('layouts.master')
@section('content')
@section('title', 'CMS')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<!-- <div class="card-header">
						<a href="{{url('auth/add-page')}}" class="btn btn-info">Add Page</a>
					</div> -->
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Title</th>
										<th>Image</th>
										<th>Category</th>
										<th>Section</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									@foreach($pages as $key=>$row)
									<tr row_id="{{$row->id}}" class="get_row_{{$row->id}}">
										<td>{{$key+1+($pages->currentPage()-1) * ($pages->perPage())}}</td>
										<td>{{$row->title}}</td>
										<td>
											@if(file_exists(public_path().'/uploads/pages/'.$row->image) && !empty($row->image))
											<img src="{{ URL::asset('uploads/pages/'.$row->image) }}" height="100px; width:100px;">
											@else
											<img src="{{ URL::asset('admin/img/default.jpg') }}" height="100px; width:100px;">
											@endif

										</td>
										<td>{{$row->page_category->name}}</td>
										<td>{{$row->page_section->name}}</td>
										<td> @if($row->status==1)Active @else Inactive @endif</td>
										<td>
											<div class="actions">
												<a class="btn btn-sm bg-success-light" href="{{url('auth/edit-page/'.$row->id)}}">
													<i class="fe fe-pencil"></i> Edit
												</a>
												<!-- <a class="btn btn-sm bg-danger-light deleteBtn" data-toggle="modal" href="#delete_modal" row_id="{{$row->id}}">
													<i class="fe fe-trash"></i> Delete
												</a> -->
											</div>
										</td>
									</tr>
									@endforeach

								</tbody>

							</table>
							{{$pages->links()}}
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
				url: "{{url('auth/delete-page')}}",
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

@include('admin/category/edit-model')
@include('includes/admin/delete-model')
@stop