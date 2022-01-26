<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\State;
use File;


class LocationController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function stateForm(Request $request)
  {
    $data['state'] = '';
    if ($request->id) {
      $data['state'] = State::find($request->id);
    }
    return view('admin.location.state-form')->with($data);
  }

  public function saveState(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'status' => 'required'
    ]);

    if (isset($request->id)) {
      $state = State::find($request->id);
      $msg = 'State updated successfully';
    } else {
      $state = new State;
      $msg = 'State saved successfully';
    }

    $state->country_id = 231;
    $state->name = $request->name;
    $state->save();
    return redirect()->back()->with('msg', $msg);
  }

  public function stateList()
  {
    $data['states'] = State::where('country_id', '231')->where('status', 1)->paginate(10);
    return view('admin.location.state-list')->with($data);
  }

  public function deleteState(Request $request)
  {
    $id = $request->id;
    $delData = State::where('id', $id)->delete();
    return response()->json(['msg' => 'deleted']);
  }
}
