@extends('layouts.default')
@section('content')
@section('title', 'Product Details')


<div class="main-wrapper">
   <div class="container">


      @include('includes.front.categories')

      <div class="custom-order mt-5">
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <div class="product-pic">
                     <img src="{{URL::asset('uploads/products/'.$product->featured_img)}}" alt="">
                  </div>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-12">


                  @if (session('msg'))
                  <div class="col-sm-12">
                     <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('msg') }}
                     </div>
                  </div>
                  @endif

                  <form method="post" id="cartform" action="{{url('add-cart')}}">
                     @csrf
                     <div class="product-detail-panel">
                        <h2>{{$product->name}}</h2>
                        @if($product->description!='') <p> {!!$product->description!!} </p> @endif

                        <div class="stock">Other Displays </div>
                        <br>
                        @foreach($other_products as $other)
                        <a href="{{url('display-product-details/'.$other->slug)}}" class="btn btn-secondary">{{$other->name}} </a>
                        @endforeach




                        <ul class="product-button-group mt-4">
                           <li>

                              <div class="selectqty">
                                 <div class="input-group">
                                    <span class="input-group-prepend">
                                       <button type="button" class="btn btn-outline-secondary btn-number cartBtn" disabled="disabled" data-type="minus" data-field="quant[1]">
                                          <span class="fa fa-minus"></span>
                                       </button>
                                    </span>
                                    <input type="text" name="quant[1]" qty="quant[1]" class="form-control input-number quant_field" value="1" min="1" max="10" id="get_qun">
                                    <span class="input-group-append">
                                       <button type="button" class="btn btn-outline-secondary btn-number cartBtn" data-type="plus" data-field="quant[1]">
                                          <span class="fa fa-plus"></span>
                                       </button>
                                    </span>
                                 </div>
                              </div>

                           </li>

                        </ul>
                        <div class="productbtn mt-5">

                           <input type="hidden" name="product_type" value="display">
                           <input type="hidden" name="cart_product_id" id="cart_product_id" value="{{$product->product_id}}">
                           <input type="hidden" name="cart_quantity" id="cart_quantity" value="1">
                           <input type="hidden" name="product_name" id="get_product_name" value="{{$product->name}}">
                           <input type="hidden" name="image" id="image" value="noimg.jpg">
                           <input type="hidden" name="custom_border" id="custom_border" value="N/A">
                           <input type="hidden" name="custom_shape" id="custom_shape" value="N/A">

                           <input type="hidden" name="cart_size" id="cart_size" value="{{$product->size}}">
                           <input type="hidden" name="cart_price" id="cart_price" value="{{App\Helpers\Helper::getMedalPriceBySize($product->size)}}">

                           @auth
                           <button class="common_button w-100 cartBtn" href="#">Place an Order</button>
                           @endauth

                           @php
                           $full_url = url()->full();
                           @endphp

                           @guest
                           <a class="common_button w-100" href="{{url('signin?back_url='.$full_url)}}">Place an Order</a>
                           @endguest

                           <div class="col-md-6 my-3 pl-0">
                              <div class="mb-3">
                                 <label for="address">P.O. or Reference</label>
                                 <input type="text" class="form-control" name="billing_reference" value="@if(Session::has('billing_reference')) {{ Session::get('billing_reference')}}  @endif">
                              </div>
                           </div>

                        </div>



                     </div>
               </div>








            </div>
         </div>
      </div>
   </div>
</div>
</div>





<!-- Modal -->
<div class="modal fade" id="enqModal" role="dialog">
   <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title">INFORMATION</h4>
         </div>
         <div class="modal-body">
            <form action="{{url('save-product-enquiry')}}" enctype="multipart/form-data" method="post">
               @csrf
               <div class="form-group">
                  <label for="email">Full Name:</label>
                  <input type="text" class="form-control" id="name" name="name" required="" value="@auth {{ Auth::user()->name;}} {{ Auth::user()->last_name;}} @endauth">
               </div>

               <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" name="email" id="email" value="@auth {{ Auth::user()->email;}} @endauth" required="">
               </div>

               <div class="form-group">
                  <label for="mobile">Phone:</label>
                  <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" value="@auth {{ Auth::user()->phone;}} @endauth" required="">
               </div>

               <input type="hidden" name="size" id="size" value="">
               <input type="hidden" name="border" id="border" value="">
               <input type="hidden" name="shape" id="shape" value="">
               <input type="hidden" name="image" id="image" value="">


               <input type="hidden" name="product_name" id="get_product_name" value="{{$product->name}}">
               <input type="hidden" name="product_price" id="get_product_price">
               <input type="hidden" name="product_size" id="get_product_size">
               <input type="hidden" name="product_quantity" id="get_product_quantity">
               <input type="hidden" name="enq_type" value="display">


               <button type="submit" class="btn btn-success">Submit</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>

   </div>
</div>

<script>
   $(document).ready(function() {
      $(".quant_field").change(function() {
         var quan = $(".quant_field").val();
         $('#cart_quantity').val(quan);
      });

   });
</script>




@stop