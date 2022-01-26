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
use App\Models\GeneralProduct;
use App\Models\CustomProduct;
use App\Models\DisplayProduct;
use App\Models\ProductImage;
use App\Models\UserCart;
use App\Helpers\Helper;
use Hash;
use Response;
use Auth;
use Cart;
use Session;
use Illuminate\Routing\Controller as BaseController;

class CartController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function getCartQuantityCount()
	{
		$cartID = 1;
		$sum = 0;
		$items = \Cart::session($cartID)->getContent();
		foreach ($items as $item) {
			$sum = $sum + $item->quantity;
		}
		return $sum;
	}

	public function cart(Request $request)
	{
		///Cart::clear();
		$cartID = 1;
		$heroCart = \Cart::session($cartID)->getContent();
		$sorted = $heroCart->sortByDesc('attributes');
		$data['items'] = $sorted->values()->all();



		$qun = $this->getCartQuantityCount();

		if ($qun == 0) {
			Session::forget('coupon_discount');
		}

		if ($qun >= 5 && $qun <= 9) {
			$items = \Cart::session($cartID)->getContent();
			foreach ($items as $item) {
				if ($item->attributes->size == 2) {
					$product_price = 24.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 3) {
					$product_price = 48.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 4) {
					$product_price = 58.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}


				if ($item->attributes->size == 'display-2') {
					$product_price = Helper::getMedalPriceBySize('display-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-3') {
					$product_price = Helper::getMedalPriceBySize('display-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-composite') {
					$product_price = Helper::getMedalPriceBySize('display-composite');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-2') {
					$product_price = Helper::getMedalPriceBySize('custom-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-3') {
					$product_price = Helper::getMedalPriceBySize('custom-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-4') {
					$product_price = Helper::getMedalPriceBySize('custom-4');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}
			}
		} else if ($qun >= 10) {
			$items = \Cart::session($cartID)->getContent();
			foreach ($items as $item) {
				if ($item->attributes->size == 2) {
					$product_price = 21.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 3) {
					$product_price = 45.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 4) {
					$product_price = 54.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-2') {
					$product_price = Helper::getMedalPriceBySize('display-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-3') {
					$product_price = Helper::getMedalPriceBySize('display-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-composite') {
					$product_price = Helper::getMedalPriceBySize('display-composite');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-2') {
					$product_price = Helper::getMedalPriceBySize('custom-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-3') {
					$product_price = Helper::getMedalPriceBySize('custom-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-4') {
					$product_price = Helper::getMedalPriceBySize('custom-4');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}
			}
		} else {
			$items = \Cart::session($cartID)->getContent();
			foreach ($items as $item) {
				if ($item->attributes->size == 2) {
					$product_price = 29.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 3) {
					$product_price = 51.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 4) {
					$product_price = 65.95;
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}


				if ($item->attributes->size == 'display-2') {
					$product_price = Helper::getMedalPriceBySize('display-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-3') {
					$product_price = Helper::getMedalPriceBySize('display-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'display-composite') {
					$product_price = Helper::getMedalPriceBySize('display-composite');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-2') {
					$product_price = Helper::getMedalPriceBySize('custom-2');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-3') {
					$product_price = Helper::getMedalPriceBySize('custom-3');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}

				if ($item->attributes->size == 'custom-4') {
					$product_price = Helper::getMedalPriceBySize('custom-4');
					\Cart::session($cartID)->update($item->id, [
						'price' => $product_price
					]);
				}
			}
		}



		$coupon_discount = $request->session()->get('coupon_discount');
		if ($request->session()->has('coupon_discount')) {
			$get_discount = $coupon_discount;
		} else {
			$get_discount = 0;
		}

		$data['get_discount'] = $get_discount;
		$data['subTotal'] = Cart::getSubTotal();
		$data['cart_count'] = $heroCart->count();
		return view('front.cart')->with($data);
	}

	public function getSizeCount($user_id, $product_id)
	{
		$data = UserCart::where('user_id', $user_id)->where('product_id', $product_id)->first();
		return $data->product_quantity;
	}



	public function addCart(Request $request)
	{
		$billing_reference = $request->billing_reference;
		Session::put('billing_reference', $billing_reference);
		$res = Session::get('billing_reference');
		$user_id = Auth::user()->id;
		$cart_product_id = $request->cart_product_id;
		$cart_price = $request->cart_price;
		$cart_size = $request->cart_size;
		$cart_quantity = $request->cart_quantity;

		if ($request->product_type == 'general') {
			$product = GeneralProduct::where('product_id', $cart_product_id)->first();
			$imageName = $request->image;
		} else if ($request->product_type == 'custom') {
			$product = CustomProduct::where('product_id', $cart_product_id)->first();
			if ($files = $request->file('image')) {
				$imageName = time() . '.' . $request->image->extension();
				$request->image->move(public_path('uploads/enquiry/'), $imageName);
			} else {
				$imageName = 'noimage,jpg';
			}
		} else if ($request->product_type == 'display') {
			$product = DisplayProduct::where('product_id', $cart_product_id)->first();
			$imageName = $request->image;
		}


		$productId = $cart_product_id;
		$rowId = $cart_product_id; // generate a unique() row ID
		$cartID = 1; // the user ID to bind the cart contents

		$ucart = new UserCart;
		$ucart->user_id = $user_id;
		$ucart->product_id = $productId;
		$ucart->product_name = $product->name;
		$ucart->product_image = $product->featured_img;
		$ucart->product_size = $request->cart_size;
		$ucart->product_quantity = $request->cart_quantity;
		$ucart->product_price = $request->cart_price;
		$ucart->product_type = $request->product_type;
		$ucart->save();

		// $arr = [$rowId, $user_id, $productId, $product->name, $product->featured_img, $request->cart_size, $request->cart_quantity, $request->cart_price, $ucart->id,];
		// print_r($arr);
		// exit;

		// add the product to cart
		\Cart::session($cartID)->add(array(
			'id' => $rowId,
			'name' => $product->name,
			'ucart' => $ucart->id,
			'price' => $request->cart_price,
			'quantity' => $cart_quantity,
			'attributes' => array(
				'cart_sno' => $ucart->id,
				'size' => $request->cart_size,
				'image' => $product->featured_img,
				'po_reference' => $request->billing_reference,
				'product_type' => $request->product_type,
				'custom_image' => $imageName,
				'custom_border' => $request->custom_border,
				'custom_shape' => $request->custom_shape,
			),
			'associatedModel' => $product
		));
		$update = UserCart::where('product_id', '=', $request->cart_product_id)->update(['product_quantity' => $request->quantity, 'product_price' => $request->cart_price]);
		///dd($qun);


		return redirect('cart');
	}

	public function updateCart(Request $request)
	{
		$user_id = Auth::user()->id;
		$update = UserCart::where('product_id', '=', $request->product_id)->update(['product_quantity' => $request->quantity]);

		$size_count =  $this->getSizeCount($user_id, $request->product_id);

		if ($request->size == 2) {
			if ($size_count >= 5 && $size_count <= 9) {
				$product_price =  24.95;
			} else if ($size_count >= 10) {
				$product_price =  21.95;
			} else {
				$product_price =  29.95;
			}
		}

		if ($request->size == 3) {
			if ($size_count >= 5 && $size_count <= 9) {
				$product_price =  48.95;
			} else if ($size_count >= 10) {
				$product_price =  45.95;
			} else {
				$product_price =  51.95;
			}
		}


		if ($request->size == 4) {
			if ($size_count >= 5 && $size_count <= 9) {
				$product_price =  58.95;
			} else if ($size_count >= 10) {
				$product_price =  54.95;
			} else {
				$product_price =  65.95;
			}
		}

		if ($request->size == 'display-2') {
			$product_price = Helper::getMedalPriceBySize('display-2');
		}

		if ($request->size == 'display-3') {
			$product_price = Helper::getMedalPriceBySize('display-3');
		}

		if ($request->size == 'display-composite') {
			$product_price = Helper::getMedalPriceBySize('display-composite');
		}

		if ($request->size == 'custom-2') {
			$product_price = Helper::getMedalPriceBySize('custom-2');
		}

		if ($request->size == 'custom-3') {
			$product_price = Helper::getMedalPriceBySize('custom-3');
		}

		if ($request->size == 'custom-4') {
			$product_price = Helper::getMedalPriceBySize('custom-4');
		}

		$cartID = 1;
		$rowId = $request->product_id;

		\Cart::session($cartID)->update($rowId, [
			'quantity' => ($request->quantity) - ($request->old_quantity),
			'price' => $product_price
		]);
		$update = UserCart::where('product_id', '=', $request->product_id)->update(['product_quantity' => $request->quantity, 'product_price' => $product_price]);


		return redirect('cart');
	}

	public function removeCart($id)
	{
		$cartID = 1;
		$del = UserCart::where('product_id', $id)->delete();
		Cart::session($cartID)->remove($id);
		return redirect('cart');
	}
}
