<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\Seat;
use Illuminate\Http\Request;

class BusTypeController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $busTypes = BusType::latest()->paginate(page);
        return view('pages.BusTypes.index',compact('busTypes'));
    }



    /*** store function ***/
    public function store(Request $request)
    {
        $rules    = ['name'=>'required',];
        $messages = ['name.required'=>'اسم الأسطول مطلوب'];

        $data = $this->validate($request,$rules,$messages);

        BusType::create([
            'name'=>$data['name'],
            'length'=>0,
            'width'=>0,
            'slug'=>0,
            'active'=>1,
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->route('busTypes.index')->with('alert-success','تم تسجيل الأسطول بنجاح');
    }




    /*** update function ***/
    public function update(Request $request, BusType $busType)
    {
        $rules    = ['name'=>'required',];
        $messages = ['name.required'=>'اسم الأسطول مطلوب'];

        $this->validate($request,$rules,$messages);

        $busType->update([
            'name'=>$request['name'],
            'active'=>$request['active'],
            'admin_id'=>auth('admin')->id(),
        ]);

        return redirect()->route('busTypes.index')->with('alert-info','تم تعديل الأسطول بنجاح');
    }



    /*** showBusTypeSeats function  ***/
    public function showBusTypeSeats($id)
    {
        $busType = BusType::findOrFail($id);
        $seats = Seat::where('busType_id',$id)->get();
        return view('pages.BusTypes.show_busType_seats',compact('busType','seats'));
    }



    /*** destroy function ***/
    public function destroy(BusType $busType)
    {
        $busType->delete();
        return redirect()->route('busTypes.index')->with('alert-danger','تم حذف الأسطول بنجاح');
    }


} //end of class
