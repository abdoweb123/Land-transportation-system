<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\Line;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /*** get all offices ***/
    public function index()
    {
        $settings = Settings::latest()->paginate(page);
        return view('pages.Settings.index', compact('settings'));
    }



    /*** create an office ***/
    public function store(SettingsRequest $request)
    {
        $setting = new Settings();
        $setting->time_to_edit = $request->time_to_edit;
        $setting->time_to_edit_without_fee = $request->time_to_edit_without_fee;
        $setting->cancelFee = $request->cancelFee;
        $setting->editFee = $request->editFee;
        $setting->admin_id = auth('admin')->id();
        $setting->active = 1;
        $setting->save();

        $lines = Line::all();
        foreach ($lines as $line)
        {
            $line->time_to_edit = $setting->time_to_edit;
            $line->time_to_edit_without_fee = $setting->time_to_edit_without_fee;
            $line->cancelFee = $setting->cancelFee;
            $line->editFee = $setting->editFee;
            $line->update();
        }

        return redirect()->back()->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update the office ***/
    public function update(SettingsRequest $request, Settings $setting)
    {
        $setting->time_to_edit = $request->time_to_edit;
        $setting->time_to_edit_without_fee = $request->time_to_edit_without_fee;
        $setting->cancelFee = $request->cancelFee;
        $setting->editFee = $request->editFee;
        $setting->admin_id = auth('admin')->id();
        $setting->active = $request->active;
        $setting->update();

        $lines = Line::all();
        foreach ($lines as $line)
        {
            $line->time_to_edit = $setting->time_to_edit;
            $line->time_to_edit_without_fee = $setting->time_to_edit_without_fee;
            $line->cancelFee = $setting->cancelFee;
            $line->editFee = $setting->editFee;
            $line->update();
        }

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** delete the office ***/
    public function destroy(Settings $setting)
    {
        $setting->delete();
        return redirect()->back()->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
