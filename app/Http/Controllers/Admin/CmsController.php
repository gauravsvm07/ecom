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
use App\Models\PageCategory;
use App\Models\PageSection;
use App\Models\Cms;
use File;


class CmsController extends BaseController
{
    private $module = 'cms';
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function pageCategoryForm(Request $request)
  {   
      if(!Helper::adminCan($this->module,'add')) return dd('No Permission');
    if(!Helper::adminCan($this->module,'update')) return dd('No Permission');

    $data['page_category'] = '';
    if($request->id)
    {
     $data['page_category'] = PageCategory::find($request->id); 
   }
   return view('admin.cms.page-category-form')->with($data);
 }

 public function savePageCategory(Request $request)
 {
   $validated = $request->validate([
     'name' => 'required|max:255',
     'status' => 'required'
   ]);

     ///dd($request->id);
   if(isset($request->id))
   {
    $page_category = PageCategory::find($request->id);
    $msg = 'Page Category updated successfully';
  } else
  {
   $page_category = new PageCategory;
   $msg = 'Page Category saved successfully';
 }

 $page_category->name = $request->name;
 $page_category->slug = $request->slug;
 $page_category->status = $request->status;
 $page_category->save();
 return redirect()->back()->with('msg',$msg);
}

public function pageCategoryList()
{
    if(!Helper::adminCan($this->module,'view')) return dd('No Permission');
  $data['page_category'] = PageCategory::paginate(10);
  return view('admin.cms.page-category-list')->with($data);
}


public function deletePageCategory(Request $request)
{
  if(! Helper::adminCan($this->module,'delete')) return dd('No Permission');
  $id = $request->id;
  $delData = PageCategory::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}


public function pageSectionForm(Request $request)
{   
    if(!Helper::adminCan($this->module,'add')) return dd('No Permission');
    if(!Helper::adminCan($this->module,'update')) return dd('No Permission');

  $data['page_category'] = PageCategory::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
  $data['page_section'] = '';
  if($request->id)
  {
   $data['page_section'] = PageSection::find($request->id); 
  }
 return view('admin.cms.page-section-form')->with($data);
}

public function savePageSection(Request $request)
{
 $validated = $request->validate([
   'name' => 'required|max:255',
   'category_id' => 'required',
   'status' => 'required'
 ]);

     ///dd($request->id);
 if(isset($request->id))
 {
  $page_section = PageSection::find($request->id);
  $msg = 'Page Section updated successfully';
} else
{
 $page_section = new PageSection;
 $msg = 'Page Section saved successfully';
}
$page_section->category_id = $request->category_id;
$page_section->name = $request->name;
$page_section->slug = $request->slug;
$page_section->status = $request->status;
$page_section->save();
return redirect()->back()->with('msg',$msg);
}

public function pageSectionList()
{
    if(!Helper::adminCan($this->module,'view')) return dd('No Permission');
  $data['page_section'] = PageSection::paginate(10);
  return view('admin.cms.page-section-list')->with($data);
}


public function deletePageSection(Request $request)
{
  if(! Helper::adminCan($this->module,'delete')) return dd('No Permission');
  $id = $request->id;
  $delData = PageSection::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}


public function pageForm(Request $request)
{  
  if(!Helper::adminCan($this->module,'add')) return dd('No Permission');
    if(!Helper::adminCan($this->module,'update')) return dd('No Permission');

  $data['page'] = '';
  if($request->id)
  {
   $data['page'] = Cms::find($request->id); 
  }

  $data['page_category'] = PageCategory::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
  $data['page_section'] = PageSection::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
 return view('admin.cms.page-form')->with($data);
}

public function savePage(Request $request)
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
  $page = Cms::find($request->id);
  $msg = 'Page updated successfully';
} else
{
 $page = new Cms;
 $msg = 'Page saved successfully';
}

$page->category_id = $request->category_id;
$page->section_id = $request->section_id;
$page->title = $request->title;
$page->sub_title = $request->sub_title;
$page->short_description = $request->short_description;
$page->description = $request->description;

if ($files = $request->file('image')) {
 if(\File::exists(public_path('uploads/pages/'.$request->old_image))){
  \File::delete(public_path('uploads/pages/'.$request->old_image));
}

$imageName = time().'.'.$request->image->extension();  
$request->image->move(public_path('uploads/pages/'), $imageName);
$page->image = $imageName;
}

if(empty($request->id))
{
$page->slug = Str::of($request->title)->slug('-');
}

$page->status = $request->status;
$page->save();
return redirect()->back()->with('msg',$msg);
}

public function getPageSection(Request $request)
 {
   $category_id = $request->category_id;
   $page_section = PageSection::where('category_id',$category_id)->get();
   return Response()->json(['section'=>$page_section]);
 }

public function pageList()
{
    if(!Helper::adminCan($this->module,'view')) return dd('No Permission');
  $data['pages'] = Cms::paginate(10);
  return view('admin.cms.page-list')->with($data);
}


public function deletePage(Request $request)
{
  if(! Helper::adminCan($this->module,'delete')) return dd('No Permission');
  $id = $request->id;

  $row = Cms::find($id);
if(\File::exists(public_path('uploads/pages/'.$row->image))){
  \File::delete(public_path('uploads/pages/'.$row->image));
}

  $delData = Cms::where('id',$id)->delete();
  return response()->json(['msg'=>'deleted']);
}




}
