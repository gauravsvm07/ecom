@extends('layouts.master')
@section('content')
@section('title', 'Inquiry List')

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
						<button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('auth/delete-all-enquiry') }}">Delete All Selected</button>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th><input type="checkbox" id="master"></th>
										<th>Name</th>
										<th>Email Id</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>

									@foreach($enquiries as $key=>$row)
									<tr id="tr_{{$row->id}}">
										<td><input type="checkbox" class="sub_chk" data-id="{{$row->id}}"> </td>
										<td>{{$row->name}}</td>
										<td>{{$row->email}}</td>
										<td>{{$row->created_at}}</td>

										<td>
											<div class="actions">
												<a class="btn btn-sm bg-primary-light" href="{{url('auth/view-enquiry/'.$row->id)}}">
													<i class="fe fe-eye"></i> View
												</a>

											</div>
										</td>

									</tr>
									@endforeach

								</tbody>

							</table>

							{{$enquiries->links()}}

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- /Main Wrapper -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#master').on('click', function(e) {
			if ($(this).is(':checked', true)) {
				$(".sub_chk").prop('checked', true);
			} else {
				$(".sub_chk").prop('checked', false);
			}
		});
		$('.delete_all').on('click', function(e) {
			var allVals = [];
			$(".sub_chk:checked").each(function() {
				allVals.push($(this).attr('data-id'));
			});
			if (allVals.length <= 0) {
				alert("Please select row.");
			} else {
				var check = confirm("Are you sure you want to delete this row?");
				if (check == true) {
					var join_selected_values = allVals.join(",");
					var csrf_token = $('input[name="csrf_token"]').val();
					///alert(join_selected_values);
					$.ajax({
						url: $(this).data('url'),
						type: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
						},

						data: {
							ids: join_selected_values,
							_token: csrf_token
						},
						success: function(data) {
							if (data['success']) {
								$(".sub_chk:checked").each(function() {
									$(this).parents("tr").remove();
								});
								alert(data['success']);
							} else if (data['error']) {
								alert(data['error']);
							} else {
								alert('Whoops Something went wrong!!');
							}
						},
						error: function(data) {
							alert(data.responseText);
						}
					});
					$.each(allVals, function(index, value) {
						$('table tr').filter("[data-row-id='" + value + "']").remove();
					});
				}
			}
		});
		$('[data-toggle=confirmation]').confirmation({
			rootSelector: '[data-toggle=confirmation]',
			onConfirm: function(event, element) {
				element.trigger('confirm');
			}
		});
		$(document).on('confirm', function(e) {
			var ele = e.target;
			e.preventDefault();
			$.ajax({
				url: ele.href,
				type: 'DELETE',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
				},
				success: function(data) {
					if (data['success']) {
						$("#" + data['tr']).slideUp("slow");
						alert(data['success']);
					} else if (data['error']) {
						alert(data['error']);
					} else {
						alert('Whoops Something went wrong!!');
					}
				},
				error: function(data) {
					alert(data.responseText);
				}
			});
			return false;
		});
	});
</script>


@stop