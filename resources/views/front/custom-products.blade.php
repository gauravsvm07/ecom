@extends('layouts.default')
@section('content')
@section('title', 'Products')

<div class="main-wrapper">
   <div class="container">


      @include('includes.front.categories')

      <div class="gallery-section">
         <div class="gallery-wrapper">
            <div class="product-detail-panel">
               <p> &nbsp;&nbsp; {{$category->description}}</p>
            </div>
            <ul>

               @if(count($products) > 0)
               @foreach($products as $product)
               <li>
                  <a href="{{url('custom-product-details/'.$product->slug)}}">
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
   </div>
</div>

@stop