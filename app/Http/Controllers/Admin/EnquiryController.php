<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Enquiry;
use File;


class EnquiryController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function enquiryList()
  {
    $data['enquiries'] = Enquiry::paginate(15);
    return view('admin.enquiry.enquiry-list')->with($data);
  }

  public function viewEnquiry($id)
  {
    $data['enquiry'] = Enquiry::where('id', $id)->first();
    return view('admin.enquiry.view-enquiry')->with($data);
  }

  public function deleteAllEnquiry(Request $request)
  {
    $ids = $request->ids;
    //echo $ids;
    //exit;
    $delData = Enquiry::whereIn('id', explode(",", $ids))->delete();
    return response()->json(['success' => "Data Deleted successfully."]);
  }
}
