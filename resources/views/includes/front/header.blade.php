<header class="header" id="header">
  <div class="header-main">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between align-items-center w-100">
            <div class="logo">
              <a href="{{url('/')}}">
                <img src="{{URL::asset('front/images/logo.png')}}" alt="">
              </a>
              <div class="companyname">
                <h1 style="color: #fff;">''A Hero Remembered Never Dies.''</h1>
                @php $currentPage=Request::segment(1); @endphp
                <span class="breadcrumbname" style="color: #fff;">@yield('title')</span>
              </div>
            </div>



            <div class="members-login">

              <div class="input-group">
                <form method="get" action="{{url('search-products')}}">
                  @csrf
                  <input type="text" class="form-control" placeholder="Search this Product" name="keyword" autocomplete="off">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </form>
              </div>

              @guest
              <a href="{{url('signin')}}"><img src="{{URL::asset('front/images/login-icon.png')}}" alt="">Log in Now</a>
              @endguest

              @auth
              <a href="{{url('user/index')}}"><img src="{{URL::asset('front/images/login-icon.png')}}" alt="">{{Auth::user()->name}}'s Dashboard</a>
              @endauth


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="menubar">
    <div class="container">
      <nav id="cssmenu">
        <div id="head-mobile"></div>
        <div class="button"></div>
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li><a href="{{url('products')}}">Gallery</a></li>
          <li><a href="{{url('display-products')}}">Displays</a></li>
          <li><a href="{{url('custom-category')}}">Custom Products</a></li>
          <li><a href="{{url('vendors')}}">Vendors</a></li>
          <li><a href="{{url('about-us')}}">About Us</a></li>
          <li><a href="{{url('contact-us')}}">Contact Us</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>