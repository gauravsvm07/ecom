<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\User;
use File;
use Auth;
use Hash;


class AdminAuthController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login (Request $request)
    { 
        return view('admin.dashboard.login');
    }

    public function authenticate(Request $request)
    {

     $validatedData = $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required',
    ]);
     $email=$request->email;
     $password=($request->password);

     if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
        $request->session()->regenerate();
        return redirect()->intended('auth/index');
    }

    return redirect()->back()->with('msg','Please enter valid Email Or Password');
   }


       public function myProfile()
    {
         $user_id=Auth::guard('admin')->id();
         $data['user'] = Admin::where('id',$user_id)->first(); 
        return view('admin.dashboard.my-profile')->with($data);
    }

public function updateProfile(Request $request)
{
$validatedData = $request->validate([
'name' => 'required',
'email' => 'required',
'phone' => 'required',
]);

$userId=Auth::guard('admin')->id();
$user = Admin::find($userId);
$user->uuid = Str::uuid($request->email);
$user->name = $request->name;
$user->email = $request->email;
$user->phone = $request->phone;
$user->about = $request->about;
$user->address = $request->address;

if ($files = $request->file('image')) 
{
$validatedData = $request->validate([
'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
]);

$imageName = time().'.'.$request->image->extension();  
$request->image->move(public_path('uploads/users/'), $imageName);

if(\File::exists(public_path('uploads/users/'.$request->old_image))){
\File::delete(public_path('uploads/users/'.$request->old_image));
}

} else
{
$imageName=$request->old_image;
}
$user->image = $imageName;
$user->save();
return redirect()->back()->with('msg','Profile updated successfully');
}

 public function updatePassword(Request $request)
{
$validator = Validator::make($request->all(), [
'current_password' => 'required',
'password' => 'required|min:6',
'password_confirmation' => 'required|same:password',  
]);

if ($validator->fails())
{
return response()->json(['errors'=>$validator->errors()->all()], 200);
}

$user_id = Auth::guard('admin')->User()->id;
$user_detais = Admin::where('id',$user_id)->first();
$user_password = $user_detais->password;

if(Hash::check($request->current_password, $user_password))
{  
$user = Admin::find($user_id); 
$user->password = Hash::make($request->password);
$user->save();     
return response()->json(['msg'=>'Password changed successfully.','success'=>'true']); 
} else
{
return response()->json(['msg'=>'Please enter valid Current Password.','success'=>'false']);
}

}


public function adminLogout(Request $request) {
Auth::guard('admin')->logout();
return redirect('auth/login');
}



}
