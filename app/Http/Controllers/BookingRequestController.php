<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\EmployeeRunTrip;
use App\Models\Line;
use App\Models\RunTrip;
use App\Models\Station;
use App\Models\TripSeat;
use App\Models\TripStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class BookingRequestController extends Controller
{

    /***  Search For station ***/
    public function searchForStation(Request $request)
    {
        if ($request->has('startDate') && $request->has('endDate'))
        {
            $lines =  DB::table('run_trips')
                ->join('trip_data','run_trips.tripData_id','=','trip_data.id')
                ->join('lines','trip_data.id','=','lines.tripData_id')
                ->whereBetween('run_trips.startDate',[$request->startDate,$request->endDate])
                ->where('run_trips.deleted_at',null)
                ->where('trip_data.deleted_at',null)
                ->where('lines.deleted_at',null)
                ->select('lines.*','lines.id as line_id','trip_data.*','trip_data.id as tripData_id','run_trips.*')->orderBy('from_id')->orderBy('to_id')->orderBy('degree_id')->distinct()->get();


            $groupLines =  DB::table('run_trips')
                ->join('trip_data','run_trips.tripData_id','=','trip_data.id')
                ->join('lines','trip_data.id','=','lines.tripData_id')
                ->whereBetween('run_trips.startDate',[$request->startDate,$request->endDate])
                ->where('run_trips.deleted_at',null)
                ->where('trip_data.deleted_at',null)
                ->where('lines.deleted_at',null)
                ->select('lines.from_id','lines.to_id','lines.degree_id' ,DB::raw('count(*) as total'))->groupBy('lines.from_id','lines.to_id','lines.degree_id')->get();

            $bookedSeats =  DB::table('run_trips')
                ->join('trip_data','run_trips.tripData_id','=','trip_data.id')
                ->join('reservation_booking_requests','reservation_booking_requests.runTrip_id','=','run_trips.id')
                ->join('booking_seats','reservation_booking_requests.id','=','booking_seats.booking_id')
                ->whereBetween('run_trips.startDate',[$request->startDate,$request->endDate])
                ->where('run_trips.deleted_at',null)
                ->where('trip_data.deleted_at',null)
                ->where('lines.deleted_at',null)
                ->select('reservation_booking_requests.stationFrom_id','reservation_booking_requests.stationTo_id','booking_seats.degree_id',DB::raw('count(*) as total'))->groupBy('reservation_booking_requests.stationFrom_id','reservation_booking_requests.stationTo_id','booking_seats.degree_id')->get();


//return $bookedSeats;

            // عشان نضيف عدد الركاب الفعلي لكل خط
           for ($i=0; $i<count($bookedSeats); $i++)
           {
               foreach ($lines as $line)
               {
                   if ($line->from_id == $bookedSeats[$i]->stationFrom_id && $line->to_id == $bookedSeats[$i]->stationTo_id && $line->degree_id == $bookedSeats[$i]->degree_id )
                   {
                        $line->total = $bookedSeats[$i]->total;
                   }
               }
           }



            // عشان نجيب سعر التذكرة لكل خط
           if (!empty($lines))
           {
                foreach ($lines as $line) // seats design
                {
                    $arr_trip_seat_price[] =  TripSeat::where('degree_id',$line->degree_id)->where('tripData_id',$line->tripData_id)->count();
                }
           }
           else{
                $arr_trip_seat_price[] = null;
           }




            // عشان نجيب المسافة التي سوف يتحركها كل خط
//            if (!empty($lines))
//            {
//                foreach ($lines as $line)
//                {
//
//                    $trip_stations[] = TripStation::query()->select('id','rank')->where('tripData_id',$line->tripData_id)
//                        ->whereBetween('station_id',[$line->from_id,$line->to_id])->sum('distance');

//                  $trip_stations[] = TripStation::query()->select('id','rank','distance')->where('tripData_id',$line->tripData_id)
//                        ->get();
//
//                    $station_from = TripStation::query()->where('station_id',$line->stationFrom_id)->where('tripData_id',$line->tripData_id)->pluck('rank');
//                       $station_to = TripStation::query()->where('station_id',$line->stationTo_id)->where('tripData_id',$line->tripData_id)->pluck('rank');
//
//                    return $station_to;
//
//                    $trip_stations[] = TripStation::query()->where('tripData_id',$line->tripData_id)
//                        ->whereBetween('rank',[5,10])->sum('distance');
//
//                return    $trip_stations[] = TripStation::query()->select('id','rank')->where('tripData_id',3)
//                        ->whereBetween('station_id',[4,3])->sum('distance');
//                }
//            }
//            else{
//                $trip_stations = null;
//            }
//
//            return $trip_stations;
//
//
            for ($i=0; $i<count($lines); $i++)
            {
                $lines[$i]->distance = TripStation::query()->where('tripData_id',$lines[$i]->tripData_id)
                    ->whereBetween('station_id',[$lines[$i]->from_id,$lines[$i]->to_id])
                    ->sum('distance');

                if ($lines[$i]->distance == 0)
                {
                    $lines[$i]->distance = TripStation::query()->where('tripData_id',$lines[$i]->tripData_id)
                        ->whereBetween('station_id',[$lines[$i]->to_id,$lines[$i]->from_id])
                        ->sum('distance');
//                    ->orWhereBetween
                }
            }

//            return $lines;

          return view('pages.Reports.searchStations',compact('lines','arr_trip_seat_price','groupLines','bookedSeats'));

        }



        return view('pages.Reports.searchStations');
    }


} //end of class
