@extends('layouts.panel')
@section('content')
@section('title', 'Custom Order List')


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
          <h3 class="heading-left">Custom Order List</h3>
        </div>
        <div class="col-md-3 text-left">
          <h3 class="heading-left"><a href="{{url('/')}}" class="btn btn-warning">Back to Website</a></h3>
        </div>


        <div class="col-md-12">

          <table class="table table-bordered">
            <tr>
              <th>Name</th>
              <th>Email Id</th>
              <th>Phone</th>
              <th>Product</th>
              <th>Size</th>
              <th>Border</th>
              <th>Shape</th>
              <th>Image</th>
              <th>Date</th>
            </tr>

            @if(count($orders)>0)
            @foreach($orders as $row)
            <tr>
              <td>{{$row->name}}</td>
              <td>{{$row->email}}</td>
              <td>{{$row->phone}}</td>
              <td>{{$row->product_name}}</td>
              <td>{{$row->unit_size}}</td>
              <td>{{$row->custom_border}}</td>
              <td>{{$row->custom_shape}}</td>
              <td><a href="{{URL::asset('uploads/enquiry/'.$row->custom_image)}}" target="_blank"><img src="{{URL::asset('uploads/enquiry/'.$row->custom_image)}}" style="height:70px; width:70px;"></a></td>
              <td>{{$row->order_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="7">No Order Found.. </td>
            </tr>
            @endif

            {{$orders->links()}}

          </table>




        </div>




      </div>

    </div>
</div>
</main>

</div>


@stop