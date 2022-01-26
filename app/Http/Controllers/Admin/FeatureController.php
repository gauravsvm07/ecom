<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Feature;
use File;


class FeatureController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function featureForm(Request $request)
    {   
        $data['feature'] = '';
        if($request->id)
        {
         $data['feature'] = Feature::find($request->id); 
     }
     return view('admin.feature.feature-form')->with($data);
 }

 public function saveFeature(Request $request)
 {
   $validated = $request->validate([
       'title' => 'required|max:255',
       'status' => 'required',
   ]);


     ///dd($request->id);
   if(isset($request->id))
   {
    $feature = Feature::find($request->id);
    $msg = 'Feature updated successfully';
} else
{
   $feature = new Feature;
   $msg = 'Feature saved successfully';
}

$feature->title = $request->title;
$feature->description = $request->description;

if ($files = $request->file('image')) {
  if(\File::exists(public_path('uploads/feature/'.$request->old_image))){
    \File::delete(public_path('uploads/feature/'.$request->old_image));
}
$imageName = time().'.'.$request->image->extension();  
$request->image->move(public_path('uploads/feature/'), $imageName);
$feature->image = $imageName;
}

$feature->status = $request->status;
$feature->save();
return redirect()->back()->with('msg',$msg);
}

public function featureList()
{
    $data['features'] = Feature::paginate(10);
    return view('admin.feature.feature-list')->with($data);
}


public function deleteFeature(Request $request)
{
  $id = $request->id;
   $row = Feature::find($id);
if(\File::exists(public_path('uploads/feature/'.$row->image))){
  \File::delete(public_path('uploads/feature/'.$row->image));
}
  $delData = Feature::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}
}
