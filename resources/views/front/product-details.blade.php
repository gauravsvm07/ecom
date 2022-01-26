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

                  <form method="post" id="cartform" action="{{url('add-cart')}}">
                     @csrf
                     <div class="product-detail-panel">
                        <h2>{{$product->name}}</h2>
                        @if($product->description!='') {!!$product->description!!} @endif
                        <div class="stock">In Stock</div>

                        <div class="price">@auth<b id="get_price"></b> @endauth &nbsp;&nbsp;&nbsp;&nbsp; <span id="get_size"> </span></div>
                        <span id="sizemsg" style="color: #fff;"></span>
                        <ul class="product-button-group mt-4">
                           <li>

                              <div class="selectqty">
                                 <div class="input-group">
                                    <span class="input-group-prepend">
                                       <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                          <span class="fa fa-minus"></span>
                                       </button>
                                    </span>
                                    <input type="text" name="quant[1]" qty="quant[1]" class="form-control input-number quant_field" value="1" min="1" max="10">
                                    <span class="input-group-append">
                                       <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                                          <span class="fa fa-plus"></span>
                                       </button>
                                    </span>
                                 </div>
                              </div>

                           </li>
                           <li class="dropdown open ml-3">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Size
                                 <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                 @foreach($product_price_size as $price_size)
                                 <a href="javascript:void(0)" style="color: #000;">
                                    <li class="sizes_drop" id="{{$price_size->product_id}}">{{$price_size->size}}</li>
                                 </a>
                                 @endforeach
                              </ul>
                           </li>
                        </ul>
                        <input type="hidden" name="product_type" value="general">
                        <input type="hidden" name="cart_product_id" id="cart_product_id" value="{{$product->product_id}}">
                        <input type="hidden" name="cart_price" id="cart_price">
                        <input type="hidden" name="cart_size" id="cart_size">
                        <input type="hidden" name="cart_quantity" id="cart_quantity" value="1">
                        <input type="hidden" name="image" id="image" value="noimg.jpg">
                        <input type="hidden" name="custom_border" id="custom_border" value="N/A">
                        <input type="hidden" name="custom_shape" id="custom_shape" value="N/A">

                        <div class="productbtn mt-5">
                           @auth
                           <button class="common_button w-100 cartBtn" href="#">Place an Order</button>
                           @endauth

                           @php
                           $full_url = url()->full();
                           @endphp

                           @guest
                           <a class="common_button" href="{{url('signin?back_url='.$full_url)}}">Place an Order</a>
                           @endguest

                           <div class="col-md-6 my-3 pl-0">
                              <div class="mb-3">
                                 <label for="address">P.O. or Reference</label>
                                 <input type="text" class="form-control" name="billing_reference" value="@if(Session::has('billing_reference')) {{ Session::get('billing_reference')}}  @endif">
                              </div>
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


<script>
   $(document).ready(function() {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         }
      });


      $('.cartBtn').on('click', function() {
         var cart_size = $('#cart_size').val();
         if (cart_size == 0) {
            //alert('Please select cart size');
            $('#sizemsg').text('Please select product size.');
            $('#cartform').attr('action', 'javascript:void(0)');
            $('#cartform').attr('method', 'get');
         }
      });



      $(".quant_field").change(function() {
         var quan = $(".quant_field").val();
         $('#cart_quantity').val(quan);
      });


      /////////////////  size dropdown Start ////////////
      $('.sizes_drop').on('click', function() {
         var id = $(this).attr("id");
         var qun = $('#get_qun').val();
         var csrf_token = $('input[name="csrf_token"]').val();
         $.ajax({
            url: "{{url('get-price-size')}}",
            type: "get",
            data: {
               id: id,
               _token: csrf_token
            },
            success: function(data) {
               ///alert('success');get_qun
               ///alert(data.product_id);
               $('#get_price').text('$' + data.price);
               $('#get_size').text(data.size + ' inch');

               $('#get_product_price').val('$' + data.price);
               $('#get_product_size').val(data.size);
               $('#cart_product_id').val(data.product_id);
               $('#get_product_quantity').val(qun);

               $('#cart_price').val(data.price);
               $('#cart_size').val(data.size);
               $('#sizemsg').text('');
               $('#cartform').attr('action', '../add-cart');
               $('#cartform').attr('method', 'post');

               //$('.success_msg').text(data.msg);   
            }


         });

      });



   });
</script>
@stop