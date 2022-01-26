<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Stripe;
use Session;


class StripeController extends Controller
{
    /**
     * payment view
     */
    public function handleGet()
    {
        $amount = Session::get('userPay')['amount'];
        ///dd($amount);
        return view('stripe',['amount'=>$amount]);
    }
  
    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {
         $amount = Session::get('userPay')['amount'];
         $user_id = Session::get('userPay')['user_id'];
         $pass = Session::get('userPay')['pass'];
        Stripe\Stripe::setApiKey('sk_test_51J03PBSGzLtayYgMKB3RaTXRU3GfWg3zgg7a1dtY35lE6xzWneWjh8UrvBgFh0ervFtDqyMLBXYLYonYGc9C5UW500DYMObcWG');
        Stripe\Charge::create ([
                "amount" => 100 * $amount,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);
        
        $current_date = Carbon::now();
        if($amount == 2.99)
        {
            $expire_date = $current_date->addDays(1);
        } else
        {
           $expire_date = $current_date->addDays(30);
        }
        
        $pay = new Payment;
        $pay->user_id = $user_id;
        $pay->amount = $amount;
        $pay->currency = 'INR';
        $pay->description = 'Web';
        $pay->purchase_date = Carbon::now();
        $pay->expire_date = $expire_date;
        $pay->save();
        
        $user = User::find($user_id);
        $user->status = 1;
        $user->save();
  
        Session::flash('success', 'Payment has been successfully processed.');
        
        $userData = User::where('id',$user_id)->first();
        if (Auth::attempt(['email' => $userData->email, 'password' => $pass,'user_type'=>2,'status'=>1])) {
			$request->session()->regenerate();
		}
          
        ///return back();
        return redirect('seller-dashboard');
    }
    
public function getApiToken(Request $request)
{
$amount = $request->amount;    

$inr_amount = $amount * 100;  
    
$stripe = new \Stripe\StripeClient(
  'sk_test_51J03PBSGzLtayYgMKB3RaTXRU3GfWg3zgg7a1dtY35lE6xzWneWjh8UrvBgFh0ervFtDqyMLBXYLYonYGc9C5UW500DYMObcWG'
);
 $result = $stripe->paymentIntents->create([
  'amount' => $inr_amount,
  'currency' => 'INR',
  'payment_method_types' => ['card'],
  "description" => "App",
   
]);

return response()->json(['status'=>'success','response'=>$result]);

}
    
}