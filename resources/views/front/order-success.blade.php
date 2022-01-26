@extends('layouts.default')
@section('content')
@section('title', 'Order Success')

<div class="main-wrapper">
   @include('includes.front.categories')
   <div class="container">
      <div class="payment-done-wrapper mt-5">
         <div class="row">
            <div class="col-md-7 mx-auto">

               <div class="payment-done-box">
                  <span><img src="{{URL::asset('front/images/card-icon.jpg')}}" alt="" /></span>
                  <h4>Payment has been accepted.</h4>
                  <p>Thank you for your order.</p>
                  <p style="font-size: 18px;">You will next receive an email with the shipping/tracking info.</p>

                  <a href="{{url('invoice?order='.Request::get('order'))}}" class="btn btn-success"> Print Your Receipt </a>
               </div>



            </div>
         </div>
      </div>
   </div>
</div>

@stop