<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Lead;
use App\Models\NewsletterEmail;
use Auth;


class NewsletterController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function newsletterEmails(Request $request)
  {
    $data['emails'] = NewsletterEmail::paginate();
      //dd($data['emails']);
    return view('admin.newsletter.newsletter-emails')->with($data);
  }


  public function deleteNewsletterEmail(Request $request)
  {
    $id = $request->id;
    $delData = NewsletterEmail::where('id',$id)->delete();
    return response()->json(['msg'=>'deleted']);
  }
  

}
