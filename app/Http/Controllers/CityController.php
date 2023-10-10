<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestCity;
use App\Http\Requests\UpdateRequestCity;
use App\Models\Admin;
use App\Models\City;
use App\Models\Office;
use App\Models\State;
use App\Models\Station;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $cities = City::latest()->paginate(page);
        $states = State::where('active',1)->select('id','name')->get();
        return view('pages.Cities.index', compact('cities','states'));
    }



    /*** store function  ***/
    public function store(StoreRequestCity $request)
    {
        try {
            $city = new City();
            $city->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $city->state_id = $request->state_id;
            $city->admin_id = auth('admin')->id();
            $city->active = 1;
            $city->save();
            return redirect()->route('cities.index')->with('alert-success',trans('main_trans.success'));
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }



    /*** update function  ***/
    public function update(UpdateRequestCity $request)
    {
        try {
            $city = City::findOrFail($request->id);
            $city->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $city->state_id = $request->state_id;
            $city->admin_id = auth('admin')->id();
            $city->active = $request->active;
            $city->update();
            return redirect()->route('cities.index')->with('alert-info',trans('main_trans.info'));
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {

//        $checkAdminStation = Station::where('city_id',$request->id)->first();
//
//        if ($checkAdminStation)
//        {
//            $checkAdminOffice = Office::where('station_id',$checkAdminStation->id)->first();
//
//            if ($checkAdminOffice)
//            {
//                $checkAdmin = Admin::where('office_id',$checkAdminOffice->id)->first();
//
//                if ($checkAdmin)
//                {
//                    return redirect()->back()->with('alert-danger','لا يمكنك حذف هذه المدينة لارتباط بعض الوظفين بها');
//                }
//                else{
//                    $city = City::findOrFail($request->id)->delete();
//                    return redirect()->route('cities.index')->with('alert-success',trans('main_trans.danger'));
//                }
//            }
//        }

        $city = City::findOrFail($request->id)->delete();
        return redirect()->route('cities.index')->with('alert-success',trans('main_trans.danger'));

    }

} //end of class
