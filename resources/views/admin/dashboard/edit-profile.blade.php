<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Personal Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						
					<form method="post" action="{{url('auth/update-profile')}}" enctype="multipart/form-data">
						@csrf
						<div class="row form-row">
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label> Name</label>
									<input type="text" name="name" class="form-control" value="{{$user->name}}">
								</div>
							</div>
							
							
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label>Email ID</label>
									<input type="email" name="email" class="form-control" value="{{$user->email}}">
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="phone" class="form-control" value="{{$user->phone}}">
								</div>
							</div>

							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label>Image</label>
									<input type="file" name="image" class="form-control">
									<input type="hidden" name="old_image" value="{{$user->image}}">
								</div>
							</div>

                            <div class="col-12 col-sm-12">
								<div class="form-group">
									<label>About</label>
									<textarea class="form-control" name="about">{{$user->about}}</textarea>
								</div>
							</div>

							
													
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control" name="address">{{$user->address}}</textarea>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>