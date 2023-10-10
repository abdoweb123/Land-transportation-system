<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Models\Package;
use App\Models\Station;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $packages = Package::latest()->paginate(page);
        $stations = Station::where('active',1)->select('id','name')->get();
        return view('pages.Packages.index', compact('stations','packages'));
    }



    /*** store function  ***/
    public function store(PackageStoreRequest $request)
    {

        Package::create([
            'title'=>$request->title,
            'max_trips'=>$request->max_trips,
            'stationFrom_id'=>$request->stationFrom_id,
            'stationTo_id'=>$request->stationTo_id,
            'max_duration'=>$request->max_duration,
            'total'=>$request->total,
            'sub_total'=>$request->sub_total,
            'active'=>1,
            'type'=>$request->type,
            'description'=>$request->description,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(PackageUpdateRequest $request, Package $package)
    {
        $package->update([
            'title'=>$request->title,
            'total'=>$request->total,
            'sub_total'=>$request->sub_total,
            'description'=>$request->description,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->back()->with('alert-success','تم حذف البيانات بنجاح');
    }


} //end of class
