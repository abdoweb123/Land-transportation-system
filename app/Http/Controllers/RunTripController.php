<?php

namespace App\Http\Controllers;

use App\Http\Requests\RunTripStoreRequest;
use App\Http\Requests\RunTripUpdateRequest;
use App\Models\Admin;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\RunTrip;
use App\Models\TripData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RunTripController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $data['runTrips'] = RunTrip::latest()->paginate(page);
        $data['tripData'] = TripData::where('active',1)->select('id','name')->get();
        $data['drivers'] = Driver::where('active',1)->select('id','name')->get();
        $data['buses'] = Bus::where('active',1)->select('id','code')->get();
        $data['hosts'] = Admin::where('active',1)->where('type',3)->select('id','name')->get();
        return view('pages.RunTrips.index', compact('data'));
    }



    /*** store function  ***/
    public function store(RunTripStoreRequest $request)
    {
        // To get how many run_trip according to data
        $startDate = new \DateTime($request->startDate);
        $endDate = new \DateTime($request->endDate);

        $interval = $endDate->diff($startDate);
        $days = $interval->format('%a');

        $date = Carbon::parse($request->startDate);


        // To get Total_distance of trip
         $tripData_meters = TripData::find($request->tripData_id)->tripStations->sum('distance');


        for ($runTrip=0; $runTrip<=$days; $runTrip++)
        {
            RunTrip::create([
                'tripData_id'=>$request->tripData_id,
                'trip_distance'=>$tripData_meters,
                'driver_id'=>$request->driver_id,
                'admin_id'=>auth('admin')->id(),
                'bus_id'=>$request->bus_id,
                'host_id'=>$request->host_id,
                'type'=>$request->type,
                'active'=>1,
                'canceled' =>2,
                'startDate'=>$date,
                'startTime'=>$request->startTime,
                'notes'=>$request->notes,
                'driverTips'=>$request->driverTips,
                'hostTips'=>$request->hostTips,
            ]);

            $date->addDays(1);
        }

        return redirect()->route('runTrips.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(RunTripUpdateRequest $request)
    {
        $runTrip = RunTrip::findOrFail($request->id);

//        if ($request->startDate == \Carbon\Carbon::now()->format('Y-m-d'))
//        {
//            $request->active = 1;
//        }

        $runTrip->update([
            'tripData_id'=>$request->tripData_id,
            'driver_id'=>$request->driver_id,
            'admin_id'=>auth('admin')->id(),
            'bus_id'=>$request->bus_id,
            'host_id'=>$request->host_id,
            'type'=>$request->type,
            'active'=>$request->active,
            'startDate'=>$request->startDate,
            'startTime'=>$request->startTime,
            'notes'=>$request->notes,
            'driverTips'=>$request->driverTips,
            'hostTips'=>$request->hostTips,
            'canceled'=> $request->canceled,
        ]);

        return redirect()->route('runTrips.index')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {
        $runTrip = RunTrip::findOrFail($request->id)->delete();
        return redirect()->route('runTrips.index')->with('alert-success','تم حذف البيانات بنجاح');
    }



} //end of class
