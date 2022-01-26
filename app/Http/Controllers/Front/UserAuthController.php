<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use Hash;
use Response;
use Auth;
use Mail;

use Illuminate\Routing\Controller as BaseController;

class UserAuthController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function signup(Request $request)
	{
		return view('front.signup');
	}

	public function saveUser(Request $request)
	{
		$validate = $request->validate([
			'first_name' => 'regex:/^[a-zA-Z ]+$/',
			'last_name' => 'regex:/^[a-zA-Z ]+$/',
			'email' => 'required|email|max:255|unique:users',
		]);

		$user = new User();
		$user->name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->uuid = Str::uuid($request->email);
		if ($request->filled('password')) {
			$user->password = Hash::make($request->password);
		} else {
			$user->password = Hash::make('hero123');
		}
		$user->user_type = 1;
		$user->status = 1;
		$user->save();
		return redirect()->back()->with('msg', 'User registered successfully.');
	}


	public function verifyUser(Request $request)
	{
		$uuid = $request->uuid;
		$user = User::where('uuid', $uuid)->first();
		$userId = $user->id;
		$userUpdate = User::find($userId);
		$userUpdate->status = 1;
		$userUpdate->save();
		return redirect('login')->with('msg', 'Account verified successfully. Please login here.');
	}

	public function userAuth(Request $request)
	{
		$validate = $request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
			$request->session()->regenerate();

			if (isset($request->back_url) && $request->back_url != '') {
				return redirect($request->back_url);
			} else {
				return redirect('user/index');
			}
		} else {
			return redirect()->back()->with('msg', 'Please enter valid Email Or Password.');
		}
	}


	public function resetPassword(Request $request)
	{
		$email = $request->email;
		$validatedData = $request->validate([
			'email' => 'required|email',
		]);
		$countUser = User::where('email', $email)->count();

		if ($countUser == 1) {
			$link = '';
			$user = User::where('email', $email)->first();
			$uuid = $user->uuid;

			$to = $user->email;
			$subject = "Reset Password";

			$message = '<style type="text/css">
			a:hover {
				text-decoration: underline !important;
			}
		</style>
		
		<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
			<table>
				<tr>
					<td>
						<table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td style="height:80px;">&nbsp;</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									<a href="https://heromedallions.com/" title="logo" target="_blank">
										<img width="60" src="https://heromedallions.markupdesigns.net/front/images/logo.png" title="logo" alt="logo">
									</a>
								</td>
							</tr>
							<tr>
								<td style="height:20px;">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
										<tr>
											<td style="height:40px;">&nbsp;</td>
										</tr>
										<tr>
											<td style="padding:0 35px;">
												<h1>You have
													requested to reset your password</h1>
												<span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
												<p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
													We cannot simply send you your old password. A unique link to reset your
													password has been generated for you. To reset your password, click the
													following link and follow the instructions.
												</p>
												<a href="https://heromedallions.markupdesigns.net/get-password?token=$uuid" style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
													Password</a>
											</td>
										</tr>
										<tr>
											<td style="height:40px;">&nbsp;</td>
										</tr>
									</table>
								</td>
							<tr>
								<td style="height:20px;">&nbsp;</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									<p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>www.heromedallions.com</strong></p>
								</td>
							</tr>
							<tr>
								<td style="height:80px;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>';

			$header = "From:abc@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			$retval = mail($to, $subject, $message, $header);

			if ($retval == true) {
				return redirect()->back()->with('msg', 'password reset link sent to your registered email id.');
			} else {
				return redirect()->back()->with('msg', 'Something went wrong....');
			}

			// $data = ['name' => $user->name, 'email' => $user->email, 'uuid' => $uuid, 'link' => $link];
			// Mail::send('emails.reset-password', $data, function ($message) use ($data) {
			// 	$message->to($data['email'])->from('noreply@heromedallions.com', 'Hero Medallions')->subject('Reset Password');
			// });

		} else {
			return redirect()->back()->with('msg', 'Email Id does not exist. Please enter valid email id');
		}
	}

	public function getPassword(Request $request)
	{
		$token = $request->token;
		if (isset($token) && $token != '') {
			return view('front/get-password', ['token' => $token]);
		} else {
			return redirect()->back()->with('msg', 'Invalid request');
		}
	}

	public function updateResetPassword(Request $request)
	{
		$validatedData = $request->validate([
			'password' => 'required|min:6',
			'password_confirmation' => 'required|same:password',
		]);

		$token = $request->token;
		$userCount = User::where('uuid', $token)->count();

		if ($userCount > 0) {
			$user = User::where('uuid', $token)->first();
			$userId = $user->id;
			$obj_user = User::find($userId);
			$obj_user->password = Hash::make($request->password);
			$obj_user->save();
			return redirect('signin')->with('msg', 'Password changed successfully. Please login here.');
		} else {
			dd('invalid token..');
		}
	}

	public function updatePassword(Request $request)
	{
		$validatedData = $request->validate([
			'current_password' => 'required',
			'password' => 'required|min:6',
			'password_confirmation' => 'required|same:password',
		]);

		$user_password = Auth::User()->password;
		if (Hash::check($request->current_password, $user_password)) {
			$user_id = Auth::User()->id;
			$obj_user = User::find($user_id);
			$obj_user->password = Hash::make($request->password);
			$obj_user->save();
			return redirect()->back()->with('msg', 'Password changed successfully.');
		} else {
			return redirect()->back()->with('msg', 'Please enter valid Current Password.');
		}
	}



	public function signin(Request $request)
	{
		if (isset($request->back_url)) {
			$data['back_url'] = $request->back_url;
		} else {
			$data['back_url'] = '';
		}

		return view('front.signin')->with($data);
	}

	public function forgotPassword(Request $request)
	{
		return view('front.forgot-password');
	}



	public function logout(Request $request)
	{
		Auth::logout();
		///return redirect('signin');
		return redirect('/');
	}
}
