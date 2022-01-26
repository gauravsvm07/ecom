<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use File;


class BannerController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function bannerForm(Request $request)
  {
    $data['banner'] = '';
    if ($request->id) {
      $data['banner'] = Banner::find($request->id);
    }
    return view('admin.banner.banner-form')->with($data);
  }

  public function saveBanner(Request $request)
  {
    $validated = $request->validate([
      'banner_type' => 'required',
      'title' => 'required|max:255',
      'status' => 'required',
    ]);


    ///dd($request->id);
    if (isset($request->id)) {
      $banner = Banner::find($request->id);
      $msg = 'Banner updated successfully';
    } else {
      $banner = new Banner;
      $msg = 'Banner saved successfully';
    }

    $banner->banner_type = $request->banner_type;
    $banner->title = $request->title;


    if ($files = $request->file('image')) {
      if (\File::exists(public_path('uploads/banner/' . $request->old_image))) {
        \File::delete(public_path('uploads/banner/' . $request->old_image));
      }
      $imageName = time() . '.' . $request->image->extension();
      $request->image->move(public_path('uploads/banner/'), $imageName);
      $banner->image = $imageName;
    }


    $banner->status = $request->status;
    $banner->save();
    return redirect()->back()->with('msg', $msg);
  }

  public function bannerList()
  {
    $data['banners'] = Banner::paginate(10);
    return view('admin.banner.banner-list')->with($data);
  }


  public function deleteBanner(Request $request)
  {
    $id = $request->id;

    $row = Banner::find($id);
    if (\File::exists(public_path('uploads/banner/' . $row->image))) {
      \File::delete(public_path('uploads/banner/' . $row->image));
    }

    $delData = Banner::where('id', $id)->delete();
    return response()->json(['msg' => 'deleted']);
  }
}
