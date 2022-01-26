@extends('layouts.default')
@section('content')
@section('title', 'About Us')

<div class="main-wrapper">
    <div class="container">

        <div class="row">
            <div class="col-md-12">


                @if($cart_count > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-white">Product</th>
                            <!-- <th class="text-white">test</th> -->
                            <th class="text-white">Size</th>
                            <th class="text-white"> Quantity</th>
                            <th class="text-white">Price</th>
                            <th class="text-white">Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach($items as $row)
                        <form method="post" action="{{url('update-cart')}}">
                            @csrf
                            <tr>
                                <td>
                                    <div class="media">
                                        <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{URL::asset('uploads/products/'.$row->attributes->image)}}" style="width: 72px; height: 72px;"> </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="#" class="text-white">{{$row->name;}}</a></h4>
                                        </div>
                                    </div>
                                </td>
                                <!-- <td class="text-white">{{$row->attributes->cart_sno}}</td> -->
                                <td class="text-white">{{$row->attributes->size}}</td>
                                <td>
                                    <input type="number" min="1" name="quantity" class="form-control" id="exampleInputEmail1" value="{{$row->quantity}}">
                                </td>
                                <td class="text-white">${{$row->price}}</td>
                                <td class="text-white">${{number_format($row->price * $row->quantity,2)}}</td>

                                <td>
                                    <input type="hidden" name="old_quantity" value="{{$row->quantity}}">
                                    <input type="hidden" name="product_id" value="{{$row->id}}">
                                    <input type="hidden" name="price" value="{{$row->price}}">
                                    <input type="hidden" name="size" value="{{$row->attributes->size}}">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        Update
                                    </button>

                                    <a href="{{url('remove-cart/'.$row->id)}}" class="btn btn-danger btn-sm">
                                        <span class="glyphicon glyphicon-remove"></span> Remove
                                    </a>
                                </td>
                            </tr>
                        </form>
                        @endforeach





                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td>
                                <h5 class="text-white">Subtotal</h5>
                            </td>
                            <td class="text-right text-white">
                                <h5><strong>${{number_format($subTotal,2)}}</strong></h5>
                            </td>
                        </tr>

                        <tr>

                            <td colspan="3">
                                <div class="discount-code">

                                    <form method="post" action="{{url('check-coupon')}}">
                                        @csrf
                                        <p>Discount Code:</p> <input type="text" name="coupon_code" value="{{old('coupon_code')}}"><button type="submit" class="btn btn-success">Check</button> 
                                        @error('coupon_code') <p class="text-white">{{$message}} </p> @enderror
                                        @if (session('couponMsg')) <p class="text-white"> {{ session('couponMsg') }} </p> @endif
                                    </form>

                                </div>
                            </td>

                            <td>
                                <h5 class="text-white">Discount</h5>
                            </td>
                            <td class="text-right text-white">
                                <h5><strong>{{$get_discount}}%</strong></h5>
                                @if($get_discount != 0) <small>${{number_format(($subTotal*$get_discount/100) ,2)}}</small> @endif
                            </td>
                        </tr>

                        <tr>
                            <td>  </td>
                            <td></td>
                            <td>   </td>
                            <td>
                                <h3 class="text-white">Total</h3>
                            </td>
                            <td class="text-right text-white">
                                <h3><strong class="text-white"> @if($get_discount != 0) ${{number_format( $subTotal - ($subTotal*$get_discount/100)   ,2)}} @else ${{number_format($subTotal,2)}} @endif</strong></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-white">P.O. or Reference: @if(Session::has('billing_reference')) {{ Session::get('billing_reference')}} @endif </td>

                            <td>
                                <a href="{{url('products')}}" class="btn btn-info text-white"><span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping</a>
                            </td>
                            <td>
                                @php
                                $full_url = url()->full();
                                @endphp

                                @guest
                                <a href="{{url('signin?back_url='.$full_url)}}" class="btn btn-success text-white"><span class="glyphicon glyphicon-play"></span> Checkout</a>
                                @endguest

                                @auth
                                <a href="{{url('checkout')}}" class="btn btn-success text-white"><span class="glyphicon glyphicon-play"></span> Checkout</a>
                                @endauth

                            </td>
                        </tr>
                    </tbody>
                </table>
                @else
                <br><br>
                <p>Your cart is currently empty.</p>
                <a href="{{url('products')}}" class="btn btn-warning">Return to shop</a>
                @endif



            </div>
        </div>


    </div>
</div>

@stop