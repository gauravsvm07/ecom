@extends('layouts.panel')
@section('content')
@section('title', 'Order List')


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
          <h3 class="heading-left"> Order List</h3>
        </div>

        <div class="col-md-3 text-left">
          <h3 class="heading-left"><a href="{{url('/')}}" class="btn btn-warning">Back to Website</a></h3>
        </div>

        <div class="col-md-12 table-responsive order-list">

          <table class="table table-bordered">
            <tr>
              <th>Product Name</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Total Price</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
            @if(count($orders)>0)
            @foreach($orders as $row)
            @php $oid = Crypt::encryptString($row->order_id); @endphp
            <tr>
              <td><a href="javascript:void(0)" data-id="{{$row->product_id}}" data-toggle="modal" data-target="#productModal">{{$row->product_name}}</a></td>
              <td>{{$row->unit_size ?? 'N/A'}}</td>
              <td>{{$row->order_quantity}}</td>
              <td>${{$row->unit_price}}</td>
              <td>${{$row->total_price}}</td>
              <td>{{$row->order_date}}</td>
              <td>@if($row->ostatus_id == 9)<a href="{{url('invoice?order='.$oid)}}" class="btn btn-success btn-sm">Invoice</a> @endif <button type="button" class="common_button btn-sm">{{$row->item_status}}</button></td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="7">No Order Found.. </td>
            </tr>
            @endif



          </table>


          {{$orders->links()}}


        </div>




      </div>

    </div>
</div>
</main>

</div>






<!-- Modal -->



@stop