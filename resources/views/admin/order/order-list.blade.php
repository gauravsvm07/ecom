@extends('layouts.master')
@section('content')
@section('title', 'Order List')

<!-- Page Wrapper -->
<div class="page-wrapper">
  <div class="content container-fluid">

    <!-- Page Header -->
    @include('includes/admin/breadcrumb')
    <!-- /Page Header -->

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <span id="status_msg" style="color: green;"></span>
          </div>
          <div class="card-body">

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email Id</th>
                    <th>Discount</th>
                    <th>Amount</th>
                    <th>Products</th>
                    <th>View Address</th>
                    <!-- <th>Order Status</th> -->
                    <th>Change Status</th>
                    <th>Invoice</th>
                    <th>Date</th>
                  </tr>
                </thead>

                <tbody>
                  @if(count($orders) > 0)
                  @foreach($orders as $row)
                  <tr>
                    <td>{{$row->name}} {{$row->last_name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->discount}}%</td>
                    <td>${{$row->total}}</td>
                    <td><button class="btn btn-info btn-sm viewProductBtn" data-toggle="modal" data-target="#productModal" data-id={{$row->order_id}}>View Products</button></td>
                    <td><button class="btn btn-info btn-sm viewAddressBtn" data-toggle="modal" data-target="#addressModal" data-id={{$row->order_id}}>View Address</button></td>


                    <td>
                      <form>
                        @php
                        $order_status = App\Helpers\Helper::getOrderStatus();
                        @endphp
                        <select class="form-control changeStatus" order-id={{$row->order_id}}>
                          @foreach($order_status as $order_row)
                          <option value="{{$order_row->id}}" {{ $row->status_id == $order_row->id ? 'selected' : '' }}>{{$order_row->name}}</option>
                          @endforeach
                        </select>
                      </form>

                    </td>

                    <td> <a href="{{url('auth/invoice?order='.$row->order_id)}}" class="btn btn-success btn-sm" target="_blank">Invoice </a> </td>
                    <td>{{$row->order_date}}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="6">No record found..</td>
                  </tr>
                  @endif
                </tbody>

              </table>
              {{$orders->links()}}


            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- /Main Wrapper -->

<script>
  $(document).ready(function() {
    $('.changeStatus').on('change', function() {
      var id = $(this).attr("order-id");
      //alert(id);
      var status_id = this.value;
      ///alert(status_id);
      $.ajax({
        url: "{{url('auth/change-order-status')}}",
        method: "get",
        data: {
          order_id: id,
          status_id: status_id
        },
        success: function(data) {
          $('#status_msg').text('Order status updated');
          $('#status_msg').fadeIn(250).fadeOut(1500);

          ///alert('Order status updated');
          //alert(data.status_id);
        }
      });

    });
  });
</script>

<script>
  $(document).ready(function() {
    $('.viewProductBtn').on('click', function() {
      var id = $(this).data("id");
      // alert(id);
      $.ajax({
        url: "{{url('auth/get-order-products')}}",
        method: "get",
        data: {
          order_id: id
        },
        success: function(data) {
          ///alert('success');
          html = "";
          html += '<table class="table table-bordered"><tr><th>Product Name</th> <th>Size</th> <th>Quantity</th> <th>Unit Price</th> <th>Total Price</th> <th>Reference</th></tr>';
          $.each(data.items, function(index, value) {
            html += '<tr><td>' + value.product_name + '</td><td>' + value.unit_size + '</td><td>' + value.order_quantity + '</td><td>$' + value.unit_price + '</td><td>$' + value.total_price + '</td><td>' + value.po_reference + '</tr>';
          });
          html += '</table>';
          $('#getProductData').empty('').append(html);
        }
      });

    });
  });
</script>


<script>
  $(document).ready(function() {
    $('.viewAddressBtn').on('click', function() {
      var id = $(this).data("id");
      // alert(id);
      $.ajax({
        url: "{{url('auth/get-order-address')}}",
        method: "get",
        data: {
          order_id: id
        },
        success: function(data) {
          ///alert('success');
          html = "";
          html += '<table class="table table-bordered"><tr><th>Address Type</th> <th>Business Name</th> <th>Email Id</th> <th>Mobile No.</th>  <th>Address</th><th>City</th><th>State</th><th>Zip code</th></tr>';
          $.each(data.address, function(index, value) {
            html += '<tr><td>' + value.address_type + '</td><td>' + value.business_name + '</td><td>' + value.email + '</td><td>' + value.mobile + '</td><td>' + value.address + '</td><td>' + value.city + '</td><td>' + value.state + '</td><td>' + value.zipcode + '</td></tr>';
          });
          html += '</table>';
          $('#getAddressData').empty('').append(html);
        }
      });

    });
  });
</script>



<!--Products Modal -->
<div class="modal fade" id="productModal" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View Products</h4>
      </div>
      <div class="modal-body">
        <div id="getProductData"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!--Address Modal -->
<div class="modal fade" id="addressModal" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View Address</h4>
      </div>
      <div class="modal-body">
        <div id="getAddressData"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




@include('includes/admin/delete-model')
@stop