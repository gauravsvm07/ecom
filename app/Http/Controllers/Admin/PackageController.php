<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Package;
use File;


class PackageController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function packageForm(Request $request)
    {   
        $data['package'] = '';
        if($request->id)
        {
         $data['package'] = Package::find($request->id); 
     }
     return view('admin.package.package-form')->with($data);
 }

 public function savePackage(Request $request)
 {
   $validated = $request->validate([
       'title' => 'required|max:255',
       'status' => 'required',
   ]);


     ///dd($request->id);
   if(isset($request->id))
   {
    $package = Package::find($request->id);
    $msg = 'Package updated successfully';
} else
{
   $package = new Package;
   $msg = 'Package saved successfully';
}

$package->title = $request->title;
$package->description = $request->description;
$package->amount = $request->amount;
$package->duration = $request->duration;
$package->status = $request->status;
$package->save();
return redirect()->back()->with('msg',$msg);
}

public function packageList()
{
    $data['packages'] = Package::paginate(10);
    return view('admin.package.package-list')->with($data);
}


public function deletePackage(Request $request)
{
  $id = $request->id;
  $delData = Package::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}
}
