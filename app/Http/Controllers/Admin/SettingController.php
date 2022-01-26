<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use File;


class SettingController extends BaseController
{
    ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generalSettings(Request $request)
    { 
         $setting = Setting::get();
         $globalSetting=[];
        foreach($setting as $key=>$value){
            $globalSetting[$value->setting_key] = $value->setting_value;
        } 
        return view('admin.settings.general-settings', compact('globalSetting'));
    }

    public function updateSetting(Request $request)
    {
     $data['setting'] = request()->all();
     $updateSettings = Setting::pluck('setting_key')->toArray();
     foreach($data['setting'] as $key => $value)
        { 
         if(in_array($key, $updateSettings)){
                Setting::where('setting_key', $key)->update(['setting_value' => $value]);
            } else{
                $settings = new Setting;
                $settings->setting_key    = $key;
                $settings->setting_value  = $value;
                $settings->save();       
            } 
        }    
       return redirect()->back()->with('msg','Setting saved successfully');
    }

}
