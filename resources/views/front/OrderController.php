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
		$orderCount = Helper::userOrderItemCount($user_id);
		if ($orderCount < 1) {
			$discount = $subTotal * 20 / 100;
		} else {
			$discount = 0;
		}

		$order = new Order();
		$order->user_id = $user_id;
		$order->shipping_method = '';
		$order->shipping_amount = 0;
		$order->payment_method = $request->payment_method;
		$order->subtotal = $subTotal;
		$order->gst = 0;
		$order->discount = $discount;
		$order->total = $subTotal - $discount;
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
			$order_item->quantity = $item->quantity;
			$order_item->unit_price = $item->price;
			$order_item->unit_size = Helper::getProductSize($item->id);
			$order_item->total_price = $item->quantity * $item->price;
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
		$billing_address->reference = $request->billing_reference;
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
			$user_id = 1;

			$getCouponData = Coupon::where('coupon_code', $coupon_code)->first();
			$couponId = $getCouponData->id;
			$coupon_discount = $getCouponData->coupon_discount;
			$discount_type = $getCouponData->discount_type;
			$valid_from = $getCouponData->valid_from;
			$valid_to = $getCouponData->valid_to;
			$minimum_target = $getCouponData->minimum_target;

			$items = \Cart::session($cartId)->getContent();
			$getCartTotal = Cart::getSubTotal();

			$condition2 = new \Darryldecode\Cart\CartCondition(array(
				'name' => 'Coupon 10.0%',
				'type' => 'tax',
				'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
				'value' => -$coupon_discount . '%',
				'order' => 1
			));

			Cart::condition($condition2);
			Cart::session($cartId)->condition($condition2);

			$UsedCoupon = new UsedCoupon;
			$UsedCoupon->user_id = $user_id;
			$UsedCoupon->coupon_code = $coupon_code;
			$UsedCoupon->coupon_discount = $coupon_discount;
			$UsedCoupon->discount_type = $discount_type;
			$UsedCoupon->minimum_target = $minimum_target;
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
		return view('front.order-success')->with($data);
	}
}
