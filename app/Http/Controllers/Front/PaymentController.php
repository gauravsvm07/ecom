<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Libraries\Gwapi;
use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\OrderAddress;
use App\Models\UserCart;
use Hash;
use Response;
use Auth;
use Cart;
use Crypt;
use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function orderPayment(Request $request)
  {
    $cartID = 1;
    $data['items'] = '';
    return view('front.payment')->with($data);
  }

  public function payProcess(Request $request)
  {
    $card_number = $request->card_number;
    $card_cvv = $request->card_cvv;


    $order_id = $request->session()->get('order_id');
    $user_id = Auth::user()->id;
    $user = User::where('id', $user_id)->first();
    $billing = OrderAddress::where('order_id', $order_id)->where('address_type', 'billing')->first();
    $shipping = OrderAddress::where('order_id', $order_id)->where('address_type', 'shipping')->first();
    $order = Order::where('id', $order_id)->first();

    $coupon_discount = $request->session()->get('coupon_discount');
    if ($request->session()->has('coupon_discount')) {
      $get_discount = $coupon_discount;
    } else {
      $get_discount = 0;
    }
    $data['get_discount'] = $get_discount;

    $coupon_discount = $request->session()->get('coupon_discount');
    if ($request->session()->has('coupon_discount')) {
      $get_discount = $coupon_discount;
      $total = $order->total * $get_discount / 100;
    } else {
      $get_discount = 0;
      $total = $order->total;
    }

    $amount = $total;

    $payment = new Payment();
    $payment->user_id = $user_id;
    $payment->order_id = $order_id;
    $payment->status = 1;
    $payment->save();

    $gw = new gwapi;
    $gw->setLogin("6457Thfj624V5r7WUwc5v6a68Zsd6YEm");
    $gw->setBilling(
      $billing->name,
      $billing->last_name,
      "N/A",
      $billing->address,
      $billing->country,
      $billing->state,
      "N/A",
      $billing->zipcode,
      "N/A",
      $billing->mobile,
      $billing->mobile,
      $billing->email,
      "www.heromedallions.com"
    );
    $gw->setShipping(
      $shipping->first_name,
      $shipping->last_name,
      "N/A",
      $shipping->address,
      $shipping->state,
      "N/A",
      "N/A",
      $shipping->zipcode,
      "N/A",
      $shipping->email
    );
    $gw->setOrder(date("Y") . $order_id, "Order", 1, 2, "PO1234", "65.192.14.10");

    $r = $gw->doSale($amount, $card_number, $card_cvv);

    ///response=1&responsetext=SUCCESS&authcode=123456&transactionid=6694322172&avsresponse=N&cvvresponse=&orderid=1234&type=sale&response_code=100&cc_number=4xxxxxxxxxxx1111&customer_vault_id=&checkaba=&checkaccount=
    $res =  $gw->responses['responsetext'];

    if ($res == 'SUCCESS') {
      $cartId = 1;
      $order_update = Order::where('id', '=', $order_id)->update(['order_status' => 14, 'payment_status' => 1]);
      $order_item_update = OrderItem::where('order_id', '=', $order_id)->update(['status' => 14]);

      Cart::clear();
      Cart::session($cartId)->clear();
      $del = UserCart::where('user_id', $user_id)->delete();
      $oid = Crypt::encryptString($order_id);
      return redirect('order-success?order=' . $oid)->with('order_id', $order_id);
    } else {
      return redirect()->back()->with('msg', $res);
    }

    ///return view('front.payment')->with($data);
  }
}
