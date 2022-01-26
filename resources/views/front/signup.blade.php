<!DOCTYPE html>
<html lang="en">
@include('includes/front/head')

<body>
   <div class="main-wrapper">
      <div class="container">
         <div class="row">
            <div class="col-md-8 col-lg-6 mx-auto text-center">
               <div class="login-form-section">
                  <div class="logo">
                     <a href="{{url('/')}}"><img src="{{URL::asset('front/images/logo.png')}}" alt=""></a>
                  </div>
                  <h3 class="text32 m-0">''A Hero Remembered Never Dies.''</h3>
                  <div class="login-form mt-4">
                     @if (session('msg'))
                     <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('msg') }}
                     </div>
                     @endif
                     <form class="row justify-content-center" method="post" action="{{url('save-user')}}">
                        @csrf
                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                              @error('first_name')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>
                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                              @error('last_name')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>

                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="text" class="form-control" name="email" placeholder="Email Id" value="{{old('email')}}">
                              @error('email')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>

                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{old('phone')}}" id="uphone" maxlength="12" onkeypress="return isNumberKey(event);">
                              @error('phone')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>

                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="password" class="form-control" name="password" placeholder="PassCode">
                              @error('password')
                              <span class="text-white">{{$message}}</span>
                              @enderror
                           </div>
                        </div>

                        <!-- <div class="col-md-10">
                     <div class="form-group">
                        <div class="forget text-center">
                           <a href="{{url('forgot-password')}}">Forgot Password?</a>  
                        </div>
                     </div>
                  </div> -->
                        <div class="col-md-10">
                           <div class="form-group">
                              <div class="doesnt-act text-center">
                                 Login? <a href="{{url('signin')}}">Click here</a>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-10 mt-3">
                           <div class="form-group">
                              <div class="account-btn">
                                 <button type="submit" class="common_button w-100">Sign Up Now</button>
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



   <script type="text/javascript">
      $(function() {
         $('[id*=uphone]').on('keypress', function() {
            var number = $(this).val();
            if (number.length == 3) {
               $(this).val($(this).val() + '-');
            } else if (number.length == 7) {
               $(this).val($(this).val() + '-');
            }
         });
      });
   </script>

   <script>
      function isNumberKey(evt) {
         var charCode = (evt.which) ? evt.which : event.keyCode;
         console.log(charCode);
         if (charCode != 46 && charCode != 45 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
   </script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>