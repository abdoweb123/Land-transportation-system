<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeatRequest;
use App\Models\Bus;
use App\Models\BusType;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $seats = Seat::all();
        return view('pages.Seats.index', compact('seats'));
    }



    /*** create function  ***/
    public function create()
    {
        $busTypes = BusType::where('active',1)->whereDoesntHave('seats')->get();
        return view('pages.Seats.create', compact('busTypes'));
    }



    /*** store function  ***/
    public function store(StoreSeatRequest $request)
    {
          $bus = BusType::findOrFail($request->busType_id);
          $bus->width = $request->width;
          $bus->length = $request->length;
          $bus->slug = $request->slug;
          $bus->admin_id = auth('admin')->id();
          $bus->update();


        $inputs = $request->input('type');

        if (empty($inputs)){
            return redirect()->back()->with('alert-danger','برجاء اختيار التصميم');
        }


        foreach ($inputs as $id => $value)
        {
            if ($value == null)
                $value = '1';  //acceptable

                Seat::create([
                   'name'=>$id,
                   'busType_id'=>$request->busType_id,
                   'admin_id'=>auth('admin')->id(),
                   'type'=>$value,
                ]);
        }
         return redirect()->back()->with('alert-success', 'تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(Request $request)
    {
        $inputs = $request->input('type');
        foreach ($inputs as $name =>$value)
        {
            $seat = Seat::where('name',$name)->where('busType_id',$request->busType_id)->first();
            echo  $seat;
            $seat->update([
                'type'=>$value,
           ]);
        }
        return redirect()->back()->with('alert-success', 'تم تعديل البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Seat $seat)
    {
        //
    }




} //end of class
