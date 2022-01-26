<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\UsedCoupon;
use File;
use Hash;



class UserController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function userForm(Request $request)
  {
    ///dd($request->id);
    $data['user'] = '';
    if ($request->id) {
      $data['user'] = User::find($request->id);
    }
    return view('admin.user.user-form')->with($data);
  }

  public function saveUser(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255',
      'status' => 'required'
    ]);

    //dd($request->id);
    if (isset($request->id)) {
      $user = User::find($request->id);
      $msg = 'User updated successfully';
    } else {
      $user = new User;
      $msg = 'User saved successfully';
    }

    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->uuid = Str::uuid($request->email);

    if ($request->password) {
      if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
      }
    }

    $user->status = $request->status;
    $user->save();
    return redirect()->back()->with('msg', $msg);
  }

  public function userList()
  {
    $data['users'] = User::orderBy('id', 'desc')->paginate(15);
    return view('admin.user.user-list')->with($data);
  }

  public function viewUser($uuid)
  {
    $data['user'] = User::where('uuid', $uuid)->leftJoin('company', 'users.id', 'company.user_id')->first();
    $company = $data['user']->company();
    //dd($user_profile); 
    /// $address = $user_profile->address;

    return view('admin.user.view-user')->with($data);
  }

  public function updateUserStatus(Request $request)
  {
    $id = $request->id;
    $getData = User::where('id', $id)->first();
    $status = $getData->status;
    $new_status = $status == 0 ? 1 : 0;
    $category = User::find($id);
    $category->status = $new_status;
    $category->save();
    return response()->json(['msg' => 'success']);
  }


  public function deleteUser(Request $request)
  {
    $id = $request->id;
    $delData = Order::where('user_id', $id)->delete();
    $delData = OrderAddress::where('user_id', $id)->delete();
    $delData = OrderItem::where('user_id', $id)->delete();
    $delData = Payment::where('user_id', $id)->delete();
    $delData = UsedCoupon::where('user_id', $id)->delete();
    $delData = User::where('id', $id)->delete();
    return response()->json(['msg' => 'deleted']);
  }

  public function searchUser(Request $request)
  {
    $query = User::where('users.name', '!=', '');

    if ($request->name) {
      $query->where('users.name', 'LIKE', '%' . $request->name . '%');
    }


    if ($request->email) {
      $query->where('users.email', $request->email);
    }

    $data['users'] = $query->paginate(10);

    return view('admin.user.user-list')->with($data);
  }
}
