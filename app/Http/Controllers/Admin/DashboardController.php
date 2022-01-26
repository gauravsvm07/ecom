<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Enquiry;
use App\Models\Cms;
use App\Models\User;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Order;
use App\Models\ProductEnquiry;
use Auth;


class DashboardController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login()
    {
        return view('admin.dashboard.login');
    }

    public function index()
    {
        $data['user_count'] = User::where('status', 1)->count();
        $data['enquiry_count'] = ProductEnquiry::count();
        $data['page_count'] = Cms::where('status', 1)->count();
        $data['user_payment'] = Order::sum('total');
        $data['enquiries'] = ProductEnquiry::orderBy('id', 'desc')->take(10)->get();
        return view('admin.dashboard.index')->with($data);
    }

    public function paymentList()
    {
        $data['payments'] = Payment::select('users.*', 'payments.*', 'orders.*', 'payments.status as pay_status')->leftJoin('users', 'users.id', 'payments.user_id')->leftJoin('orders', 'orders.id', 'payments.order_id')->orderBy('payments.id', 'desc')->paginate(15);
        return view('admin.payment.payment-list')->with($data);
    }

    public function invoice(Request $request)
    {
        $order_id = $request->order;
        $data['order'] = Order::select('users.*', 'orders.*', 'orders.id as order_id', 'orders.created_at as order_date', 'order_status.name as status_name', 'order_status.id as status_id')->leftJoin('users', 'users.id', 'orders.user_id')->leftJoin('order_status', 'order_status.id', 'orders.order_status')->where('orders.id', $order_id)->first();
        ///dd($data['orders']);
        return view('admin.order.invoice')->with($data);
    }

    public function orderList()
    {
        $data['orders'] = Order::select('users.*', 'orders.*', 'orders.id as order_id', 'orders.created_at as order_date', 'order_status.name as status_name', 'order_status.id as status_id')->leftJoin('users', 'users.id', 'orders.user_id')->leftJoin('order_status', 'order_status.id', 'orders.order_status')->orderBy('orders.id', 'desc')->paginate(15);
        return view('admin.order.order-list')->with($data);
    }

    public function getOrderProducts(Request $request)
    {
        $order_id = $request->order_id;
        $items = OrderItem::select('order_items.*', 'general_products.*', 'order_items.order_id as item_order_id', 'order_items.quantity as order_quantity', 'order_items.unit_price as order_unit_price', 'order_items.total_price')->leftJoin('general_products', 'general_products.product_id', 'order_items.product_id')->where('order_items.order_id', $order_id)->get();
        return Response()->json(['msg' => 'success', 'items' => $items]);
    }

    public function getOrderAddress(Request $request)
    {
        $order_id = $request->order_id;
        $address = OrderAddress::where('order_id', $order_id)->get();
        return Response()->json(['msg' => 'success', 'address' => $address]);
    }


    public function changeOrderStatus(Request $request)
    {
        $order_id = $request->order_id;
        $status_id = $request->status_id;
        $order_update = Order::where('id', $order_id)->update(['order_status' => $status_id]);
        $order_update = OrderItem::where('order_id', $order_id)->update(['status' => $status_id]);
        return Response()->json(['msg' => 'success', 'status_id' => $status_id]);
    }

    public function customOrder(Request $request)
    {
        $data['orders'] = OrderItem::select('users.*', 'order_items.*', 'order_items.created_at as order_date')->leftJoin('users', 'users.id', 'order_items.user_id')->where('order_items.product_type', 'custom')->orderBy('order_items.id', 'desc')->paginate(15);
        return view('admin.order.custom-order-list')->with($data);
    }


    public function lockScreen()
    {
        return view('admin.dashboard.lock-screen');
    }

    public function forgotPassword()
    {
        return view('admin.dashboard.forgot-password');
    }
}
