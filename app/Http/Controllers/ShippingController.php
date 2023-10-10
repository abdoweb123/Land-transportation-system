<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Les;
use App\Models\Shipping;
use App\Models\Station;
use App\Models\TripData;
use App\Models\TripSeat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingController extends Controller
{

//    /*** getStationsOfTrip function  ***/
//    public function getStationsOfTrip($id)
//    {
//        $tripStations = TripStation::where('tripData_id',$id)->orderBy('rank')->paginate(10);
//        $tripData = TripData::find($id);
//        $stations = Station::select('id','name')->get();
//        return view('pages.TripData.TripStations.index', compact('tripData','tripStations','stations'));
//    }



    /*** create Noluon (shipping)  ***/
    public function create(Request $old_request)
    {
        $stations = Station::where('active',1)->select('id','name')->get();
        $users = User::where('active',1)->select('id','name','mobile','nationalId')->get();
        $tripSeats = TripSeat::where('tripData_id',$old_request->tripData_id)->select('id')->get();
        return view('pages.ReservationBookingRequests.bookShipping',compact('users','stations','old_request','tripSeats'));
    }


    /*** edit Noluon (shipping)  ***/
    public function edit($shipping_id,$tripData_id)
    {
        $shipping = Shipping::find($shipping_id);
        $stations = Station::where('active',1)->select('id','name')->get();
        $users = User::where('active',1)->select('id','name','mobile')->get();
        $tripSeats = TripSeat::where('tripData_id',$tripData_id)->select('id')->get();
        return view('pages.Shippings.edit',compact('users','stations','shipping','tripSeats'));
    }


    /*** create new client function ***/
    public function createNewUser(UserStoreRequest $old_request)
    {
        $newUser = new User();
        $newUser->name = $old_request['name'];
        $newUser->email = $old_request['email'];
        $newUser->mobile = $old_request['mobile'];
        $newUser->nationalId = $old_request['nationalId'];
        $newUser->admin_id = auth('admin')->id();
        $newUser->password = Hash::make($old_request['password']);
        $newUser->save();

        $users = User::select('id','name','mobile')->get();

        return view('pages.ReservationBookingRequests.bookShipping',compact('newUser','old_request','users'));
    }




    /*** store function  ***/
    public function store(ShippingRequest $old_request)
    {
        $user_phone = User::find($old_request->user_id)->mobile;

        $shipping = new Shipping();
        $shipping->description = $old_request->description;
        $shipping->mass = $old_request->mass;
        $shipping->volume = $old_request->volume;
        $shipping->price = $old_request->price;
        $shipping->user_on_the_trip = $old_request->user_on_the_trip;
        $shipping->tripSeat_id = $old_request->tripSeat_id;
        $shipping->breakable = $old_request->breakable;
        $shipping->fast = $old_request->fast;
        $shipping->user_id = $old_request->user_id;
        $shipping->user_phone = $user_phone;
        $shipping->from_station_id = $old_request->stationFrom_id;
        $shipping->to_station_id = $old_request->stationTo_id;
        $shipping->run_trip_id = $old_request->runTrip_id;
        $shipping->receiver_phone = $old_request->receiver_phone;
        $shipping->receiver_name = $old_request->receiver_name;
        $shipping->receiver_nationalId = $old_request->receiver_nationalId;
        $shipping->receiving = $old_request->receiving;
        $shipping->delivering = $old_request->delivering;
        $shipping->other1 = $old_request->other1;
        $shipping->other2 = $old_request->other2;
        $shipping->admin_id = auth('admin')->id();
        $shipping->active = 1;
        $shipping->save();

        // create trigger
        $les = new Les();
        $les->amount = $old_request->price;
        $les->type = 1;
        $les->action =    ' تم تحصيل مبلغ قدره '. $old_request->price . ' من خلال حجز النولون رقم ' . $shipping->id . ' التابع للرحلة رقم ' . $old_request->runTrip_id;
        $les->admin_id = auth('admin')->id();
        $les->office_id = auth('admin')->user()->office_id;
        $les->active = 1;
        $les->save();

        return redirect()->back()->with(['alert-success'=>'تم تسجيل البيانات بنجاح','old_request']);
    }



    /*** store function  ***/
    public function update(Shipping $shipping,ShippingRequest $old_request)
    {
        $shipping->description = $old_request->description;
        $shipping->mass = $old_request->mass;
        $shipping->volume = $old_request->volume;
        $shipping->price = $old_request->price;
        $shipping->user_id = $old_request->user_id;
        $shipping->user_on_the_trip = $old_request->user_on_the_trip;
        $shipping->tripSeat_id = $old_request->tripSeat_id;
        $shipping->breakable = $old_request->breakable;
        $shipping->fast = $old_request->fast;
        $shipping->receiver_phone = $old_request->receiver_phone;
        $shipping->receiver_name = $old_request->receiver_name;
        $shipping->other1 = $old_request->other1;
        $shipping->other2 = $old_request->other2;
        $shipping->receiver_nationalId = $old_request->receiver_nationalId;
        $shipping->receiving = $old_request->receiving;
        $shipping->delivering = $old_request->delivering;
        $shipping->admin_id = auth('admin')->id();
        $shipping->active = 1;
        $shipping->update();

        return redirect()->back()->with(['alert-success'=>'تم تعديل البيانات بنجاح','old_request']);
    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {
        $shipping = Shipping::findOrFail($request->id)->delete();

        return redirect()->back()->with('alert-success','تم حذف البيانات بنجاح');
    }


} //end of class
