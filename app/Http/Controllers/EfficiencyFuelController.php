<?php

namespace App\Http\Controllers;

use App\Http\Requests\EfficiencyFuelsRequest;
use App\Models\Bus;
use App\Models\EfficiencyFuel;
use App\Models\RunTrip;
use App\Models\TripData;
use Illuminate\Http\Request;

class EfficiencyFuelController extends Controller
{
    /*** index function  ***/
    public function index()
    {
        $efficiencyFuels = EfficiencyFuel::latest()->paginate(page);
        $buses = Bus::where('active',1)->whereHas('runTrips')->select('id','code')->get();
        return view('pages.EfficiencyFuels.index', compact('efficiencyFuels','buses'));
    }



    /*** store function  ***/
    public function store(EfficiencyFuelsRequest $request)
    {
        $total_distance_meters = RunTrip::where('bus_id',$request->bus_id)->whereDate('startDate','<',now())->sum('trip_distance');

        $efficiencyFuel = new EfficiencyFuel();
        $efficiencyFuel->bus_id = $request->bus_id;
        $efficiencyFuel->volume = $request->volume;
        $efficiencyFuel->total_cost = $request->total_cost;
        $efficiencyFuel->notes = $request->notes;
        $efficiencyFuel->meters = $total_distance_meters;
        $efficiencyFuel->cost_per_meter = $request->total_cost / $total_distance_meters;
        $efficiencyFuel->admin_id = auth('admin')->id();
        $efficiencyFuel->active = 1;
        $efficiencyFuel->save();

        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(EfficiencyFuelsRequest $request, EfficiencyFuel $efficiencyFuel)
    {
        $tripData_id = RunTrip::where('bus_id',$request->bus_id)->select('tripData_id')->first();
        $meters = TripData::findOrFail($tripData_id)->first()->tripStations->sum('distance');

        $efficiencyFuel->bus_id = $request->bus_id;
        $efficiencyFuel->volume = $request->volume;
        $efficiencyFuel->total_cost = $request->total_cost;
        $efficiencyFuel->notes = $request->notes;
        $efficiencyFuel->meters = $meters;
        $efficiencyFuel->cost_per_meter = $request->total_cost / $meters;
        $efficiencyFuel->admin_id = auth('admin')->id();
        $efficiencyFuel->active = $request->active;
        $efficiencyFuel->update();

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(EfficiencyFuel $efficiencyFuel)
    {
        $efficiencyFuel->delete();
        return redirect()->back()->with('alert-info','تم حذف البيانات بنجاح');
    }

} //end of class
