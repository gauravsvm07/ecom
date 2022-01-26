@extends('layouts.default')
@section('content')
@section('title', 'About Us')

      <div class="main-wrapper">
         <div class="container">

              @include('includes.front.categories')

               @php
      $abt_section = App\Helpers\Helper::getPageSection('about-us');
       @endphp
            <div class="medallions-wrapper mt-5">
               <div class="row">
                  <div class="col-md-10 mx-auto">
                     <div class="location-pic">
                      <img class="w-100" src="{{URL::asset('uploads/pages/'.$abt_section->image)}}" alt=""/> 
                     </div>
                  </div>
                  <div class="col-md-10 mx-auto">
                     <div class="medallions-info text-center mt-4">
                        {!!$abt_section->description!!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      @stop
