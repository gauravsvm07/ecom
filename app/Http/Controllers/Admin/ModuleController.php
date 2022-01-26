<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use App\Models\Module;
use File;


class ModuleController extends BaseController
{
  private $module = 'user_management';
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function moduleForm(Request $request)
  {   
    if(!Helper::adminCan($this->module,'add')) return dd('No Permission');
    if(!Helper::adminCan($this->module,'update')) return dd('No Permission');

    $data['module'] = '';
    if($request->id)
    {
     $data['module'] = Module::find($request->id); 
   }
   return view('admin.module.module-form')->with($data);
  }

 public function saveModule(Request $request)
 {
   $validated = $request->validate([
     'name' => 'required|max:255',
     'key' => 'required|max:255',
     'status' => 'required'
   ]);

     ///dd($request->id);
   if(isset($request->id))
    {
    $module = Module::find($request->id);
    $msg = 'Module updated successfully';
    } else
   {
   $module = new Module;
   $msg = 'Module saved successfully';
   }

 $module->name = $request->name;
 $module->key = $request->key;
 $module->status = $request->status;
 $module->save();
 return redirect()->back()->with('msg',$msg);
}

public function moduleList()
{
  if(!Helper::adminCan($this->module,'view')) return dd('No Permission');

  $data['modules'] = Module::paginate(10);
  return view('admin.module.module-list')->with($data);
}


public function deleteModule(Request $request)
{
  if(! Helper::adminCan($this->module,'delete')) return dd('No Permission');
  $id = $request->id;
  $delData = Module::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}







}
