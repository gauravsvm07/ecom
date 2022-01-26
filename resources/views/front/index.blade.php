@extends('layouts.default')
@section('content')
@section('title', 'Home')
   
      
      <div class="main-wrapper">
         <div class="container">
          
           @include('includes.front.categories')

            <div class="medallions-wrapper mt-4">
               <div class="row">
                  <div class="col-md-8 mx-auto">
                     <div class="testimonials">
                        <div class="inner-testimonials">
                           <div class="owl-carousel custome_slide" id="slide-testimonal">

                             
                             @foreach($banners as $banner)
                              <div class="test_img">
                                 <div class="main-reviewimage">
                                    <img src="{{URL::asset('uploads/banner/'.$banner->image)}}" alt=""/>
                                 </div>
                              </div>
                              @endforeach

                              
                              
                              
                              
                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="medallions-info text-center mt-4">
                          @php
                   $page_section = App\Helpers\Helper::getPageSection('about-heromedallions');
                   @endphp
                        {!! $page_section->description ?? '' !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
  
@stop