<?php

namespace App\Http\Controllers;

use App\MarkupSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkupSettingController extends Controller
{
    //

    public function save(Request $request)
    {
        $user = Auth::user();
        $value = $request->input('markup_value');
        $type = $request->input('markup_type');
        $ask_every_time = $request->input('ask_every_time');
        $message = '';

        $markup_settings = MarkupSetting::where('user_id', $user->id)->first();

        if ($markup_settings == null) {
            $markup_settings = new MarkupSetting();
        }

        if ($type == '0') {
            $markup_settings->value = null;
            $markup_settings->type = null;
            $message = 'Please select markup type';
        } else {
            $markup_settings->value = $value;
            $markup_settings->type = $type;
        }

        if ($ask_every_time == null) {
            $markup_settings->ask_every_time = false;
        } else {
            $markup_settings->ask_every_time = true;
        }

        $markup_settings->user_id = $user->id;

        if ($markup_settings->save()) {
            if ($message != '') {
                return back()->with('info', $message);

            } else {
                return back()->with('success', 'New global pricing rules has been saved');
            }
        } else {
            return back()->with('error', 'Markup settings has not been saved');
        }
    }
}
