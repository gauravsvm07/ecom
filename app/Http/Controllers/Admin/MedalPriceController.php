<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\MedalPrice;
use File;


class MedalPriceController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function medalPriceForm($id)
  {
    $data['medal'] = MedalPrice::find($id);
    return view('admin.medal_prices.medal-prices-form')->with($data);
  }

  public function saveMedalPrice(Request $request)
  {
    $validated = $request->validate([
      'medal_price' => 'required',
    ]);


    $medal = MedalPrice::find($request->id);
    $msg = 'Price updated successfully';
    $medal->medal_price = $request->medal_price;
    $medal->save();
    return redirect()->back()->with('msg', $msg);
  }

  public function medalPriceList()
  {
    $data['medals'] = MedalPrice::paginate(10);
    return view('admin.medal_prices.medal-prices-list')->with($data);
  }
}
