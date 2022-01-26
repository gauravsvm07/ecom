<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Cms;
use App\Models\Enquiry;
use App\Models\UseTip;
use App\Models\Company;
use Hash;
use Response;
use Auth;
use Illuminate\Routing\Controller as BaseController;

class PageController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function index(Request $request)
	{
		$data['banners'] = Banner::where('status', 1)->where('banner_type', 'home')->orderBy('id', 'asc')->get();
		return view('front.index')->with($data);
	}

	public function aboutUs(Request $request)
	{
		$data['about'] = Cms::where(['id' => 1, 'status' => 1])->first();
		return view('front.about-us')->with($data);
	}

	public function contactUs(Request $request)
	{
		return view('front.contact');
	}

	public function saveEnquiry(Request $request)
	{
		$validate = $request->validate([
			'name' => 'regex:/^[a-zA-Z ]+$/',
			'email' => 'required|email|max:30|',
			'message' => 'required'
		]);

		$enq = new Enquiry;
		$enq->name = $request->name;
		$enq->email = $request->email;
		$enq->hear_about = $request->hear_about;
		$enq->message = $request->message;
		$enq->save();
		return redirect()->back()->with('msg', 'Inquiry saved successfully..');
	}


	public function terms(Request $request)
	{
		$data['terms'] = Cms::where(['slug' => 'reeferralnet-terms-of-use', 'status' => 1])->first();
		return view('front.terms')->with($data);
	}

	public function privacyPolicy(Request $request)
	{
		$data['privacy'] = Cms::where(['slug' => 'privacy-policy', 'status' => 1])->first();
		return view('front.privacy-policy')->with($data);
	}

	public function vendors(Request $request)
	{
		return view('front.vendors');
	}
}
