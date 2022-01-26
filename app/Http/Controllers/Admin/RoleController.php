<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use File;


class RoleController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function roleForm(Request $request)
  {   
    $data['role'] = '';
    if($request->id)
    {
     $data['role'] = Role::find($request->id); 
    }
   return view('admin.role.role-form')->with($data);
  }

 public function saveRole(Request $request)
 {
   $validated = $request->validate([
     'name' => 'required|max:255',
     'status' => 'required'
   ]);

     ///dd($request->id);
   if(isset($request->id))
   {
    $role = Role::find($request->id);
    $msg = 'Role updated successfully';
  } else
  {
   $role = new Role;
   $msg = 'Role saved successfully';
 }

 $role->name = $request->name;
 $role->status = $request->status;
 $role->save();
 return redirect()->back()->with('msg',$msg);
}

public function roleList()
{
  $data['roles'] = Role::paginate(10);
  return view('admin.role.role-list')->with($data);
}


public function deleteRole(Request $request)
{
  $id = $request->id;
  $delData = role::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}







}
