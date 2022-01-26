@extends('layouts.master')
@section('content')
@if(isset($product) && !empty($product))
@section('title', 'Add Variation')
@else
@section('title', 'Add Variation')
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
                        {!! Form::model($product, ['url' => 'auth/save-copy-general-product','method' => 'post','enctype'=>'multipart/form-data']) !!}
                        <div class="row">
                            <input type="hidden" name="category_id" value="{{$product->category_id}}">
                            <input type="hidden" name="name" value="{{$product->name}}">
                            <input type="hidden" name="featured_img">
                            <input type="hidden" name="description" value="{{$product->description}}">
                            <input type="hidden" name="status" value="1">
                            <input type="hidden" name="featured_img" value="{{$product->featured_img}}">
                            <input type="hidden" name="product_id" value="{{$product->product_id}}">

                            <div class="col-xl-12">
                                <div class="form-group row">
                                    {!!Form::label('name','Price',['class'=>'col-lg-2 col-form-label'])!!}
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="price">
                                        @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="form-group row">
                                    {!!Form::label('name','Size',['class'=>'col-lg-2 col-form-label'])!!}
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="size">
                                        @error('size')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>






                        </div>

                    </div>

                    <div class="text-right">

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