@extends('layouts.default')
@section('content')
@section('title', 'Products')

      <div class="main-wrapper">
         <div class="container">
            

           @include('includes.front.categories')

            <div class="gallery-section">
               <div class="gallery-wrapper">
                  <ul>
                    
                     @if(count($products) > 0)
                     @foreach($products as $product)

                     <li>

                       
                        <a href="{{url('product-details/'.$product->slug)}}">
                           <img src="{{URL::asset('uploads/products/'.$product->featured_img)}}" alt=""/>
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
      

      <script>
   $(document).ready(function(){
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         }
      });

    $('.cartBtn').on('click',function(){
     var qun_prd =  $('#get_qun').val();
     var price_prd = $('#get_price').text(data.price); 

    });


      /////////////////  size dropdown Start ////////////
      $('.sizes_drop').on('click',function(){
         var id =  $(this).attr("id");
          var qun =  $('#get_qun').val();
         var csrf_token = $('input[name="csrf_token"]').val();
          //alert(id);
         $.ajax({
            url: "{{url('get-price-size')}}",
            type: "get",
            data: {id:id,_token:csrf_token},
            success:function(data)
            {
              ///alert('success');get_qun
               $('#get_price').text('$'+data.price); 
               $('#get_size').text(data.size);  

                $('#get_product_price').val('$'+data.price);
                $('#get_product_size').val(data.size);
                $('#get_product_quantity').val(qun);

               
               //$('.success_msg').text(data.msg);   
            }
            

       });

      });



   });  
</script>
      @stop
