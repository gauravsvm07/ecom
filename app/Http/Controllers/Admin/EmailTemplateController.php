<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\EmailTemplate;
use File;


class EmailTemplateController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function emailTemplateForm(Request $request)
  {
    $data['template'] = '';
    if ($request->id) {
      $data['template'] = EmailTemplate::find($request->id);
    }
    return view('admin.template.template-form')->with($data);
  }

  public function saveEmailTemplate(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required|max:255',
      'description' => 'required',
      'status' => 'required',
    ]);


    ///dd($request->id);
    if (isset($request->id)) {
      $template = EmailTemplate::find($request->id);
      $msg = 'Template updated successfully';
    } else {
      $template = new EmailTemplate;
      $msg = 'Template saved successfully';
    }

    $template->title = $request->title;
    $template->description = $request->description;
    $template->slug = Str::slug($request->name, '-') . '-' . time();
    $template->status = $request->status;
    $template->save();
    return redirect()->back()->with('msg', $msg);
  }

  public function emailTemplateList()
  {
    $data['templates'] = EmailTemplate::paginate(10);
    return view('admin.template.template-list')->with($data);
  }


  public function deleteEmailTemplate(Request $request)
  {
    $id = $request->id;
    $row = EmailTemplate::find($id);
    $delData = FeEmailTemplateature::where('id', $id)->delete();
    return response()->json(['msg' => 'deleted']);
  }
}
