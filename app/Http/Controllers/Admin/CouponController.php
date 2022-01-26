<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Coupon;
use File;


class CouponController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function couponForm(Request $request)
  {   
    $data['coupon'] = '';
    if($request->id)
    {
       $data['coupon'] = Coupon::find($request->id); 
   }
   return view('admin.coupon.coupon-form')->with($data);
}

public function saveCoupon(Request $request)
{
 $validated = $request->validate([
   'coupon_code' => 'required|max:255',
   'status' => 'required'
]);

     ///dd($request->id);
 if(isset($request->id))
 {
    $coupon = Coupon::find($request->id);
    $msg = 'Coupon updated successfully';
} else
{
 $coupon = new Coupon;
 $msg = 'Coupon saved successfully';
}

$coupon->coupon_code = $request->coupon_code;
$coupon->coupon_discount = $request->coupon_discount;
$coupon->type = $request->type;
$coupon->valid_from = $request->valid_from;
$coupon->valid_to = $request->valid_to;
$coupon->minimum_target = $request->minimum_target;
$coupon->status = $request->status;
$coupon->save();
return redirect()->back()->with('msg',$msg);
}

public function couponList()
{
  $data['coupons'] = Coupon::paginate(10);
  return view('admin.coupon.coupon-list')->with($data);
}


public function deleteCoupon(Request $request)
{
  $id = $request->id;
  $delData = Coupon::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}







}
