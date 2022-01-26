@extends('layouts.default')
@section('content')
@section('title', 'Display Products')

<div class="main-wrapper">
   <div class="container">


      @include('includes.front.categories')

      <div class="gallery-section">
         <div class="gallery-wrapper">
            <ul>

               @if(count($products) > 0)
               @foreach($products as $product)
               <li>
                  <a href="{{url('display-product-details/'.$product->slug)}}">
                     <img src="{{URL::asset('uploads/products/'.$product->featured_img)}}" alt="" />
                     <div class="madallname">
                        <h5>{{$product->name}}</h5>
                     </div>
                  </a>
               </li>
               @endforeach
               @else
               <h4 style="color: #fff;">No Product Found</h4>
               @endif




            </ul>
         </div>
         <div class="pagination-number mt-4">
            {{$products->links()}}
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

@stop