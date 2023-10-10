<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRunTripStoreRequest;
use App\Http\Requests\RunTripStoreRequest;
use App\Models\Admin;
use App\Models\BookingSeat;
use App\Models\Bus;
use App\Models\BusType;
use App\Models\Driver;
use App\Models\ReservationBookingRequest;
use App\Models\RunTrip;
use App\Models\Seat;
use App\Models\TripData;
use App\Models\TripDegree;
use App\Models\TripSeat;
use App\Models\TripStation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Whoops\Run;

class TripSeatController extends Controller
{


    /***  showBusTypeSeats  ***/
    public function showBusTypeSeatsOfTrip($id)
    {
        $tripData = TripData::findOrFail($id);
        $tripDegrees = $tripData->tripDegrees;
        $tripSeats = TripSeat::where('tripData_id',$id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        $seats = Seat::where('busType_id',$tripData->busType->id)->get();
        return view('pages.TripData.TripSeats.showSeatsBusTypeOfTrip',compact('busType','seats','tripDegrees','tripData','tripSeats'));
    }



    /***  createTripSeats  ***/
    public function createTripSeats(Request $request)
    {

        $inputs = $request->input('type');
        foreach ($inputs as $tripSeat_id => $value)
        {

//            $arrValues[] = $value;
//
//            if ($value == null) {
//                $Value = $request->initial_degree;


                    TripSeat::create([
                        'tripData_id'=>$request->tripData_id,
                        'admin_id'=>auth('admin')->id(),
                        'seat_id'=>$tripSeat_id,
                        'degree_id'=>$value,
                    ]);

//                }
//                 else
//                 {
//                     TripSeat::create([
//                         'tripData_id'=>$request->tripData_id,
//                         'admin_id'=>auth('admin')->id(),
//                         'seat_id'=>$tripSeat_id,
//                         'degree_id'=>$value,
//                     ]);
//                 }

            }



        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
        }



    /***  updateTripSeats  ***/
    public function updateTripSeats(Request $request)
    {

//        return $request;

        $inputs = $request->input('type');
        foreach ($inputs as $tripSeat_id => $value)
        {

            $tripSeat = TripSeat::where('id',$tripSeat_id)->where('tripData_id',$request->tripData_id)->first();

//            $arrValues[] = $value;
//
//            if ($value == null) {
//                $value = $request->initial_degree;

                $tripSeat->update([
                        'tripData_id'=>$request->tripData_id,
                        'admin_id'=>auth('admin')->id(),
                        'degree_id'=>$value,
                    ]);

//                }
//                 else
//                 {
//                     $tripSeat->update([
//                         'tripData_id'=>$request->tripData_id,
//                         'admin_id'=>auth('admin')->id(),
//                         'degree_id'=>$value,
//                     ]);
//                 }

            }



        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
        }



    /***  move_trip_seats_page  ***/
    public function move_trip_seats_page()
    {
        $data['runTrips'] = RunTrip::latest()->paginate(100);
        $data['tripData'] = TripData::select('id','name')->get();
        $data['drivers'] = Driver::select('id','name')->get();
        $data['buses'] = Bus::select('id','code')->get();
        $data['hosts'] = Admin::where('type',3)->select('id','name')->get();

        return view('pages.ReservationBookingRequests.move_trip_seats_page.move_trip_seats_page',compact('data'));
    }



    /***  search_for_old_run_trip  ***/
    public function search_for_old_run_trip(Request $request_old_run_trip)
    {
        $data['runTrips'] = RunTrip::latest()->paginate(100);
        $data['tripData'] = TripData::select('id','name')->get();
        $data['drivers'] = Driver::select('id','name')->get();
        $data['buses'] = Bus::select('id','code')->get();
        $data['hosts'] = Admin::where('type',3)->select('id','name')->get();

        $old_runTrip = RunTrip::find($request_old_run_trip->edit_from_trip_id);

        if (!$old_runTrip)
        {
            return redirect()->back()->with('alert-danger','هذه الرحلة غير موجودة');
        }
        else{

            $old_tickets = ReservationBookingRequest::where('runTrip_id',$request_old_run_trip->edit_from_trip_id)->get();

            $old_booking_seats = BookingSeat::whereHas('reservationBooking',function ($q) use($request_old_run_trip){

                $q->where('runTrip_id',$request_old_run_trip->edit_from_trip_id);
            })->get();

            return view('pages.ReservationBookingRequests.move_trip_seats_page.move_trip_seats_page',compact('old_runTrip','request_old_run_trip','old_tickets','old_booking_seats','data'));
        }
    }



    /***  search_for_new_run_trip  ***/
    public function search_for_new_run_trip(Request $request_new_run_trip)
    {
//        return $request_new_run_trip;

        $data['runTrips'] = RunTrip::latest()->paginate(100);
        $data['tripData'] = TripData::select('id','name')->get();
        $data['drivers'] = Driver::select('id','name')->get();
        $data['buses'] = Bus::select('id','code')->get();
        $data['hosts'] = Admin::where('type',3)->select('id','name')->get();

        /* عشان يرجع بيانات الرحلة القديمة */
        $old_runTrip = RunTrip::find($request_new_run_trip->old_run_trip);
        if ($old_runTrip)
        {
            $old_tickets = ReservationBookingRequest::where('runTrip_id',$request_new_run_trip->old_run_trip)->get();

            $old_booking_seats = BookingSeat::whereHas('reservationBooking',function ($q) use($request_new_run_trip){

                $q->where('runTrip_id',$request_new_run_trip->old_run_trip);
            })->get();
        }
        else{
            $old_tickets = null;
            $old_booking_seats = null;
        }
        /* عشان يرجع بيانات الرحلة القديمة */



        /* get new run_trip data */
        $new_runTrip = RunTrip::find($request_new_run_trip->edit_from_new_trip_id);
        /* عشان لو ملقاش ال runTrip أصلا */
        if (!$new_runTrip)
        {
            return redirect()->back()->with('alert-danger','هذه الرحلة غير موجودة');
        }


        $new_runTrip_with_same_tripData_of_old_runTrip = RunTrip::where('id',$request_new_run_trip->edit_from_new_trip_id)->where('tripData_id',$old_runTrip->tripData_id)->first();
        /* عشان لو لقى ال runTrip ولكن في اختلاف في ال tripData_id */
        if (!$new_runTrip_with_same_tripData_of_old_runTrip)
        {
            return redirect()->back()->with('alert-danger','بيانات الرحلة التي بحثت عنها غير متوافقة مع بيانات الرحلة الحالية');
        }
        else{

            $new_booking_seats = BookingSeat::whereHas('reservationBooking',function ($q) use($request_new_run_trip){

                $q->where('runTrip_id',$request_new_run_trip->edit_from_new_trip_id);
            })->get();
            $tripData_of_new_runTrip = TripData::find($new_runTrip->tripData_id);
            $new_trip_seats = TripSeat::where('tripData_id',$tripData_of_new_runTrip->id)->get();

            return view('pages.ReservationBookingRequests.move_trip_seats_page.move_trip_seats_page',compact('old_runTrip','request_new_run_trip','old_tickets','old_booking_seats','new_runTrip','new_trip_seats','new_booking_seats','data'));
        }

    }



    /***  create_new_run_trip  ***/
    public function create_new_run_trip(NewRunTripStoreRequest $request_new_run_trip)
    {

//        $data['runTrips'] = RunTrip::latest()->paginate(100);
//        $data['tripData'] = TripData::select('id','name')->get();
//        $data['drivers'] = Driver::select('id','name')->get();
//        $data['buses'] = Bus::select('id','code')->get();
//        $data['hosts'] = Admin::where('type',3)->select('id','name')->get();


//        /* عشان يرجع بيانات الرحلة القديمة */
//        $old_runTrip = RunTrip::find($request_new_run_trip->old_run_trip);
//        if ($old_runTrip)
//        {
//            $old_tickets = ReservationBookingRequest::where('runTrip_id',$request_new_run_trip->old_run_trip)->get();
//
//            $old_booking_seats = BookingSeat::whereHas('reservationBooking',function ($q) use($request_new_run_trip){
//
//                $q->where('runTrip_id',$request_new_run_trip->old_run_trip);
//            })->get();
//        }
//        /* عشان يرجع بيانات الرحلة القديمة */

        $old_runTrip_id = $request_new_run_trip->old_run_trip;


        /* create new run_trip data */
        // To get Total_distance of trip
        $tripData_meters = TripData::find($request_new_run_trip->tripData_id)->tripStations->sum('distance');

        $new_runTrip = new RunTrip();
        $new_runTrip->tripData_id = $request_new_run_trip->tripData_id;
        $new_runTrip->trip_distance = $tripData_meters;
        $new_runTrip->driver_id = $request_new_run_trip->driver_id;
        $new_runTrip->admin_id = auth('admin')->id();
        $new_runTrip->bus_id = $request_new_run_trip->bus_id;
        $new_runTrip->host_id = $request_new_run_trip->host_id;
        $new_runTrip->type = $request_new_run_trip->type;
        $new_runTrip->active = 1;
        $new_runTrip->canceled  = 2;
        $new_runTrip->startDate = $request_new_run_trip->startDate;
        $new_runTrip->startTime = $request_new_run_trip->startTime;
        $new_runTrip->notes = $request_new_run_trip->notes;
        $new_runTrip->driverTips = $request_new_run_trip->driverTips;
        $new_runTrip->hostTips = $request_new_run_trip->hostTips;
        $new_runTrip->save();


//        return view('pages.ReservationBookingRequests.move_trip_seats_page.move_trip_seats_page',compact('old_runTrip','request_new_run_trip','old_tickets','old_booking_seats','new_runTrip','data'));

        return redirect()->route('return_page_of_move_tripSeats',[$new_runTrip->id,$old_runTrip_id]);
    }



    /***  return_page_of_move_tripSeats  ***/
    public function return_page_of_move_tripSeats($new_runTrip_id , $old_runTrip_id)
    {
        $data['runTrips'] = RunTrip::latest()->paginate(100);
        $data['tripData'] = TripData::select('id','name')->get();
        $data['drivers'] = Driver::select('id','name')->get();
        $data['buses'] = Bus::select('id','code')->get();
        $data['hosts'] = Admin::where('type',3)->select('id','name')->get();



        /* عشان يرجع بيانات الرحلة القديمة */
        $old_runTrip = RunTrip::find($old_runTrip_id);
        if ($old_runTrip)
        {
            $old_tickets = ReservationBookingRequest::where('runTrip_id',$old_runTrip_id)->get();

            $old_booking_seats = BookingSeat::whereHas('reservationBooking',function ($q) use($old_runTrip_id){

                $q->where('runTrip_id',$old_runTrip_id);
            })->get();
        }
        /* عشان يرجع بيانات الرحلة القديمة */


        $new_runTrip = RunTrip::find($new_runTrip_id);
        $new_trip_seats = TripSeat::where('tripData_id',$new_runTrip->tripData_id)->get();

        return view('pages.ReservationBookingRequests.move_trip_seats_page.move_trip_seats_page',compact('old_runTrip','old_tickets','old_booking_seats','new_runTrip','data','new_trip_seats'));

    }



    /***  make_movements_of_tripSeats  ***/
    public function make_movements_of_tripSeats(Request $request)
    {
//        return $request;

        if (!$request->has('from_ticket_old_runTrip') || !$request->has('to_ticket_old_runTrip') || !$request->has('from_seat_new_runTrip') || !$request->has('to_seat_new_runTrip') || !$request->has('old_run_trip') || !$request->has('new_run_trip_id'))
        {
            return redirect()->back()->with('alert-danger','برجاء إتمام إدخال البيانات');
        }

        $old_run_trip = RunTrip::find($request->old_run_trip);
        $new_run_trip = RunTrip::find($request->new_run_trip_id);

        $tickets_of_old_runTrip = ReservationBookingRequest::query()->where('runTrip_id',$old_run_trip->id)
                    ->whereBetween('id',[$request->from_ticket_old_runTrip,$request->to_ticket_old_runTrip])->get();


        foreach ($tickets_of_old_runTrip as $ticket)
        {
            $count_busy_seats = 0;
            $count_all_available_trip_seats = 0;
            $count_available_trip_seats = 0;
            $count_busy_seats = 0;

            $arr_busy_seats = null;
            unset($arr_busy_seats);

            $array_same_seat = null;
            unset($array_same_seat);

            $booked_tripSeats = null;
            unset($booked_tripSeats);

            $get_available_tripSeats = null;
            unset($get_available_tripSeats);


//                        return $ticket;

            /* عشان نجيب ال rank بتاع ال request->stationFrom_id */
            $request_of_trip_station_from = TripStation::where('station_id', $ticket->stationFrom_id)->where('tripData_id', $ticket->trip_id)->first();
            $request_of_trip_station_to = TripStation::where('station_id', $ticket->stationTo_id)->where('tripData_id', $ticket->trip_id)->first();


            if (!$request_of_trip_station_from || !$request_of_trip_station_to)
            {
                return redirect()->back()->with('alert-danger','البيانات المدخلة غير متوافقة');
            }

            $request_of_trip_station_from_rank = $request_of_trip_station_from->rank;
            $request_of_trip_station_to_rank = $request_of_trip_station_to->rank;



            $bookingSeats_of_newTrip = BookingSeat::where('runTrip_id',$new_run_trip->id)->get();

            $tripSeats_of_newTrip =  TripSeat::where('tripData_id',$new_run_trip->tripData_id)->whereBetween('seat_id',[$request->from_seat_new_runTrip,$request->to_seat_new_runTrip])
                                    ->whereHas('seat',function ($q){
                                        $q->where('type',1);
                                    })->get();


            foreach ($bookingSeats_of_newTrip as $bookingSeat) {

                if (
                    ($bookingSeat->tripStationFrom->rank == $request_of_trip_station_from_rank && $bookingSeat->tripStationTo->rank == $request_of_trip_station_to_rank)
                    ||
                    ($bookingSeat->tripStationTo->rank > $request_of_trip_station_to_rank && $bookingSeat->tripStationFrom->rank == $request_of_trip_station_from_rank)
                    ||
                    ($bookingSeat->tripStationFrom->rank < $request_of_trip_station_from_rank && $bookingSeat->tripStationTo->rank == $request_of_trip_station_to_rank)
                    ||
                    ($bookingSeat->tripStationFrom->rank < $request_of_trip_station_from_rank && $bookingSeat->tripStationTo->rank > $request_of_trip_station_to_rank)
                    ||
                    ($bookingSeat->tripStationTo->rank < $request_of_trip_station_to_rank && $bookingSeat->tripStationTo->rank > $request_of_trip_station_from_rank)
                    ||
                    ($bookingSeat->tripStationFrom->rank < $request_of_trip_station_to_rank && $bookingSeat->tripStationFrom->rank > $request_of_trip_station_from_rank)
                )
                {
                    {
                        $arr_busy_seats[] = $bookingSeat;
                    }

                }

            }

            /* عشان لو ملقاش عناصر يرجع لي array فاضية وميحصلش error */
            if (!isset($arr_busy_seats)){
                $arr_busy_seats = [];
            }
            //  $arr_busy_seats  الكراسي المشغولة;


            /* عشان لو نفس الكرسي محجوز اكثر من مرة بين محطتين مختلفتين ميعدهمش مرتين  (الكراسي المشغولة بدون تكرار)  */
            for ($i=0; $i<count($arr_busy_seats); $i++)
            {
                $array_same_seat[] = $arr_busy_seats[$i]->seat_id;
            }

            /* عشان لو ملقاش عناصر يرجع لي array فاضية وميحصلش error */
            if (!isset($array_same_seat)){
                $array_same_seat = [];
            }


//            return array_unique($array_same_seat);
            foreach (array_unique($array_same_seat) as $array_same_seat_id)
            {
                $booked_tripSeats[] = TripSeat::find($array_same_seat_id);
            }

            /* عشان لو ملقاش عناصر يرجع لي array فاضية وميحصلش error */
            if (!isset($booked_tripSeats)){
                $booked_tripSeats = [];
            }


            /*   $get_available_tripSeats عشان اجيب كل الكراسي المتاحة للحجز  */
                for ($i=0; $i<count($tripSeats_of_newTrip); $i++)
                {
                    $array_tripSeats_of_newTrip[] = $tripSeats_of_newTrip[$i]->id;
                }


                /* ["0"=>1,"3"=>2,"2"=>3] */
                $trip_seats_ids_available = array_diff($array_tripSeats_of_newTrip,$array_same_seat);


                foreach ($trip_seats_ids_available as $key=>$value)
                {
                    $get_available_tripSeats[] = TripSeat::find($value);
                }

//                return $get_available_tripSeats;
            /*   $get_available_tripSeats عشان اجيب كل الكراسي المتاحة للحجز  */




            /* عدد الكراسي المشغولة بدون تكرار */
            $count_busy_seats =  count(array_unique($array_same_seat));

            /* عدد الكراسي الكلية للرحلة */
            $count_available_trip_seats = $tripSeats_of_newTrip->count();





//            return $tripSeats_of_newTrip;


            /* عدد الكراسي المتاحة للحجز */
            $count_all_available_trip_seats = $count_available_trip_seats - $count_busy_seats;



             /* لو عدد الكراسي الموجودة في الرحلة الجديدة اكبر من عدد الكراسي الموجودة في التذكرة التابعة للرحلة القديمة تمام غير كدا شوف التذكرة اللي بعدها */
            if ($count_all_available_trip_seats >= $ticket->bookingSeats->count())
            {
                DB::beginTransaction();
                try {
                    $ticket = ReservationBookingRequest::find($ticket->id);
                    $ticket->runTrip_id = $new_run_trip->id;
                    $ticket->trip_id = $new_run_trip->tripData_id;
                    $ticket->admin_id = auth('admin')->id();
                    $ticket->office_id = auth('admin')->user()->office_id;
                    $ticket->update();

                    $i=0;
                    foreach ($ticket->bookingSeats as $old_bookedSeat) //4
                    {

                        $old_bookedSeat->booking_id = $ticket->id;
                        $old_bookedSeat->runTrip_id = $ticket->runTrip_id;
                        $old_bookedSeat->seat_id = $get_available_tripSeats[$i]->id;
                        $old_bookedSeat->admin_id = auth('admin')->id();
                        $old_bookedSeat->office_id = auth('admin')->user()->office_id;
                        $old_bookedSeat->update();
//                        $new_bookingSeat = new BookingSeat();
//                        $new_bookingSeat->booking_id = $ticket->id;
//                        $new_bookingSeat->runTrip_id = $ticket->runTrip_id;
//                        $new_bookingSeat->seat_id = $all_available_seats_of_new_run_trip_in_this_route[$i]['id'];
//                        $new_bookingSeat->degree_id = $old_bookedSeat->degree_id;
//                        $new_bookingSeat->office_id =  $old_bookedSeat->office_id;
//                        $new_bookingSeat->city_id = $old_bookedSeat->city_id;
//                        $new_bookingSeat->total =  $old_bookedSeat->total;
//                        $new_bookingSeat->sub_total =  $old_bookedSeat->sub_total;
//                        $new_bookingSeat->admin_id = auth('admin')->id();
//                        $new_bookingSeat->active = $old_bookedSeat->active;
//                        $new_bookingSeat->save();
//
//                        $old_bookedSeat->delete()

                        $i++;
                        DB::commit();
                    }
                } catch (\Exception $e){
                    DB::rollBack();
                    return redirect()->back()->with('alert-danger','حدث خطأ ما');
                }

            }

        }

        return redirect()->back()->with('alert-success','تم نقل المقاعد بنجاح');
    }



//    /***  make_movements_of_tripSeats  ***/
//    public function make_movements_of_tripSeats(Request $request)
//    {
////        return $request;
//
//        if (!$request->has('from_ticket_old_runTrip') || !$request->has('to_ticket_old_runTrip') || !$request->has('from_seat_new_runTrip') || !$request->has('to_seat_new_runTrip') || !$request->has('old_run_trip') || !$request->has('new_run_trip_id'))
//        {
//            return redirect()->back()->with('alert-danger','برجاء إتمام إدخال البيانات');
//        }
//
//        $old_run_trip = RunTrip::find($request->old_run_trip);
//        $new_run_trip = RunTrip::find($request->new_run_trip_id);
//
//        $tickets_of_old_runTrip = ReservationBookingRequest::query()->where('runTrip_id',$old_run_trip->id)->whereBetween('id',[$request->from_ticket_old_runTrip,$request->to_ticket_old_runTrip])->get();
//
//
//        foreach ($tickets_of_old_runTrip as $ticket)
//        {
////            return $ticket;
//
//            /* هنا هيجيب كل الكراسي اللي في الرحلة الجديدة علي نفس الخط بتاع التذكرة التي سيتم استبدال كراسيها  */
//            $get_seats_of_new_runTrip_with_same_route = TripSeat::query()->where('tripData_id',$new_run_trip->tripData_id)
//                ->whereHas('seat',function ($q3) use($request){
//                    $q3->whereBetween('seat_id',[$request->from_seat_new_runTrip,$request->to_seat_new_runTrip])->where('type',1);
//                })
//                ->whereHas('bookingSeats',function ($q1) use($ticket,$new_run_trip){
//                    $q1->where('runTrip_id',$new_run_trip->id);
//                    $q1->whereHas('reservationBooking',function ($q2) use($ticket,$new_run_trip){
//                        $q2->where('stationFrom_id','=',$ticket->stationFrom_id)->where('stationTo_id','=',$ticket->stationTo_id)->where('runTrip_id',$new_run_trip->id);
//                    });
//                })->get()->toArray();
//
//
//            /* هنا هيجيب كل الكراسي اللي في الرحلة الجديدة علي خط مختلف عن الخط بتاع التذكرة التي سيتم استبدال كراسيها  */
//            $get_seats_of_new_runTrip_with_different_route = TripSeat::query()->where('tripData_id',$new_run_trip->tripData_id)
//                ->whereHas('seat',function ($q3) use($request){
//                    $q3->whereBetween('seat_id',[$request->from_seat_new_runTrip,$request->to_seat_new_runTrip])->where('type',1);
//                })
//                ->whereHas('bookingSeats',function ($q1) use($ticket,$new_run_trip){
//                    $q1->where('runTrip_id',$new_run_trip->id);
//                    $q1->whereHas('reservationBooking',function ($q2) use($ticket,$new_run_trip){
//                        $q2->where('stationFrom_id','!=',$ticket->stationFrom_id)->where('stationTo_id','!=',$ticket->stationTo_id)->where('runTrip_id',$new_run_trip->id);
//                    });
//                })->get()->toArray();
//
//            /* هنا هنشوف اي هيا الكراسي اللي محجوزة في خط تاني ومش محجوزة في الخط دا */
//            $get_seats_of_new_runTrip = array_diff(array_map('json_encode',$get_seats_of_new_runTrip_with_different_route),array_map('json_encode',$get_seats_of_new_runTrip_with_same_route));
//            $x = array_map('json_decode',$get_seats_of_new_runTrip);
//
//
//
//            /* هنا هيجيب كل الكراسي اللي في الرحلة الجديدة وملهاش علاقة */
//            $get_seats_of_new_runTrip_with_no_relation = TripSeat::query()
//                ->where('tripData_id',$new_run_trip->tripData_id)
//                ->whereDoesntHave('bookingSeats')
//                ->whereHas('seat',function ($q1) use($ticket,$request){
//                    $q1->whereBetween('seat_id',[$request->from_seat_new_runTrip,$request->to_seat_new_runTrip])->where('type',1);
//                })
//                ->get()->toArray();
//
//            /* كل الكراسي المتاح حجزها في الرحلة الجديدة في هذا الخط */
//            $all_available_seats_of_new_run_trip_in_this_route = array_merge($x,$get_seats_of_new_runTrip_with_no_relation);
////return $all_available_seats_of_new_run_trip_in_this_route[0]['id'];
////return count($all_available_seats_of_new_run_trip_in_this_route);
//
////            return $all_available_seats_of_new_run_trip_in_this_route[0]->id;
//
//            /* لو عدد الكراسي الموجودة في الرحلة الجديدة اكبر من عدد الكراسي الموجودة في التذكرة التابعة للرحلة القديمة تمام غير كدا شوف التذكرة اللي بعدها */
//            if (count($all_available_seats_of_new_run_trip_in_this_route) > $ticket->bookingSeats->count())
//            {
//                DB::beginTransaction();
//                try {
//                    $ticket = ReservationBookingRequest::find($ticket->id);
//                    $ticket->runTrip_id = $new_run_trip->id;
//                    $ticket->trip_id = $new_run_trip->tripData_id;
//                    $ticket->admin_id = auth('admin')->id();
//                    $ticket->office_id = auth('admin')->user()->office_id;
//                    $ticket->update();
//
//                    $i=0;
//                    foreach ($ticket->bookingSeats as $old_bookedSeat) //4
//                    {
//
//                        $old_bookedSeat->booking_id = $ticket->id;
//                        $old_bookedSeat->runTrip_id = $ticket->runTrip_id;
//                        $old_bookedSeat->seat_id = $all_available_seats_of_new_run_trip_in_this_route[$i]->id;
//                        $old_bookedSeat->admin_id = auth('admin')->id();
//                        $old_bookedSeat->office_id = auth('admin')->user()->office_id;
//                        $old_bookedSeat->update();
////                        $new_bookingSeat = new BookingSeat();
////                        $new_bookingSeat->booking_id = $ticket->id;
////                        $new_bookingSeat->runTrip_id = $ticket->runTrip_id;
////                        $new_bookingSeat->seat_id = $all_available_seats_of_new_run_trip_in_this_route[$i]['id'];
////                        $new_bookingSeat->degree_id = $old_bookedSeat->degree_id;
////                        $new_bookingSeat->office_id =  $old_bookedSeat->office_id;
////                        $new_bookingSeat->city_id = $old_bookedSeat->city_id;
////                        $new_bookingSeat->total =  $old_bookedSeat->total;
////                        $new_bookingSeat->sub_total =  $old_bookedSeat->sub_total;
////                        $new_bookingSeat->admin_id = auth('admin')->id();
////                        $new_bookingSeat->active = $old_bookedSeat->active;
////                        $new_bookingSeat->save();
////
////                        $old_bookedSeat->delete()
//
//                        $i++;
//                        DB::commit();
//                    }
//                } catch (\Exception $e){
//                    DB::rollBack();
//                    return redirect()->back()->with('alert-danger','حدث خطأ ما');
//                }
//
//            }
//
//        }
//
//        return redirect()->back()->with('alert-success','تم نقل المقاعد بنجاح');
//    }

} // end of class
