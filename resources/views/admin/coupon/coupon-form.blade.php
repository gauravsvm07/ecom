@extends('layouts.master')
@section('content')

@if(isset($coupon) && !empty($coupon))
@section('title', 'Edit Coupon')
@else
@section('title', 'Add Coupon')
@endif

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
						{!! Form::model($coupon, ['url' => 'auth/save-coupon','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">
							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Coupon Code',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('coupon_code',old('coupon_code'),['class'=>'form-control'])!!}

										@error('coupon_code')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-6">
								<div class="form-group row">
									{!!Form::label('name','Coupon Discount(%)',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('coupon_discount',old('coupon_discount'),['class'=>'form-control'])!!}

										@error('coupon_discount')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>




							<div class="col-xl-6">
								<div class="form-group row">
									{!! Form::label('name','Status',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,
										['class' => 'form-control chosen-type', 'placeholder' => 'Please Choose']) !!}

										@error('status')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>


						</div>

					</div>

					<div class="text-right">
						@if($coupon)
						{!! Form::hidden('id',old('id')) !!}
						<input type="hidden" name="type" value="percent">
						<input type="hidden" name="valid_from" value="">
						<input type="hidden" name="valid_to" value="">
						<input type="hidden" name="minimum_target" value="0">
						@endif
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