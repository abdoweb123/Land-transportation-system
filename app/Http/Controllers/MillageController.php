<?php

namespace App\Http\Controllers;

use App\Http\Requests\MillageRequest;
use App\Models\Coupon;
use App\Models\Millage;
use Illuminate\Http\Request;

class MillageController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $millages = Millage::latest()->paginate(page);
        $coupons = Coupon::where('active',1)->select('id','code')->get();
        return view('pages.Millages.index', compact('millages','coupons'));
    }



    /*** store function  ***/
    public function store(MillageRequest $request)
    {
         Millage::create([
             'type'=>$request->type,
             'minimum'=>$request->minimum,
             'coupon_id'=>$request->coupon_id,
             'admin_id'=>auth('admin')->id(),
         ]);

        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(MillageRequest $request, Millage $millage)
    {
        $millage->update([
            'type'=>$request->type,
            'minimum'=>$request->minimum,
            'coupon_id'=>$request->coupon_id,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Request $request, Millage $millage)
    {
        $millage->delete();
        return redirect()->back()->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
