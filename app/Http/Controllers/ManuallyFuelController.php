<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManuallyFuelRequest;
use App\Models\Bus;
use App\Models\ManuallyFuel;
use Illuminate\Http\Request;

class ManuallyFuelController extends Controller
{

    /*** get all offices ***/
    public function index()
    {
        $manuallyFuels = ManuallyFuel::latest()->paginate(page);
        $buses = Bus::where('active',1)->select('id','code')->get();
        return view('pages.ManuallyFuels.index', compact('manuallyFuels','buses'));
    }



    /*** create an office ***/
    public function store(ManuallyFuelRequest $request)
    {
        $manuallyFuel = new ManuallyFuel();
        $manuallyFuel->bus_id = $request->bus_id;
        $manuallyFuel->distance = $request->distance;
        $manuallyFuel->comments = $request->comments;
        $manuallyFuel->admin_id = auth('admin')->id();
        $manuallyFuel->active = 1;
        $manuallyFuel->save();
        return redirect()->route('manuallyFuels.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update the office ***/
    public function update(ManuallyFuelRequest $request, ManuallyFuel $manuallyFuel)
    {
        $manuallyFuel->bus_id = $request->bus_id;
        $manuallyFuel->distance = $request->distance;
        $manuallyFuel->comments = $request->comments;
        $manuallyFuel->admin_id = auth('admin')->id();
        $manuallyFuel->active = $request->active;
        $manuallyFuel->update();
        return redirect()->route('manuallyFuels.index')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** delete the office ***/
    public function destroy(ManuallyFuel $manuallyFuel)
    {
        $manuallyFuel->delete();
        return redirect()->route('manuallyFuels.index')->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
