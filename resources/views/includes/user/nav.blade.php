<nav id="sidebar" class="sidebar-wrapper">
  <div class="sidebar-content">
    <div class="sidebar-brand">

      <a href="{{url('user/index')}}">Heromedallions</a>

      <div id="close-sidebar">
        <i class="fa fa-times"></i>
      </div>
    </div>
    <!-- sidebar-search  -->
    <div class="sidebar-menu">
      <ul>
        <li class="active">
          <a href="{{url('user/index')}}">
            <span> Dashboard</span>
          </a>
        </li>

        <li class="">
          <a href="{{url('user/order-list')}}">
            <span>My Orders</span>
          </a>
        </li>

        <li class="">
          <a href="{{url('user/custom-order-list')}}">
            <span>My Custom Orders</span>
          </a>
        </li>


        <li>
          <a href="{{url('user/profile')}}">
            <span>Profile Settings</span>
          </a>
        </li>

        <li>
          <a href="{{url('user/change-password')}}">
            <span>Change Password</span>
          </a>
        </li>


        <li>
          <a href="{{url('logout')}}">
            <span>Logout</span>
          </a>
        </li>

      </ul>
    </div>
    <!-- sidebar-menu  -->
  </div>

</nav>