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
          <h3 class="heading-left">My Profile</h3>
        </div>

        <div class="col-md-3 text-left">
          <h3 class="heading-left"><a href="{{url('/')}}" class="btn btn-warning">Back to Website</a></h3>
        </div>

      </div>



      @if (session('msg'))
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('msg') }}
      </div>
      @endif
      <form method="post" action="{{url('user/update-profile')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="exampleInputEmail1">First Name</label>
              <input type="text" class="form-control" name="first_name" value="{{$user->name}}">
              @error('first_name')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>



          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Last Name</label>
              <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
              @error('last_name')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Business Name</label>
              <input type="text" class="form-control" name="business_name" value="{{$user->business_name}}">
              @error('business_name')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>



          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Email Id</label>
              <input type="email" class="form-control" name="email" value="{{$user->email}}" readonly="">
              @error('email')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Phone</label>
              <input type="text" class="form-control" name="phone" value="{{$user->phone}}" id="uphone" maxlength="12" onkeypress="return isNumberKey(event);">
              @error('phone')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Address</label>
              <input type="text" class="form-control" name="address" value="{{$user->address}}">
              @error('address')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>



          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">City</label>
              <input type="text" class="form-control" name="city" value="{{$user->city}}">
              @error('city')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">State</label>
              <select class="form-control" name="state">
                <option value="">--Select-- </option>
                @foreach($states as $state)
                <option value="{{$state->name}}" @if($state->name == $user->state) selected @endif>{{$state->name}}</option>
                @endforeach
              </select>
              @error('state')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="">Zip code</label>
              <input type="text" class="form-control" name="zipcode" value="{{$user->zipcode}}" maxlength="5">
              @error('zipcode')<span style="color:red;">{{$message}}</span>@enderror
            </div>
          </div>






          <div class="col-md-6">
            <div class="form-group mb-0">
              <div class="checkbox checkbox-secondary">
                <button type="submit" class="btn btn-success ">Submit</button>
              </div>
            </div>
          </div>

        </div>
      </form>






    </div>

</div>
</div>
</main>

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

@stop