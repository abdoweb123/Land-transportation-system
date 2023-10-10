<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusOwnerRequest;
use App\Models\BusOwner;
use Illuminate\Http\Request;

class BusOwnerController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $busOwners = BusOwner::latest()->paginate(page);
        return view('pages.BusOwners.index', compact('busOwners'));
    }



    /*** store function ***/
    public function store(BusOwnerRequest $request)
    {
        $busOwner = new BusOwner();
        $busOwner->name = $request->name;
        $busOwner->admin_id = auth('admin')->id();
        $busOwner->active = 1;
        $busOwner->save();

        return redirect()->route('busOwners.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(BusOwnerRequest $request, BusOwner $busOwner)
    {
        $busOwner->name = $request->name;
        $busOwner->admin_id = auth('admin')->id();
        $busOwner->active = $request->active;
        $busOwner->update();

        return redirect()->route('busOwners.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(BusOwner $busOwner)
    {
        $busOwner->delete();
        return redirect()->route('busOwners.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
