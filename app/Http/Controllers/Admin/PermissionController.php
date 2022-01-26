<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Permission;
use App\Models\Module;
use App\Models\Role;
use File;


class PermissionController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function permissionForm(Request $request)
  {   
    $data['modules'] = Module::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
    $data['roles'] = Role::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
    $data['permission'] = '';
    if($request->id)
    {
     $data['permission'] = Permission::find($request->id); 
   }
   return view('admin.permission.permission-form')->with($data);
  }

 public function savePermission(Request $request)
 {
   $validated = $request->validate([
     'role_id' => 'required|max:255',
     'module_id' => 'required|max:255',
   ]);

     ///dd($request->id);
   if(isset($request->id))
   {
    $permission = Permission::find($request->id);
    $msg = 'Permission updated successfully';
  } else
  {
   $permission = new Permission;
   $msg = 'Permission saved successfully';
 }

 $permission->role_id = $request->role_id;
 $permission->module_id = $request->module_id;
 $permission->can_add = $request->can_add;
 $permission->can_view = $request->can_view;
 $permission->can_update = $request->can_update;
 $permission->can_delete = $request->can_delete;
 $permission->save();
 return redirect()->back()->with('msg',$msg);
}

public function permissionList()
{
  $data['permissions'] = Permission::paginate(10);
  return view('admin.permission.permission-list')->with($data);
}


public function deletePermission(Request $request)
{
  $id = $request->id;
  $delData = Permission::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}







}
