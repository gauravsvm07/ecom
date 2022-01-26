@extends('layouts.default')
@section('content')
@section('title', 'About Us')

<div class="main-wrapper">
  <div class="container">

    <div class="row">
      <div class="col-sm-12 col-md-10 col-md-offset-1">



        <div class="row">

          <div class="col-md-4 order-md-2 mb-4">
            <br> <br>
            <a href="{{url('/')}}" class="btn btn-secondary" class="btn btn-warning"> Back to Home </a>
            <br> <br>
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-white">Your cart</span>
              <span class="badge badge-secondary badge-pill">{{$cartTotal}}</span>
            </h4>
            <ul class="list-group mb-3">


              @foreach($items as $row)
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">{{$row->name}}</h6>
                </div>
                <span class="text-muted">${{$row->price * $row->quantity}}</span>
              </li>
              @endforeach


              @php
              $user_id = Auth::user()->id;
              $orderCount = App\Helpers\Helper::userOrderItemCount($user_id);
              if($orderCount < 1) { $discount=$subTotal * 20 / 100; } else { $discount=0;} @endphp <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Discount</h6>
                </div>
                <span class="text-success">-${{$discount}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>${{$subTotal-$discount}}</strong>
                </li>
            </ul>


            @if (session('couponMsg'))
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{ session('couponMsg') }}
            </div>
            @endif
            <!-- <form class="card p-2" method="post" action="{{url('check-coupon')}}">
            @csrf
            <div class="input-group">
              <input type="text" class="form-control" name="coupon_code" placeholder="Promo code">

              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">Redeem</button>
              </div>
              @error('coupon_code')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </form> -->
          </div>
          <div class="col-md-8 order-md-1">
            <h4 class="mb-3 text-white">Billing address</h4>

            <form class="needs-validation" method="post" action="{{url('order-process')}}">
              @csrf
              <div class="billing">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="firstName" class="text-white">First name</label>
                    <input type="text" class="form-control" name="billing_first_name" value="{{Auth::user()->name}}">
                    @error('billing_first_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName" class="text-white">Last name</label>
                    <input type="text" class="form-control" name="billing_last_name" value="{{Auth::user()->last_name}}">
                    @error('billing_last_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3">
                  <label for="email" class="text-white">Email </label>
                  <input type="email" class="form-control" name="billing_email" value="{{Auth::user()->email}}">
                  @error('billing_email')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="mobile" class="text-white">Phone </label>
                  <input type="text" class="form-control" maxlength="10" id="uphonebill" name="billing_mobile" value="{{old('billing_mobile')}}">
                  @error('billing_mobile')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="address" class="text-white">Address</label>
                  <input type="text" class="form-control" name="billing_address" value="{{old('billing_address')}}">
                  @error('billing_address')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>



                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country" class="text-white">Country</label>
                    <input type="text" class="form-control" name="billing_country" value="{{old('billing_country')}}">
                    @error('billing_country')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="state" class="text-white">State</label>
                    <input type="text" class="form-control" name="billing_state" value="{{old('billing_state')}}">
                    @error('billing_state')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip" class="text-white">Zip</label>
                    <input type="text" class="form-control" name="billing_zipcode" value="{{old('billing_zipcode')}}">
                    @error('billing_zipcode')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>



              <hr class="mb-4">
              <div class="custom-control custom-checkbox" id="ShippingBtn">
                <input type="checkbox" class="custom-control-input is_shipping" id="same-address" name="is_shipping_address" checked="">
                <label class="custom-control-label text-white" for="same-address">Shipping address is the same as my billing address</label>
              </div>

              <div class="shipping" style="display: none">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="firstName" class="text-white">First name</label>
                    <input type="text" class="form-control" onkeypress="return ischarKey(event)" name="shipping_last_name" value="{{Auth::user()->name}}">
                    @error('shipping_last_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName" class="text-white">Last name</label>
                    <input type="text" class="form-control" onkeypress="return ischarKey(event)" name="shipping_last_name" value="{{Auth::user()->last_name}}">
                    @error('shipping_last_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3">
                  <label for="email" class="text-white">Email </label>
                  <input type="email" class="form-control" name="shipping_email" value="{{Auth::user()->email}}">
                  @error('shipping_email')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="mobile" class="text-white">Phone </label>
                  <input type="text" class="form-control" id="uphoneship" maxlength="10" name="shipping_mobile" value="{{old('shipping_mobile')}}">
                  @error('shipping_mobile')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="address" class="text-white">Address</label>
                  <input type="text" class="form-control" name="shipping_address" value="{{old('shipping_address')}}">
                  @error('shipping_address')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>



                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country" class="text-white">Country</label>
                    <input type="text" class="form-control" name="shipping_country" value="{{old('shipping_country')}}">
                    @error('shipping_country')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="state" class="text-white">State</label>
                    <input type="text" class="form-control" name="shipping_state" value="{{old('shipping_state')}}">
                    @error('shipping_state')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip" class="text-white">Zip</label>
                    <input type="text" class="form-control" name="shipping_zipcode" value="{{old('shipping_zipcode')}}">
                    @error('shipping_address_type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>



              <hr class="mb-4">
              <h4 class="mb-3 text-white">Payment</h4>

              <div class="d-block my-3">
                <div class="custom-control custom-radio">
                  <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="Credit card" checked="" required="">
                  <label class="custom-control-label text-white" for="credit">Credit card</label>
                </div>

                <!--  <div class="custom-control custom-radio">
              <input id="debit" name="payment_method" type="radio" class="custom-control-input" value="Cash on delivery" required="">
              <label class="custom-control-label text-white" for="debit">Cash on delivery</label>
            </div> -->

              </div>



              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
          </div>
        </div>




      </div>
    </div>


  </div>
</div>

<script>
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  function ischarKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || charCode == 8 || charCode == 46)
      return true;
    else
      return false;
  }
</script>


<script>
  $(document).ready(function() {
    $('#ShippingBtn').change(function() {

      if ($('.is_shipping').is(":checked")) {
        $(".shipping").hide();
      } else {
        $(".shipping").show();
      }


    });
  });
</script>

<script type="text/javascript">
  $(function() {
    $('[id*=uphonebill]').on('keypress', function() {
      var number = $(this).val();
      if (number.length == 3) {
        $(this).val($(this).val() + '-');
      } else if (number.length == 7) {
        $(this).val($(this).val() + '-');
      }
    });
  });
</script>

<script type="text/javascript">
  $(function() {
    $('[id*=uphoneship]').on('keypress', function() {
      var number = $(this).val();
      if (number.length == 3) {
        $(this).val($(this).val() + '-');
      } else if (number.length == 7) {
        $(this).val($(this).val() + '-');
      }
    });
  });
</script>

@stop