<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBackTripsRequest;
use App\Http\Requests\GetGoTripsRequest;
use App\Http\Requests\search_ticket_to_print;
use App\Models\ConnectRunTrips;
use App\Models\Degree;
use App\Models\Line;
use App\Models\ReservationBookingRequest;
use App\Models\RunTrip;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationBookingContinueController extends Controller
{

    /*** search_tickets_instead ***/
    public function search_tickets_instead(Search_ticket_to_print $request)
    {
        if ( $request->has('user_phone') && $request->has('date_of_ticket') && $request->has('secret_code'))
        {
            $find_tickets = ReservationBookingRequest::query()->whereDate('created_at','=',$request->date_of_ticket)
                ->where('secret_code',$request->secret_code)
                ->whereHas('user',function ($q) use ($request){
                    $q->where('mobile',$request->user_phone);
                })->paginate(page);
        }
        elseif ($request->has('user_phone') && $request->has('date_of_ticket'))
        {
            $find_tickets = ReservationBookingRequest::query()->whereDate('created_at','=',$request->date_of_ticket)
                ->whereHas('user',function ($q) use ($request){
                    $q->where('mobile',$request->user_phone);
                })->paginate(page);
        }


     return view('pages.ReservationBookingRequests.print_ticket.choose_ticket_to_print',compact('find_tickets'));
    }



    /*** print_ticket_instead ***/
    public function print_ticket_instead(Request $request)
    {
        $reservationBookingRequest = ReservationBookingRequest::findOrFail($request->ticket_id);
        $company_arabic_name = $this->company_arabic_name;
        $company_english_name = $this->company_english_name;


        return view('pages.ReservationBookingRequests.print_ticket.ticketDesign_print',compact('reservationBookingRequest','company_english_name','company_arabic_name'));
    }



    /*** print_ticket_instead ***/
    public function get_connect_runTrip_page()
    {
        $stations = Station::where('active',1)->select('id','name')->get();
        $degrees = Degree::where('active',1)->select('id','name')->get();

        return view('Pages.ReservationBookingRequests.connect_runTrips.connect_runTrips',compact('stations','degrees'));
    }



    /*** get_go_trips ***/
    public function get_go_trips(GetGoTripsRequest $old_request)
    {
//return $old_request;

        $stations = Station::where('active',1)->select('id','name')->get();
        $degrees = Degree::where('active',1)->select('id','name')->get();

        $stationFrom_request = Station::find($old_request->from_station_go);
        $stationTo_request = Station::find($old_request->to_station_go);


        /* time_go = null && degree_go = null  */
        if ($old_request->has('from_date_go') && $old_request->has('to_date_go') && $old_request->has('from_station_go') && $old_request->has('to_station_go') && $old_request->time_go == null && $old_request->degree_go == null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$old_request->from_date_go,$old_request->to_date_go])
                ->whereHas('tripData',function ($q1) use($old_request)
                {
                    $q1->whereHas('lines',function ($q2) use($old_request){
                        $q2->where('active',1)->where('from_id',$old_request->from_station_go)->where('to_id',$old_request->to_station_go);

                    });
                })->get();
        }


        /* time_go != null && degree_go = null */
        if ($old_request->has('from_date_go') && $old_request->has('to_date_go') && $old_request->has('from_station_go') && $old_request->has('to_station_go') && $old_request->time_go != null && $old_request->degree_go == null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$old_request->from_date_go,$old_request->to_date_go])->where('startTime',$old_request->time_go)
                ->whereHas('tripData',function ($q1) use($old_request)
                {
                    $q1->whereHas('lines',function ($q2) use($old_request){
                        $q2->where('active',1)->where('from_id',$old_request->from_station_go)->where('to_id',$old_request->to_station_go);

                    });
                })->get();
        }


        /* time_go = null && degree_go != null */
        if ($old_request->has('from_date_go') && $old_request->has('to_date_go') && $old_request->has('from_station_go') && $old_request->has('to_station_go') && $old_request->time_go == null && $old_request->degree_go != null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$old_request->from_date_go,$old_request->to_date_go])
                ->whereHas('tripData',function ($q1) use($old_request)
                {
                    $q1->whereHas('lines',function ($q2) use($old_request){
                        $q2->where('active',1)->where('from_id',$old_request->from_station_go)->where('to_id',$old_request->to_station_go);

                    }) ->whereHas('tripDegrees',function ($q3) use($old_request){
                        $q3->where('degree_id',$old_request->degree_go);
                    });
                })->get();
        }


        /* time_go != null && degree_go != null */
        if ($old_request->has('from_date_go') && $old_request->has('to_date_go') && $old_request->has('from_station_go') && $old_request->has('to_station_go') && $old_request->time_go != null && $old_request->degree_go != null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$old_request->from_date_go,$old_request->to_date_go])->where('startTime',$old_request->time_go)
                ->whereHas('tripData',function ($q1) use($old_request)
                {
                    $q1->whereHas('lines',function ($q2) use($old_request){
                        $q2->where('active',1)->where('from_id',$old_request->from_station_go)->where('to_id',$old_request->to_station_go);

                    }) ->whereHas('tripDegrees',function ($q3) use($old_request){
                        $q3->where('degree_id',$old_request->degree_go);
                    });
                })->get();
        }


        return view('Pages.ReservationBookingRequests.connect_runTrips.connect_runTrips',compact('old_request','stations','degrees','runTrips_go','stationFrom_request','stationTo_request'));
    }



    /*** get_back_trips ***/
    public function get_back_trips(GetBackTripsRequest $new_request)
    {

        $stations = Station::where('active',1)->select('id','name')->get();
        $degrees = Degree::where('active',1)->select('id','name')->get();


        /** For old request **/
        $stationFrom_request = Station::find($new_request->from_station_go);
        $stationTo_request = Station::find($new_request->to_station_go);

        /* time_go = null && degree_go = null  */
        if ($new_request->has('from_date_go') && $new_request->has('to_date_go') && $new_request->has('from_station_go') && $new_request->has('to_station_go') && $new_request->time_go == null && $new_request->degree_go == null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_go,$new_request->to_date_go])
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_go)->where('to_id',$new_request->to_station_go);

                    });
                })->get();
        }


        /* time_go != null && degree_go = null */
        if ($new_request->has('from_date_go') && $new_request->has('to_date_go') && $new_request->has('from_station_go') && $new_request->has('to_station_go') && $new_request->time_go != null && $new_request->degree_go == null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_go,$new_request->to_date_go])->where('startTime',$new_request->time_go)
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_go)->where('to_id',$new_request->to_station_go);

                    });
                })->get();
        }


        /* time_go = null && degree_go != null */
        if ($new_request->has('from_date_go') && $new_request->has('to_date_go') && $new_request->has('from_station_go') && $new_request->has('to_station_go') && $new_request->time_go == null && $new_request->degree_go != null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_go,$new_request->to_date_go])
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_go)->where('to_id',$new_request->to_station_go);

                    }) ->whereHas('tripDegrees',function ($q3) use($new_request){
                        $q3->where('degree_id',$new_request->degree_go);
                    });
                })->get();
        }


        /* time_go != null && degree_go != null */
        if ($new_request->has('from_date_go') && $new_request->has('to_date_go') && $new_request->has('from_station_go') && $new_request->has('to_station_go') && $new_request->time_go != null && $new_request->degree_go != null)
        {
            $runTrips_go = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_go,$new_request->to_date_go])->where('startTime',$new_request->time_go)
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_go)->where('to_id',$new_request->to_station_go);

                    }) ->whereHas('tripDegrees',function ($q3) use($new_request){
                        $q3->where('degree_id',$new_request->degree_go);
                    });
                })->get();
        }
        /** For old request **/




        /** For new request **/
        $stationFrom_back_request = Station::find($new_request->from_station_back);
        $stationTo_back_request = Station::find($new_request->to_station_back);

        /* time_back = null && degree_back = null  */
        if ($new_request->has('from_date_back') && $new_request->has('to_date_back') && $new_request->has('from_station_back') && $new_request->has('to_station_back') && $new_request->time_back == null && $new_request->degree_back == null)
        {
            $runTrips_back = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_back,$new_request->to_date_back])
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_back)->where('to_id',$new_request->to_station_back);

                    });
                })->get();
        }


        /* time_back != null && degree_back = null */
        if ($new_request->has('from_date_back') && $new_request->has('to_date_back') && $new_request->has('from_station_back') && $new_request->has('to_station_back') && $new_request->time_back != null && $new_request->degree_back == null)
        {
            $runTrips_back = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_back,$new_request->to_date_back])->where('startTime',$new_request->time_back)
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_back)->where('to_id',$new_request->to_station_back);

                    });
                })->get();
        }


        /* time_back = null && degree_back != null */
        if ($new_request->has('from_date_back') && $new_request->has('to_date_back') && $new_request->has('from_station_back') && $new_request->has('to_station_back') && $new_request->time_back == null && $new_request->degree_back != null)
        {
            $runTrips_back = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_back,$new_request->to_date_back])
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_back)->where('to_id',$new_request->to_station_back);

                    }) ->whereHas('tripDegrees',function ($q3) use($new_request){
                        $q3->where('degree_id',$new_request->degree_back);
                    });
                })->get();
        }


        /* time_back != null && degree_back != null */
        if ($new_request->has('from_date_back') && $new_request->has('to_date_back') && $new_request->has('from_station_back') && $new_request->has('to_station_back') && $new_request->time_back != null && $new_request->degree_back != null)
        {
            $runTrips_back = RunTrip::where('active',1)->where('canceled','!=',1)->whereBetween('startDate',[$new_request->from_date_back,$new_request->to_date_back])->where('startTime',$new_request->time_back)
                ->whereHas('tripData',function ($q1) use($new_request)
                {
                    $q1->whereHas('lines',function ($q2) use($new_request){
                        $q2->where('active',1)->where('from_id',$new_request->from_station_back)->where('to_id',$new_request->to_station_back);

                    }) ->whereHas('tripDegrees',function ($q3) use($new_request){
                        $q3->where('degree_id',$new_request->degree_back);
                    });
                })->get();
        }
        /** For new request **/


        return view('Pages.ReservationBookingRequests.connect_runTrips.connect_runTrips',compact('new_request','stations','degrees','runTrips_go','runTrips_back','stationFrom_request','stationTo_request','stationFrom_back_request','stationTo_back_request'));
    }



    /*** connect_runTrip ***/
    public function connect_runTrip(Request $request)
    {
        if (!$request->has('runTrip_go'))
        {
            return redirect()->back()->with('alert-danger','برجاء اختيار رحلة الذهاب');
        }
        if (!$request->has('runTrips_back'))
        {
            return redirect()->back()->with('alert-danger','برجاء اختيار رحلات العودة');
        }


        foreach ($request->runTrips_back as $runTrip_back)
        {
            $connectRunTrip = ConnectRunTrips::where('runTrip_go_id',$request->runTrip_go)->where('runTrip_back_id',$runTrip_back)->first();

            if (!$connectRunTrip)
            {
                $connectRunTrips = new ConnectRunTrips();
                $connectRunTrips->runTrip_go_id = $request->runTrip_go;
                $connectRunTrips->runTrip_back_id = $runTrip_back;
                $connectRunTrips->admin_id = Auth::id();
                $connectRunTrips->save();
            }
        }


        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }


} //end of class
