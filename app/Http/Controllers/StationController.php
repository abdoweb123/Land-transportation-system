<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestStation;
use App\Http\Requests\UpdateRequestStation;
use App\Models\Admin;
use App\Models\City;
use App\Models\Office;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{

   /*** index function  ***/
    public function index()
    {
        $stations = Station::latest()->paginate(page);
        $cities = City::where('active',1)->select('id','name')->get();
        return view('pages.Stations.index', compact('stations','cities'));
    }



    /*** store function  ***/
    public function store(StoreRequestStation $request)
    {
        try {
            $station = new Station();
            $station->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $station->city_id = $request->city_id;
            $station->admin_id = auth('admin')->id();
            $station->active = 1;
            $station->save();
            return redirect()->route('stations.index')->with('alert-success',trans('main_trans.success'));
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }



    /*** update function  ***/
    public function update(UpdateRequestStation $request)
    {
        try {
            $station = Station::findOrFail($request->id);
            $station->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $station->city_id = $request->city_id;
            $station->admin_id = auth('admin')->id();
            $station->active = $request->active;
            $station->update();
            return redirect()->route('stations.index')->with('alert-success',trans('main_trans.success'));
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {

//        $checkAdminOffice = Office::where('station_id',$request->id)->first();
//
//        if ($checkAdminOffice)
//        {
//            $checkAdmin = Admin::where('office_id',$checkAdminOffice->id)->first();
//
//            if ($checkAdmin)
//            {
//                return redirect()->back()->with('alert-danger','لا يمكنك حذف هذه المحطة لارتباط بعض الوظفين بها');
//            }
//
//
//            $station = Station::findOrFail($request->id)->delete();
//            return redirect()->route('stations.index')->with('alert-success',trans('main_trans.danger'));
//        }

        $station = Station::findOrFail($request->id)->delete();
        return redirect()->route('stations.index')->with('alert-success',trans('main_trans.danger'));
    }


} //end of class
