<!DOCTYPE html>
<html lang="en">
@include('includes/front/head')

<body>
   <div class="main-wrapper">
      <div class="container">
         <div class="row">
            <div class="col-md-6 mx-auto text-center">
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
                     <form class="row justify-content-center" method="post" action="{{url('reset-password')}}">
                        @csrf
                        <div class="col-md-10">
                           <div class="form-group">
                              <input type="text" name="email" class="form-control" placeholder="Email Id">
                           </div>
                        </div>

                        <div class="col-md-10">
                           <div class="form-group">
                              <div class="forget text-center">
                                 <a href="{{url('signin')}}">Login Now?</a>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="col-md-10">
                           <div class="form-group">
                              <div class="doesnt-act text-center">
                                 Doesn't have a account? <a href="{{url('signup')}}">Click here</a>
                              </div>
                           </div>
                        </div> -->
                        <div class="col-md-10 mt-3">
                           <div class="form-group">
                              <div class="account-btn">
                                 <button type="submit" class="common_button w-100">Submit</button>
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>

</html>