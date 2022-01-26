<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomCategory;
use File;


class CustomCategoryController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function customcategoryForm(Request $request)
    {
        $data['category'] = '';
        if ($request->id) {
            $data['category'] = CustomCategory::find($request->id);
        }
        return view('admin.category.custom-category-form')->with($data);
    }

    public function saveCustomCategory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required'
        ]);


        ///dd($request->id);
        if (isset($request->id)) {
            $category = CustomCategory::find($request->id);
            $msg = 'Category updated successfully';
        } else {
            $category = new CustomCategory;
            $msg = 'Category saved successfully';
        }

        $category->title = $request->title;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->slug = Str::of($request->title)->slug('-');
        $category->save();
        return redirect()->back()->with('msg', $msg);
    }

    public function customCategoryList()
    {
        $data['categories'] = CustomCategory::paginate(10);
        return view('admin.category.custom-category-list')->with($data);
    }


    public function deleteCustomCategory(Request $request)
    {
        $id = $request->id;

        $row = CustomCategory::find($id);
        $delData = CustomCategory::where('id', $id)->delete();
        return response()->json(['msg' => 'deleted']);
    }
}
