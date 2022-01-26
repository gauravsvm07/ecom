@extends('layouts.master')
@section('content')

@section('title', 'Edit Medal Price')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<div class="card-body">
						@if (session('msg'))
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert">×</button>
							{{ session('msg') }}
						</div>
						@endif
						{!! Form::model($medal, ['url' => 'auth/save-madel-price','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">
							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Price',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('medal_price',old('medal_price'),['class'=>'form-control'])!!}

										@error('medal_price')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>


						</div>

					</div>

					<div class="text-right">
						{!! Form::hidden('id',old('id')) !!}
						{!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>


</div>
</div>
<!-- /Main Wrapper -->

@stop