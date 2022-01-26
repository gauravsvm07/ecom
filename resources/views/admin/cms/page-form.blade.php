@extends('layouts.master')
@section('content')

@if(isset($page) && !empty($page))
@section('title', 'Edit Page')
@else
@section('title', 'Add Page')
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
						{!! Form::model($page, ['url' => 'auth/save-page','method' => 'post','enctype'=>'multipart/form-data']) !!}
						<div class="row">

							<div class="col-xl-12">
								<div class="form-group row">
									{!! Form::label('name','Page Category',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('category_id',[''=>'--Select Category--'] +$page_category ,old('category_id'),['class'=>'form-control pageCat','id'=>'category_id']) !!}

										@error('category_id')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!! Form::label('name','Page Section',['class'=>'col-lg-3 col-form-label']) !!}
									<div class="col-lg-9">
										{!! Form::select('section_id',[''=>'--Select Category--'] +$page_section ,old('section_id'),['class'=>'form-control','id'=>'page_section']) !!}

										@error('section_id')
										<span class="text-danger">{{$message}}</span>
										@enderror

									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Title',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::text('title',old('title'),['class'=>'form-control'])!!}

										@error('title')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','SubTitle',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
									{!!Form::text('sub_title',old('sub_title'),['class'=>'form-control'])!!}
										@error('sub_title')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Short Description',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
									{!!Form::textarea('short_description',old('short_description'),['class'=>'form-control'])!!}
										@error('short_description')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Description',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
									{!!Form::textarea('description',old('description'),['class'=>'form-control'])!!}
										@error('description')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<div class="form-group row">
									{!!Form::label('name','Image',['class'=>'col-lg-3 col-form-label'])!!}
									<div class="col-lg-9">
										{!!Form::file('pageImg',['name'=>'image','class'=>'form-control','id'=>'pageImg'])!!}			
									</div>
								</div>
							</div>

							<div class="col-xl-12 preview_image" style="display: none">
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Image Preview</label>
									<div class="col-lg-9">
										<img id="getPageImg" src="#" alt="your image" style="height: 150px;width: 150px;">
									</div>
								</div>
							</div>

							<div class="col-xl-12">
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
						@if($page)
						{!! Form::hidden('old_image', $page->image) !!}   
						{!! Form::hidden('id',old('id')) !!}
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

<script>
$('document').ready(function(){
$('.pageCat').on('change',function(){
var category_id = $('#category_id').val();

$.ajax({
url: "{{url('auth/get-page-section')}}",
type: "get",
data: {category_id:category_id},
success:function(data)
{
	if(data){
        $("#page_section").empty();
        $("#page_section").append('<option>Select State</option>');
        $.each(data.section,function(key,value){
          $("#page_section").append('<option value="'+value.id+'">'+value.name+'</option>');
        });
      
      }else{
        $("#page_section").empty();
      }
}

});

});
});	
</script>


<script>
	categoryImg.onchange = evt => {
		const [file] = pageImg.files
		if (file) {
			getPageImg.src = URL.createObjectURL(file)
			$('.preview_image').show();
		}
	}	
</script>

<script>
CKEDITOR.replace('description');
</script>
@stop


