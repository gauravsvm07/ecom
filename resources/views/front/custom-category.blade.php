@extends('layouts.default')
@section('content')
@section('title', 'Custom Products')

<div class="main-wrapper">
   <div class="container">


      @include('includes.front.categories')

      <div class="custom-order mt-5">
         <div class="row">
            <div class="col-md-12">
               @php
               $desc_section = App\Helpers\Helper::getPageSection('custom-page-description');
               @endphp
               <div class="medallions-info text-center">
                  {!!$desc_section->description!!}
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">
               <div class="custom-link mt-4">
                  <ul>
                     @foreach($categories as $row)
                     <li><a href="{{url('custom/'.$row->slug)}}">{{$row->title}}</a></li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>

         @if(count($banners) > 0)
         <div class="row">
            <div class="col-md-12">
               <div class="testimonials">
                  <div class="inner-testimonials">
                     <div class="owl-carousel custome_slide" id="slide-testimonal">
                        @foreach($banners as $banner)
                        <div class="test_img">
                           <div class="main-reviewimage">
                              <img src="{{URL::asset('uploads/banner/'.$banner->image)}}" alt="" />
                           </div>
                        </div>
                        @endforeach

                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endif

      </div>


   </div>
</div>

@stop