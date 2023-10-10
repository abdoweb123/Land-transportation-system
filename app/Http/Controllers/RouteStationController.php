<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\Bus;
use App\Models\ExcelEmployee;
use App\Models\MyEmployee;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RouteStationController extends Controller
{

    public function operation1()
    {                                               // انطلاق   خط    وصول
       $excelEmployeesData = ExcelEmployee::select('id','name', 'lob', 'oracle', 'site', 'route', 'cp',
                                                   'gender', 'date', 'shift', 'start', 'end')->get();


       foreach ($excelEmployeesData as $excelEmployeesDatum)
        {


            DB::beginTransaction();
            try {

                // create or update route
                $getRoute = Route::where('name',$excelEmployeesDatum->route)->first();

                if (!$getRoute)
                {
                    $route = new Route();
                    $route->name = $excelEmployeesDatum->route;
                    $route->admin_id = auth('admin')->id();
                    $route->active = 1;
                    $route->save();
                }
                else{
                    $route = Route::where('name',$excelEmployeesDatum->route)->first();
                }



                // create or update route_stations by site
                $getRoute_station_site = RouteStation::where('route_id',$route->id)->where('station_name',$excelEmployeesDatum->site)->first();

                if (!$getRoute_station_site)
                {
                    $route_station_site = new RouteStation();
                    $route_station_site->route_id = $route->id;
                    $route_station_site->station_name = $excelEmployeesDatum->site;
                    $route_station_site->admin_id = auth('admin')->id();
                    $route_station_site->active = 1;
                    $route_station_site->save();
                }
                else{
                    $route_station_site = RouteStation::where('route_id',$route->id)->where('station_name',$excelEmployeesDatum->site)->first();
                }





                // create or update route_stations by cp
                $getRoute_station_cp = RouteStation::where('route_id',$route->id)->where('station_name',$excelEmployeesDatum->cp)->first();

                if (!$getRoute_station_cp)
                {
                    $route_station_cp = new RouteStation();
                    $route_station_cp->route_id = $route->id;
                    $route_station_cp->station_name = $excelEmployeesDatum->cp;
                    $route_station_cp->admin_id = auth('admin')->id();
                    $route_station_cp->active = 1;
                    $route_station_cp->save();
                }
                else{
                    $route_station_cp = RouteStation::where('route_id',$route->id)->where('station_name',$excelEmployeesDatum->cp)->first();
                }



                // create or update stations by site
                $station_site = Station::where('name->ar','=',$route_station_site->station_name)->orWhere('name->en','=',$route_station_site->station_name)->first();

                if (!$station_site)
                {
                    $station_site = new Station();
                    $station_site->name = ['en' => $route_station_site->station_name, 'ar' => $route_station_site->station_name];
                    $station_site->admin_id = auth('admin')->id();
                    $station_site->save();

                    $route_station_site->station_id = $station_site->id;
                    $route_station_site->update();
                }
                else{
                    $route_station_site->station_id = $station_site->id;
                    $route_station_site->update();
                }




                // create or update stations by cp
                $station_cp = Station::where('name->ar','=',$route_station_cp->station_name)->orWhere('name->en','=',$route_station_cp->station_name)->first();

                if (!$station_cp)
                {
                    $station_cp = new Station();
                    $station_cp->name = ['en' => $route_station_cp->station_name, 'ar' => $route_station_cp->station_name];
                    $station_cp->admin_id = auth('admin')->id();
                    $station_cp->save();
                }


                $route_station_cp->station_id = $station_cp->id;
                $route_station_cp->update();



                // Determine male or female
                if (Str::lower($excelEmployeesDatum->gender) == 'male')
                    $excelEmployeesDatum->gender = 1;
                else
                    $excelEmployeesDatum->gender = 2;



                // create or update employee and request
                $getEmployee = MyEmployee::where('oracle_id',$excelEmployeesDatum->oracle)->first();

                if (!$getEmployee)
                {
                    $getEmployee = new MyEmployee();
                    $getEmployee->name = $excelEmployeesDatum->name;
                    $getEmployee->oracle_id = $excelEmployeesDatum->oracle;
                    $getEmployee->collectionPoint_id = $station_cp->id;
                    $getEmployee->gender = $excelEmployeesDatum->gender;
                    $getEmployee->admin_id = auth('admin')->id();
                    $getEmployee->active = 1;
                    $getEmployee->save();
                }

                // create booking request AM
                $bookingRequest = new BookingRequest();
                $bookingRequest->collection_point_from_id = $station_cp->id;
                $bookingRequest->collection_point_to_id = $station_site->id;
                $bookingRequest->route_id = $route->id;
                $bookingRequest->date = date('Y-m-d',strtotime($excelEmployeesDatum->date));
                $bookingRequest->time = $excelEmployeesDatum->start;
                $bookingRequest->employee_id = $getEmployee->id;
                $bookingRequest->shift = $excelEmployeesDatum->shift;
                if ($getEmployee->gender == 2 && $excelEmployeesDatum->start == '21:00:00') {
                    $bookingRequest->address = $getEmployee->address;
                }else{
                    $bookingRequest->address = null;
                }
                $bookingRequest->admin_id = auth('admin')->id();
                $bookingRequest->active = 1;
                $bookingRequest->save();


                // create booking request PM
                $bookingRequest = new BookingRequest();
                $bookingRequest->collection_point_from_id = $station_site->id;
                $bookingRequest->collection_point_to_id = $station_cp->id;
                $bookingRequest->route_id = $route->id;
                $bookingRequest->date = date('Y-m-d',strtotime($excelEmployeesDatum->date));
                $bookingRequest->time = $excelEmployeesDatum->end;
                $bookingRequest->employee_id = $getEmployee->id;
                $bookingRequest->shift = $excelEmployeesDatum->shift;
                if ($getEmployee->gender == 2 && $excelEmployeesDatum->end == '21:00:00') {
                    if ($getEmployee->address != null) {
                        $bookingRequest->address = $getEmployee->address;
                    }else{
                        $bookingRequest->address ='D2D';
                    }
                }else{
                    $bookingRequest->address = null;
                }
                $bookingRequest->admin_id = auth('admin')->id();
                $bookingRequest->active = 1;
                $bookingRequest->save();


                ExcelEmployee::query()->find($excelEmployeesDatum->id)->forceDelete();

                DB::commit();
            }
            catch (\Exception $exception){
                DB::rollBack();
            }

        } // end of foreach

       return redirect()->route('add_bus.to.booking_request')->with('alert-success','تم تحديث البيانات بنجاح');

    }






    public function operation2()
    {
       return  $booking_requests = BookingRequest::select('date','time','route_id' ,DB::raw('count(*) as total'))->groupBy('date','time','route_id')->get('date','time','route_id');

         $bookingRequest_bus_id = BookingRequest::select('id','bus_id')->get();


//        foreach ($booking_requests as $booking_request)  // العدد 110
//        {
//           echo $booking_request->id;
//        }


        //         $getBooking_requests = str_replace(array('[',']'), '',$booking_requests);


//        return    $buses = Bus::select('id','busType_id')->with('busType')->get();


        $buses =   DB::table('buses')->join('bus_types','buses.busType_id','=','bus_types.id')->select('buses.id','bus_types.slug')->get();



//          foreach ($buses as $bus)
//          {
//              $slugs[] = [$bus->slug,$bus->id];
//          }
//
//
//          sort($slugs);
//          return $slugs;

//          foreach ($slugs as $slug)
//          {
//              unset($slugs[0]);
//          }
//        return $slugs;



//        for ($i=0; $i< count($booking_requests); $i++)  // اعمل loop بعدد ال totals اللي عندك  (110)
//        {
//            if ($booking_requests->total <= $slugs[$i][0])
//            {
//                $findBooking_requests = BookingRequest::where('date',$booking_requests->date)->get();
//                $x = 1;
//                foreach ($findBooking_requests as $findBooking_request)
//                {
//                    $findBooking_request->update([
//                        'bus_id'=>$slugs[$i][1],
//                        'seat_number'=>$x,
//                    ]);
//                    $x++;
//                }
//
//                break;
//            }
//
//        }




        foreach ($booking_requests as $booking_request)  // العدد 110
        {

            foreach ($buses as $bus)  // 20  20  20  150  150  300  300 (7)
            {
                $s=0;

                $un_usedBuses = Bus::query()->whereDoesntHave('bookingRequest')->get();

                foreach ($un_usedBuses as $un_usedBus)
                {

                        if ($booking_request->total <= $bus->slug) // 2,20
                        {

                            if ($un_usedBus->id == $bus->id)
                            {
                            $findBooking_requests = BookingRequest::where('date',$booking_request->date)->where('time',$booking_request->time)->where('route_id',$booking_request->route_id)->get();
                            $x = 1;
                            foreach ($findBooking_requests as $findBooking_request)
                            {
                                $findBooking_request->update([
                                    'bus_id'=>$bus->id,
                                    'seat_number'=>$x,
                                ]);

                                $x++;

                            }
                            break;

                        }
                    }
                }


            }



        }



//          foreach ($booking_requests as $booking_request)  // العدد 110
//          {
//
//              for ($i=0; $i<count($slugs); $i++)  // 20  20  20  150  150  300  300 (7)
//              {
//                  $s=0;
//
//                  $usedBus = Bus::where('id','!=',$bookingRequest_bus_id);
//
//                  if ($booking_request->total <= $slugs[$s][$s]) // 2,20
//                  {
//                     $findBooking_requests = BookingRequest::where('date',$booking_request->date)->where('time',$booking_request->time)->where('route_id',$booking_request->route_id)->get();
//                     $x = 1;
//                     foreach ($findBooking_requests as $findBooking_request)
//                     {
//                         $findBooking_request->update([
//                             'bus_id'=>$slugs[$s][1],
//                             'seat_number'=>$x,
//                         ]);
//                         $x++;
//
//                     }
//                      unset($slugs[$i][$s]);
//                      break;
//
//                  }
//
//
//              }
//
//
//
//          }
          return 'success';

    }



} //end of class
