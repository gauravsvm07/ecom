<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Coupon;
use App\Models\UsedCoupon;
use App\Models\State;
use App\Helpers\Helper;
use Hash;
use Response;
use Auth;
use Cart;
use Redirect;
use Session;
use Crypt;


use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function checkout(Request $request)
	{
		$cartID = 1;
		$data['items'] = \Cart::session($cartID)->getContent();
		$data['cartTotal'] = $data['items']->count();
		$data['subTotal'] = Cart::getSubTotal();
		$data['user'] = '';
		$data['states'] = State::where('country_id', 231)->where('status', 1)->get();

		$coupon_discount = $request->session()->get('coupon_discount');
		if ($request->session()->has('coupon_discount')) {
			$get_discount = $coupon_discount;
		} else {
			$get_discount = 0;
		}
		$data['get_discount'] = $get_discount;
		return view('front.checkout')->with($data);
	}

	public function orderProcess(Request $request)
	{
		$validate = $request->validate([
			'billing_first_name' => 'required|string|max:255',
			'billing_last_name' => 'required|string|max:255',
			'billing_email' => 'required|string|email|max:255',
			'billing_mobile' => 'required|string',
			'billing_address' => 'required|string|max:255',
			'billing_city' => 'required|string|max:255',
			'billing_state' => 'required|string|max:255',
			'billing_zipcode' => 'required|string|max:255',
		]);

		$cartId = 1;
		$items = \Cart::session($cartId)->getContent();
		$cartCount = $items->count();
		$subTotal = Cart::getSubTotal();

		$user_id = Auth::user()->id;

		$coupon_discount = $request->session()->get('coupon_discount');
		if ($request->session()->has('coupon_discount')) {
			$get_discount = $coupon_discount;
			$total = $subTotal - ($subTotal * $get_discount / 100);
		} else {
			$get_discount = 0;
			$total = $subTotal;
		}

		$order = new Order();
		$order->user_id = $user_id;
		$order->shipping_method = '';
		$order->shipping_amount = 0;
		$order->payment_method = $request->payment_method;
		$order->subtotal = $subTotal;
		$order->gst = 0;
		$order->discount = $get_discount;
		$order->total = $total;
		$order->order_status = 4;
		$order->payment_status = 0;
		$order->save();
		$order_id = $order->id;

		$items = \Cart::session($cartId)->getContent();
		foreach ($items as $item) {
			$order_item = new OrderItem();
			$order_item->user_id = $user_id;
			$order_item->order_id = $order_id;
			$order_item->product_id = $item->id;
			$order_item->product_name = $item->name;
			$order_item->product_type = $item->attributes->product_type;
			$order_item->quantity = $item->quantity;
			$order_item->unit_price = $item->price;
			$order_item->unit_size = $item->attributes->size;
			$order_item->total_price = $item->quantity * $item->price;
			$order_item->po_reference = $item->attributes->po_reference;
			$order_item->custom_image = $item->attributes->custom_image;
			$order_item->custom_border = $item->attributes->custom_border;
			$order_item->custom_shape = $item->attributes->custom_shape;
			$order_item->status = 4;
			$order_item->save();
		}

		$billing_address = new OrderAddress();
		$billing_address->order_id = $order_id;
		$billing_address->address_type = 'billing';
		$billing_address->user_id = $user_id;
		$billing_address->first_name = $request->billing_first_name;
		$billing_address->last_name = $request->billing_last_name;
		$billing_address->email = $request->billing_email;
		$billing_address->mobile = $request->billing_mobile;
		$billing_address->address = $request->billing_address;
		$billing_address->city = $request->billing_city;
		$billing_address->state = $request->billing_state;
		$billing_address->zipcode = $request->billing_zipcode;
		$billing_address->save();

		if ($request->is_shipping_address == '') {
			$shipping_address = new OrderAddress();
			$shipping_address->order_id = $order_id;
			$shipping_address->address_type = 'shipping';
			$shipping_address->user_id = $user_id;
			$shipping_address->first_name = $request->shipping_first_name;
			$shipping_address->last_name = $request->shipping_last_name;
			$shipping_address->business_name = $request->business_name;
			$shipping_address->email = $request->shipping_email;
			$shipping_address->mobile = $request->shipping_mobile;
			$shipping_address->address = $request->shipping_address;
			$shipping_address->city = $request->shipping_city;
			$shipping_address->state = $request->shipping_state;
			$shipping_address->zipcode = $request->shipping_zipcode;
			$shipping_address->save();
		} else {
			$shipping_address = new OrderAddress();
			$shipping_address->order_id = $order_id;
			$shipping_address->address_type = 'shipping';
			$shipping_address->user_id = $user_id;
			$shipping_address->first_name = $request->billing_first_name;
			$shipping_address->last_name = $request->billing_last_name;
			$shipping_address->email = $request->billing_email;
			$shipping_address->mobile = $request->billing_mobile;
			$shipping_address->address = $request->billing_address;
			$shipping_address->city = $request->billing_city;
			$shipping_address->state = $request->billing_state;
			$shipping_address->zipcode = $request->billing_zipcode;
			$shipping_address->save();
		}
		$msg = '';
		$session_order_id = $request->session()->put('order_id', $order_id);
		return redirect('payment')->with('msg', $msg);
	}

	public function checkCoupon(Request $request)
	{
		$validateData = $request->validate(['coupon_code' => 'required']);
		$coupon_code = $request->coupon_code;
		$getCount = Coupon::where('coupon_code', $coupon_code)->count();
		if ($getCount == 1) {
			$cartId = 1;
			$user_id = Auth::user()->id;
			$getCouponData = Coupon::where('coupon_code', $coupon_code)->first();
			$couponId = $getCouponData->id;
			$coupon_discount = $getCouponData->coupon_discount;
			$request->session()->put('coupon_discount', $coupon_discount);
			$UsedCoupon = new UsedCoupon;
			$UsedCoupon->user_id = $user_id;
			$UsedCoupon->coupon_code = $coupon_code;
			$UsedCoupon->coupon_discount = $coupon_discount;
			$UsedCoupon->discount_type = 'percent';
			$UsedCoupon->minimum_target = 0;
			$UsedCoupon->save();
			$couponMsg = 'Coupon Code applied successfully';
		} else {
			$couponMsg = 'Please enter valid Coupon Code';
		}

		return redirect()->back()->with('couponMsg', $couponMsg);
	}



	public function orderSuccess(Request $request)
	{
		$data['user'] = '';
		Session::forget('coupon_discount');
		return view('front.order-success')->with($data);
	}

	public function invoice(Request $request)
	{
		///dd($request->order);
		$order_id = Crypt::decryptString($request->order);
		//dd($order_id);
		$data['order'] = Order::select('users.*', 'orders.*', 'orders.id as order_id', 'orders.created_at as order_date', 'order_status.name as status_name', 'order_status.id as status_id')->leftJoin('users', 'users.id', 'orders.user_id')->leftJoin('order_status', 'order_status.id', 'orders.order_status')->where('orders.id', $order_id)->first();
		///dd($data['orders']);
		return view('front.invoice')->with($data);
	}
}
