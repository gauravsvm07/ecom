<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use File;


class CategoryController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function categoryForm(Request $request)
    {   
        $data['category'] = '';
        if($request->id)
        {
         $data['category'] = Category::find($request->id); 
     }
     return view('admin.category.category-form')->with($data);
 }

 public function saveCategory(Request $request)
 {
   $validated = $request->validate([
       'title' => 'required|max:255',
       'status' => 'required'
   ]);

   if ($files = $request->file('image')) 
   {
     $validatedData = $request->validate([
       'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
   ]);
 }

     ///dd($request->id);
 if(isset($request->id))
 {
    $category = Category::find($request->id);
    $msg = 'Category updated successfully';
} else
{
   $category = new Category;
   $msg = 'Category saved successfully';
}

$category->title = $request->title;


if ($files = $request->file('image')) {
  if(\File::exists(public_path('uploads/category/'.$request->old_image))){
    \File::delete(public_path('uploads/category/'.$request->old_image));
}
$imageName = time().'.'.$request->image->extension();  
$request->image->move(public_path('uploads/category/'), $imageName);
$category->image = $imageName;
}

$category->status = $request->status;
$category->slug = Str::of($request->title)->slug('-');
$category->save();
return redirect()->back()->with('msg',$msg);
}

public function categoryList()
{
    $data['categories'] = Category::paginate(10);
    return view('admin.category.category-list')->with($data);
}

public function updateStatus(Request $request)
{
   $id = $request->id;
   $getData = Category::where('id',$id)->first();
   $status = $getData->status;
   $new_status = $status == 0 ? 1 : 0;
   $category = Category::find($id);
   $category->status = $new_status;
   $category->save();
   return response()->json(['msg'=>'success']);
}

public function deleteCategory(Request $request)
{
  $id = $request->id;
  
  $row = Category::find($id);
  if(\File::exists(public_path('uploads/category/'.$row->image))){
      \File::delete(public_path('uploads/category/'.$row->image));
  }
  $delData = Category::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}
}
