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
                  <div class="product-detail-panel">
                     <h2>{{$product->name}}</h2>
                     @if($product->description!='') {!!$product->description!!} @endif
                     <div class="stock">In Stock</div>


                     <!-- <ul class="product-button-group mt-4">
                        <li>
                           <div class="selectqty">
                              <div class="input-group">
                                 <span class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                       <span class="fa fa-minus"></span>
                                    </button>
                                 </span>
                                 <input type="text" name="quant[1]" qty="quant[1]" class="form-control input-number" value="1" min="1" max="10" id="get_qun">
                                 <span class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                                       <span class="fa fa-plus"></span>
                                    </button>
                                 </span>
                              </div>
                           </div>
                        </li>
                     </ul> -->
                     <br>
                     <!-- {!! $product->description !!} -->

                     <div class="productbtn mt-5">
                        <a class="common_button w-100" href="javascript:void(0)" data-toggle="modal" data-target="#enqModal">Place an Order</a>
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
            <span style="font-size: 15px;">Each custom design includes 3 medallions. Please contact us for higher quantity needs. </span>
            <hr>
            <form action="{{url('add-cart')}}" enctype="multipart/form-data" method="post">
               @csrf
               <div class="form-group">
                  <label for="image">Image:</label>
                  <input type="file" class="form-control" name="image" id="image">
               </div>

               <div class="form-group">
                  <label for="size">Size:</label>
                  <input type="hidden" name="cart_quantity" id="product_quantity" value="1">
                  <select name="cart_size" class="form-control" id="cart_size" required>
                     <option value="custom-2">Custom 2</option>
                     <option value="custom-3">Custom 3</option>
                     <option value="custom-4">Custom 4</option>
                  </select>
               </div>

               <div class="form-group">
                  <label for="size">Border :</label>
                  <input type="text" class="form-control" name="custom_border" id="border">
               </div>

               <div class="form-group">
                  <label for="shape">Shape :</label>
                  <select name="custom_shape" class="form-control">
                     <option value="Irregular Shape">Irregular Shape</option>
                     <option value="Star">Star</option>
                     <option value="Badge">Badge</option>
                     <option value="Oval">Oval</option>
                     <option value="Round">Round</option>
                     <option value="Shape of image submitted">Shape of image submitted</option>
                  </select>
               </div>



               <input type="hidden" name="product_type" value="custom">
               <input type="hidden" name="billing_reference" value="">
               <input type="hidden" name="cart_product_id" id="cart_product_id" value="{{$product->product_id}}">
               <input type="hidden" name="product_name" id="get_product_name" value="{{$product->name}}">
               <input type="hidden" name="cart_price" value="29">

               @auth
               <button class="common_button w-100 cartBtn" href="#">Place an Order</button>
               @endauth

               @php
               $full_url = url()->full();
               @endphp

               @guest
               <a class="common_button w-100" href="{{url('signin?back_url='.$full_url)}}">Place an Order</a>
               @endguest
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
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         }
      });



      /////////////////  size dropdown Start ////////////
      $('.sizes_drop').on('click', function() {
         var id = $(this).attr("id");
         var qun = $('#get_qun').val();
         var csrf_token = $('input[name="csrf_token"]').val();
         //alert(id);
         $.ajax({
            url: "{{url('get-price-size')}}",
            type: "get",
            data: {
               id: id,
               _token: csrf_token
            },
            success: function(data) {
               ///alert('success');get_qun
               $('#get_price').text('$' + data.price);
               $('#get_size').text(data.size + ' inch');

               $('#get_product_price').val('$' + data.price);
               $('#get_product_size').val(data.size);
               $('#get_product_quantity').val(qun);


               //$('.success_msg').text(data.msg);   
            }


         });

      });



   });
</script>




@stop