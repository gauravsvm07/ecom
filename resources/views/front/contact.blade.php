@extends('layouts.default')
@section('content')
@section('title', 'Contact Us')

<style>
   .unselectable {
      -webkit-user-select: none;
      -webkit-touch-callout: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      color: #cc0000;
   }
</style>

<div class="main-wrapper">
   <div class="container">

      @include('includes.front.categories')

      <div class="contact-wrapper mt-5">
         <div class="row">
            <div class="col-xl-8 col-sm-10 mx-auto text-center">

               <div class="contact-info">
                  <h3>{{App\Helpers\Helper::getSetting('contact_heading')}}</h3>
                  <p>{{App\Helpers\Helper::getSetting('address')}}</p>
                  <ul>
                     <li class="unselectable"><em>Office</em><b style="color: #F1E1A3;">{{App\Helpers\Helper::getSetting('office_number')}}</b></li>
                     <li class="unselectable"><em>Cell</em><b style="color: #F1E1A3;">{{App\Helpers\Helper::getSetting('mobile_number')}}</b></li>
                     <li><em>Email</em><b><a href="mailto:{{App\Helpers\Helper::getSetting('email')}}">{{App\Helpers\Helper::getSetting('email')}}</a></b></li>
                  </ul>

               </div>
            </div>

         </div>
      </div>
   </div>
</div>

@stop