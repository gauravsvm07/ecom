@extends('layouts.default')
@section('content')
@section('title', 'About Us')

<div class="main-wrapper">
   <div class="container">
      @include('includes.front.categories')

   </div>


   <div class="container">
      <div class="payment-confirm-wrapper mt-5">
         <div class="row">



            <div class="col-md-7 mx-auto">

               @if (session('msg'))
               <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  {{ session('msg') }}
               </div>
               @endif


               <div class="payment-confirm">
                  <form class="row" method="post" action="{{url('pay-process')}}">
                     @csrf
                     <div class="col-md-12">
                        <div class="form-group">
                           <input type="text" class="form-control cc-number-input" name="card_number" placeholder="Card Number" required="" maxlength="19" id="credit-card">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <input type="text" class="form-control" name="card_holder" placeholder="Cardholder" required="">
                        </div>
                     </div>
                     <div class="col-md-3 pr-0">
                        <div class="form-group setCardDate">
                           <?php $months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"); ?>
                           <select class="form-control" name="card_month" required>
                              <option value="">Month</option>
                              @foreach($months as $month)
                              <option value="{{$month.'/'}}">{{$month}}</option>
                              @endforeach
                           </select>
                           <a href="javascript:void(0)" style="font-size: 10px;color: #007bff;">&nbsp;&nbsp;&nbsp;&nbsp;Exp. Date</a>

                        </div>
                     </div>
                     <div class="col-md-3 pr-0">
                        <div class="form-group">
                           <?php
                           $start_year = 2022;
                           $end_year = 2050;
                           ?>
                           <select class="form-control setCardDate" name="card_year" required>
                              <option value="">Year</option>
                              <?php for ($x = $start_year; $x < $end_year; $x++) { ?>
                                 <option value="{{$x}}"> {{$x}}</option>
                              <?php } ?>
                           </select>
                        </div>

                        <input type="hidden" class="form-control card_date" name="card_date" placeholder="MMYY">
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" class="form-control cc-cvc-input" placeholder="CVV" name="card_cvv" required="" maxlength="4">
                           <a href="javascript:void(0)" style="font-size: 10px;color: #007bff;" data-toggle="modal" data-target="#cvvModal">What is This?</a>



                        </div>
                     </div>

                     <!-- The Modal -->
                     <div class="modal fade" id="cvvModal">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                           <div class="modal-content">

                              <!-- Modal Header -->
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <!-- Modal body -->
                              <div class="modal-body">
                                 <div class="card-pic">
                                    <img src="https://heromedallions.markupdesigns.net/public/front/images/cvv.png" alt="">
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>


                     <!--   <div class="col-md-12">
                              <div class="form-group">
                                 <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Save this Card 
                                    </label>
                                 </div>
                              </div>
                           </div> -->

                     <div class="col-md-12">
                        <div class="form-group">
                           <div class="account-btn">
                              <button type="submit" class="common_button w-100">Pay Now</button>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <div class="payment-icons">
                              <ul>
                                 <li><a href=""> <img src="{{URL::asset('front/images/visa-icon01.jpg')}}" alt=""></a></li>
                                 <li><a href=""> <img src="{{URL::asset('front/images/visa-icon02.jpg')}}" alt=""></a></li>
                                 <li><a href=""> <img src="{{URL::asset('front/images/visa-icon03.jpg')}}" alt=""></a></li>
                                 <li><a href=""> <img src="{{URL::asset('front/images/visa-icon04.jpg')}}" alt=""></a></li>
                              </ul>
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
   let ccNumberInput = document.querySelector('.cc-number-input'),
      ccNumberPattern = /^\d{0,16}$/g,
      ccNumberSeparator = " ",
      ccNumberInputOldValue,
      ccNumberInputOldCursor,

      ccExpiryInput = document.querySelector('.cc-expiry-input'),
      ccExpiryPattern = /^\d{0,4}$/g,
      ccExpirySeparator = "/",
      ccExpiryInputOldValue,
      ccExpiryInputOldCursor,

      ccCVCInput = document.querySelector('.cc-cvc-input'),
      ccCVCPattern = /^\d{0,3}$/g,

      mask = (value, limit, separator) => {
         var output = [];
         for (let i = 0; i < value.length; i++) {
            if (i !== 0 && i % limit === 0) {
               output.push(separator);
            }

            output.push(value[i]);
         }

         return output.join("");
      },
      unmask = (value) => value.replace(/[^\d]/g, ''),
      checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
      ccNumberInputKeyDownHandler = (e) => {
         let el = e.target;
         ccNumberInputOldValue = el.value;
         ccNumberInputOldCursor = el.selectionEnd;
      },
      ccNumberInputInputHandler = (e) => {
         let el = e.target,
            newValue = unmask(el.value),
            newCursorPosition;

         if (newValue.match(ccNumberPattern)) {
            newValue = mask(newValue, 4, ccNumberSeparator);

            newCursorPosition =
               ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) +
               checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) +
               (unmask(newValue).length - unmask(ccNumberInputOldValue).length);

            el.value = (newValue !== "") ? newValue : "";
         } else {
            el.value = ccNumberInputOldValue;
            newCursorPosition = ccNumberInputOldCursor;
         }

         el.setSelectionRange(newCursorPosition, newCursorPosition);

         highlightCC(el.value);
      },
      highlightCC = (ccValue) => {
         let ccCardType = '',
            ccCardTypePatterns = {
               amex: /^3/,
               visa: /^4/,
               mastercard: /^5/,
               disc: /^6/,

               genric: /(^1|^2|^7|^8|^9|^0)/,
            };

         for (const cardType in ccCardTypePatterns) {
            if (ccCardTypePatterns[cardType].test(ccValue)) {
               ccCardType = cardType;
               break;
            }
         }

         let activeCC = document.querySelector('.cc-types__img--active'),
            newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);

         if (activeCC) activeCC.classList.remove('cc-types__img--active');
         if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
      },
      ccExpiryInputKeyDownHandler = (e) => {
         let el = e.target;
         ccExpiryInputOldValue = el.value;
         ccExpiryInputOldCursor = el.selectionEnd;
      },
      ccExpiryInputInputHandler = (e) => {
         let el = e.target,
            newValue = el.value;

         newValue = unmask(newValue);
         if (newValue.match(ccExpiryPattern)) {
            newValue = mask(newValue, 2, ccExpirySeparator);
            el.value = newValue;
         } else {
            el.value = ccExpiryInputOldValue;
         }
      };

   ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
   ccNumberInput.addEventListener('input', ccNumberInputInputHandler);

   ccExpiryInput.addEventListener('keydown', ccExpiryInputKeyDownHandler);
   ccExpiryInput.addEventListener('input', ccExpiryInputInputHandler);
</script>

<script>
   $(document).ready(function() {
      $('.setCardDate').on('change', function() {
         var card_year = $('select[name="card_year"]').val()
         var card_month = $('select[name="card_month"]').val()
         ///alert(card_month);
         var cdate = card_month + card_year;
         $('.card_date').val(cdate);
      })

   });
</script>

@stop