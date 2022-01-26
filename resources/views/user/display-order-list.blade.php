@extends('layouts.panel')
@section('content')
@section('title', 'Display Order List')


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
          <h3 class="heading-left">Display Order List</h3>
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
              <th>Product Name</th>
              <th>Date</th>
              <!--     <th>Product Price</th>
    <th>Product Size</th>
    <th>Product Quantity</th> -->
            </tr>

            @if(count($orders)>0)
            @foreach($orders as $row)
            <tr>
              <td>{{$row->name}}</td>
              <td>{{$row->email_id}}</td>
              <td>{{$row->mobile}}</td>
              <td>{{$row->product_name}}</td>
              <td>{{$row->created_at}}</td>
              <!--    <td>{{$row->product_price}}</td>
   <td>{{$row->product_size}}</td>
   <td>{{$row->product_quantity}}</td> -->
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