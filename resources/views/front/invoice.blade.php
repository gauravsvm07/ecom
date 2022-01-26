@extends('layouts.default')
@section('content')
@section('title', 'Invoice')

<div class="">
   <div class="container">
      <br><br><br>

      <script type="text/javascript">
         function codespeedy() {
            var print_div = document.getElementById("divContents");
            var print_area = window.open();
            print_area.document.write(print_div.innerHTML);
            print_area.document.close();
            print_area.focus();
            print_area.print();
            print_area.close();
            // This is the code print a particular div element
         }
      </script>

      <form>
         <input type="button" class="btn btn-success" value="Print" onclick="codespeedy()">
      </form>
      @php
      $items = App\Helpers\Helper::getOrderItems($order->order_id);
      @endphp
      <?php foreach ($items as $testdata) {
         $reff_no = $testdata->po_reference;
      }
      ?>

      <br><br>
      <div class="invoice-container table-responsive" id="divContents">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
               <tr>
                  <td width="29%">
                     <img alt="Logo" src="{{URL::asset('admin/img/logo.png')}}" style="width: 100px;">
                  </td>
                  <td width="71%" valign="top">
                     <h4 style="font-size: 26px; margin: 0 0 14px;">Invoice #INV-00{{$order->order_id}}</h4>
                     Date: {{date('M d, Y')}}<br>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     @php
                     $user = App\Helpers\Helper::getOrderAddress($order->order_id);
                     @endphp
                     <table width="100%" border="0" cellspacing="0" cellpadding="4">
                        <tbody>
                           <tr>
                              <td>Invoice to</td>
                              <td>&nbsp;</td>
                           </tr>
                           <tr>
                              <td><strong>{{$user->first_name}} {{$user->last_name}} </strong> </td>
                              <td><strong>Heromedallions</strong></td>
                           </tr>
                           <tr>
                              <td>{{$user->address}}</td>
                              <td>1044 N. 440 W. Orem</td>
                           </tr>
                           <tr>
                              <td>{{$user->city}}, {{$user->state}}, {{$user->zipcode}}</td>
                              <td>UT 84057</td>
                           </tr>
                           <tr>
                              <td>{{$user->email}}</td>
                              <td>United States </td>
                           </tr>

                           <tr>
                              <td>{{$user->mobile}}<br> P.O. or Reference: {{$reff_no}}</td>
                              <td>801-224-2056 </td>
                           </tr>
                           <tr>
                              <td>&nbsp;</td>
                              <td>heromedallions@gmail.com</td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>


                           <tr>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>#</strong></td>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>ITEM</strong></td>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>Size</strong></td>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>UNIT COST</strong></td>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>QTY</strong></td>
                              <td align="center" style="background: #f8f9fa; border-bottom: 1px solid #ccc; padding: 10px;"><strong>TOTAL</strong></td>
                           </tr>


                           @foreach($items as $key=>$item)
                           <tr>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">{{$key+1}}</td>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">{{$item->product_name}}</td>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">{{$item->unit_size}}</td>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">${{number_format($item->unit_price,2)}}</td>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">{{$item->item_quantity}}</td>
                              <td align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">${{number_format($item->total_price,2)}}</td>
                           </tr>
                           @endforeach


                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2" align="right">
                     <table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                           <tr>
                              <td align="left" style="border-bottom: 1px solid #ccc; padding: 10px;"><strong>Subtotal:</strong></td>
                              <td align="center" style="border-bottom: 1px solid #ccc;">${{number_format($order->subtotal,2)}}</td>
                           </tr>
                           <tr>
                              <td align="left" style="border-bottom: 1px solid #ccc; padding: 10px;"><strong>Discount:&nbsp;({{$order->discount}}%)</strong></td>
                              <td align="center" style="border-bottom: 1px solid #ccc;">${{number_format($order->subtotal - $order->total,2)}}</td>
                           </tr>
                           <tr>
                              <td align="left" style="border-bottom: 1px solid #ccc; padding: 10px;"><strong>Total:</strong></td>
                              <td align="center" style="border-bottom: 1px solid #ccc;"><strong>${{number_format($order->total,2)}}</strong></td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>



      <br><br><br>
   </div>
</div>

@stop