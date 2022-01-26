<?php

namespace App\Http\Controllers\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\ProductEnquiry;
use App\Models\OrderItem;
use App\Models\State;
use Hash;
use Response;
use Auth;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function index(Request $request)
	{
		$user_id = Auth::user()->id;
		$data['user'] = User::where('id', $user_id)->first();
		$data['orders'] = OrderItem::select('order_items.order_id', 'order_items.status as ostatus_id', 'order_items.quantity as order_quantity', 'order_items.unit_price', 'order_items.unit_size', 'order_items.total_price', 'order_items.user_id', 'order_items.created_at as order_date', 'products.name as product_name', 'products.id as product_id', 'order_status.name as item_status')->leftJoin('products', 'products.id', 'order_items.product_id')->leftJoin('order_status', 'order_status.id', 'order_items.status')->where('user_id', $user_id)->orderBy('order_items.id', 'desc')->paginate(10);
		return view('user.index')->with($data);
	}

	public function orderList(Request $request)
	{
		$user_id = Auth::user()->id;

		$data['orders'] = OrderItem::select('order_items.order_id', 'order_items.status as ostatus_id', 'order_items.quantity as order_quantity', 'order_items.unit_price', 'order_items.unit_size', 'order_items.total_price', 'order_items.user_id', 'order_items.created_at as order_date', 'products.name as product_name', 'products.id as product_id', 'order_status.name as item_status')->leftJoin('products', 'products.id', 'order_items.product_id')->leftJoin('order_status', 'order_status.id', 'order_items.status')->where('user_id', $user_id)->orderBy('order_items.id', 'desc')->paginate(10);

		return view('user.order-list')->with($data);
	}

	public function displayOrderList(Request $request)
	{
		$email_id = Auth::user()->email;
		$data['orders'] = ProductEnquiry::where('email_id', $email_id)->where('enq_type', 'display')->orderBy('id', 'desc')->paginate(10);
		return view('user.display-order-list')->with($data);
	}



	public function customOrderList(Request $request)
	{
		$user_id = Auth::user()->id;
		$data['orders'] = OrderItem::select('users.*', 'order_items.*', 'order_items.created_at as order_date')->leftJoin('users', 'users.id', 'order_items.user_id')->where('order_items.product_type', 'custom')->where('order_items.user_id', $user_id)->orderBy('order_items.id', 'desc')->paginate(15);
		return view('user.custom-order-list')->with($data);
	}


	public function profile()
	{
		$user_id = Auth::user()->id;
		$data['states'] = State::where('country_id', 231)->where('status', 1)->get();
		$data['user'] = User::where('users.id', $user_id)->first();
		return view('user.profile')->with($data);
	}



	public function updateProfile(Request $request)
	{
		$validatedData = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'phone' => 'required',
		]);

		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$user->name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->business_name = $request->business_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->address = $request->address;
		$user->state = $request->state;
		$user->city = $request->city;
		$user->zipcode = $request->zipcode;
		$user->save();

		return redirect()->back()->with('msg', 'Profile updated successfully');
	}


	public function changePassword()
	{
		return view('user.change-password');
	}

	public function updatePassword(Request $request)
	{
		$validatedData = $request->validate([
			'current_password' => 'required',
			'password' => 'required|min:6',
			'password_confirmation' => 'required|same:password',
		]);
		$user_password = Auth::guard('admin')->User()->password;

		if (Hash::check($request->current_password, $user_password)) {
			$user_id = Auth::user()->id;
			$obj_user = User::find($user_id);
			$obj_user->password = Hash::make($request->password);
			$obj_user->save();
			return redirect()->back()->with('msg', 'Password changes successfully.');
		} else {
			return redirect()->back()->with('msg', 'Please enter valid Current Password.');
		}
	}
}
