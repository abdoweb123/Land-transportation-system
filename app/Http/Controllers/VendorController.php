<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $vendors = Vendor::latest()->paginate(page);
        return view('pages.Vendors.index', compact('vendors'));
    }



    /*** store function  ***/
    public function store(VendorRequest $request)
    {
        Vendor::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'description'=>$request->description,
            'active'=>1,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(VendorRequest $request, Vendor $vendor)
    {
        $vendor->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'description'=>$request->description,
            'active'=>$request->active,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->back()->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
