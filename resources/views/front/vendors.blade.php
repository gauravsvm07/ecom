@extends('layouts.default')
@section('content')
@section('title', 'Vendors')

<div class="main-wrapper">
   <div class="container">

      @include('includes.front.categories')


      <div class="priceing-sheet mt-4">
         <div class="row">
            <div class="col-lg-10 col-xl-8 mx-auto">
               <div style="color:#fff;">
                  <h5>TO REQUEST A PRICING SHEET PLEASE FILL OUT THE FORM BELOW.</h5>
                  <div class="priceing-form mt-4">
                     @if (session('msg'))
                     <div class="col-sm-12">
                        <div class="alert alert-success" role="alert">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           {{ session('msg') }}
                        </div>
                     </div>
                     @endif
                     <form class="row" method="post" action="{{url('save-enquiry')}}">
                        @csrf
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>Full Name</label>
                              <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="">
                              @error('name')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>Email</label>
                              <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="">
                              @error('email')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label>How did you hear about us?</label>
                              <input type="text" name="hear_about" class="form-control" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label>Message</label>
                              <textarea class="form-control" name="message" rows="3" id="comment" placeholder="">{{old('message')}}</textarea>
                              @error('message')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-12 mt-3">
                           <div class="form-group">
                              <div class="account-btn">
                                 <input type="hidden" name="tokn" value="RsA}HHyNduFu">
                                 <button type="submit" name="submit" class="common_button">Submit</button>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 mt-4">
                           <div class="form-group">
                              <div class="payment-icons">
                                 <ul>
                                    <li><a href=""> <img src="{{URL::asset('front/images/visa-icon01.jpg')}}" alt="" /></a></li>
                                    <li><a href=""> <img src="{{URL::asset('front/images/visa-icon02.jpg')}}" alt="" /></a></li>
                                    <li><a href=""> <img src="{{URL::asset('front/images/visa-icon03.jpg')}}" alt="" /></a></li>
                                    <li><a href=""> <img src="{{URL::asset('front/images/visa-icon04.jpg')}}" alt="" /></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@stop