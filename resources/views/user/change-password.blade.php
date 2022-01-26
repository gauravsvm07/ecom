@extends('layouts.panel')
@section('content')
@section('title', 'Dashboard')


<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fa fa-bars"></i>
  </a>
  @include('includes.user.nav')
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9 text-left">
          <h3 class="heading-left">Change Password</h3>
        </div>

        <div class="col-md-3 text-left">
          <h3 class="heading-left"><a href="{{url('/')}}" class="btn btn-warning">Back to Website</a></h3>
        </div>


        <div class="col-md-6">
          @if (session('msg'))
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('msg') }}
          </div>
          @endif
          <form method="post" action="{{url('user/update-password')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label class="form-label">Current Password</label>
              <input type="password" class="form-control" name="current_password">
              @error('current_password')<span style="color:red;">{{$message}}</span>@enderror
            </div>

            <div class="form-group">
              <label class="form-label">New Password</label>
              <input type="password" class="form-control" name="password">
              @error('password')<span style="color:red;">{{$message}}</span>@enderror
            </div>

            <div class="form-group">
              <label class="form-label" for="exampleInputPassword1">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation">
              @error('password_confirmation')<span style="color:red;">{{$message}}</span>@enderror
            </div>


            <div class="form-group mb-0">
              <div class="checkbox checkbox-secondary">
                <button type="submit" class="btn btn-success ">Submit</button>
              </div>
            </div>
          </form>

        </div>

        <div class="col-md-6"> </div>


      </div>

    </div>
</div>
</main>

</div>


@stop