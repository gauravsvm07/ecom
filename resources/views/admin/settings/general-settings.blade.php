@extends('layouts.master')
@section('content')
@section('title', 'General Settings')

<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		@include('includes/admin/breadcrumb')
		<!-- /Page Header -->

		<div class="row">

			<div class="col-12">

				<!-- General -->

				<div class="card">
					
					<div class="card-body">

						@if (session('msg'))
                       <div class="alert alert-success" role="alert">
	                  <button type="button" class="close" data-dismiss="alert">×</button>
	                 {{ session('msg') }}
                       </div>
						@endif

						{!! Form::model($globalSetting, ['url' => 'auth/update-setting', 'method'=>'post']) !!} 

						   <div class="form-group">
								{{Form::label('name','Webiste Name')}}
								{!! Form::text('sitename',old('sitename'),['class'=>'form-control']) !!}
							</div>
                                
							<div class="form-group">
								{{Form::label('name','Meta Title')}}
								{!! Form::textarea('default_meta_title',old('default_meta_title'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Meta Description')}}
								{!! Form::textarea('default_meta_description',old('default_meta_description'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Email Id')}}
								{!! Form::text('email',old('email'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Contact Heading')}}
								{!! Form::text('contact_heading',old('contact_heading'),['class'=>'form-control']) !!}
							</div>
							
								<div class="form-group">
								{{Form::label('name','Address')}}
								{!! Form::text('address',old('address'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Office Contact No')}}
								{!! Form::text('office_number',old('office_number'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Mobile Number')}}
								{!! Form::text('mobile_number',old('mobile_number'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Facebook')}}
								{!! Form::text('facebook',old('facebook'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Instagram')}}
								{!! Form::text('instagram',old('instagram'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Twitter')}}
								{!! Form::text('twitter',old('twitter'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Linkedin')}}
								{!! Form::text('linkedin',old('linkedin'),['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{{Form::label('name','Pinterest')}}
								{!! Form::text('pinterest',old('pinterest'),['class'=>'form-control']) !!}
							</div>

							 <div class="form-group mb-0">
							 	{!! Form::submit('submit',['class'=>'btn btn-info']) !!}
							 </div>

						{!!Form::close() !!}
					</div>
				</div>

				<!-- /General -->

			</div>
		</div>

	</div>			
</div>
<!-- /Page Wrapper -->

@stop