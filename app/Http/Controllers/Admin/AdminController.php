<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Role;
use File;
use Hash;


class AdminController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function adminForm(Request $request)
  {   
    $data['roles'] = Role::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
    $data['admin'] = '';
    if($request->id)
    {
     $data['admin'] = Admin::find($request->id); 
   }
   return view('admin.adm.admin-form')->with($data);
  }

 public function saveAdmin(Request $request)
 {
   $validated = $request->validate([
     'role_id' => 'required|max:255',
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255',
       'status' => 'required'
   ]);

     ///dd($request->id);
   if(isset($request->id))
   {
    $admin = Admin::find($request->id);
    $msg = 'Admin updated successfully';
  } else
  {
   $admin = new Admin;
   $msg = 'Admin saved successfully';
 }

 $admin->role_id = $request->role_id;
 $admin->name = $request->name;
 $admin->email = $request->email;
 $admin->uuid = Str::uuid($request->email);
 $admin->password = Hash::make($request->password);
 $admin->status = $request->status;
 $admin->save();
 return redirect()->back()->with('msg',$msg);
}

public function adminList()
{
  $data['admins'] = Admin::paginate(10);
  return view('admin.adm.admin-list')->with($data);
}


public function deleteAdmin(Request $request)
{
  $id = $request->id;
  $delData = Admin::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}







}
