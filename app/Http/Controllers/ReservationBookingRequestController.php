<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calc_bookingRequest;
use App\Http\Requests\EditBookingRequest;
use App\Http\Requests\PrintTablohRequest;
use App\Http\Requests\SaveDataRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Admin;
use App\Models\BookedPackage;
use App\Models\BookingSeat;
use App\Models\Bus;
use App\Models\BusType;
use App\Models\ConnectRunTrips;
use App\Models\Coupon;
use App\Models\CouponTrip;
use App\Models\Degree;
use App\Models\Driver;
use App\Models\Les;
use App\Models\Line;
use App\Models\Office;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodTrip;
use App\Models\ReservationBookingRequest;
use App\Models\RunTrip;
use App\Models\Shipping;
use App\Models\Station;
use App\Models\TripData;
use App\Models\TripSeat;
use App\Models\TripStation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Whoops\Run;
use function PHPUnit\Framework\isEmpty;

class ReservationBookingRequestController extends Controller
{

    /*** search Lines ***/
    public function searchLines(Request $request)
    {

        $stations = Station::where('active',1)->select('id','name')->get();
        $offices = Office::where('active',1)->select('id','name')->get();
        $degrees = Degree::where('active',1)->select('id','name')->get();


        // for create new booking
        if ($request->has('from_date') && $request->has('to_date')) {

            // show all trips with all filters   ||   show only unActive and canceled_trips
            if (($request->has('show_unActive_trips') && $request->has('show_canceled_trips') && $request->has('show_completed_tripSeats')) || $request->has('show_unActive_trips') && $request->has('show_canceled_trips'))
            {
                $dataAll = RunTrip::where('active',1)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }
            // show unActive and completed_tripSeats
            elseif($request->has('show_unActive_trips') && $request->has('show_completed_tripSeats'))
            {
                $dataAll = RunTrip::where('active',1)->where('canceled',2)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }
            // show canceled and completed_tripSeats
            elseif($request->has('show_canceled_trips') && $request->has('show_completed_tripSeats'))
            {
                $dataAll = RunTrip::where('active',1)->where('active',1)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }
            // show unActive trips
            elseif($request->has('show_unActive_trips'))
            {
                $dataAll = RunTrip::where('active',1)->where('canceled',2)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }
            // show canceled trips
            elseif($request->has('show_canceled_trips'))
            {
                $dataAll = RunTrip::where('active',1)->where('active',1)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }
            // show all trips without filters
            else{
//               return $request;
                $dataAll = RunTrip::where('active',1)->where('active',1)->where('canceled',2)->whereBetween('startDate',[$request->from_date,$request->to_date])
                    ->whereHas('tripData',function ($q1) use($request)
                    {
                        $q1->whereHas('lines',function ($q2) use($request){

                            $q2->where('active',1)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                        });
                    })->paginate(page);
            }



            $stationFrom_id = Station::where('id',$request->stationFrom_id)->select('id','name')->first();
            $stationTo_id = Station::where('id',$request->stationTo_id)->select('id','name')->first();

            return view('pages.ReservationBookingRequests.searchLines',compact('dataAll','stations', 'offices','request','stationFrom_id','stationTo_id','degrees'));

        }

        // for edit new booking
        if ($request->has('edit_date')) {

            $dataAll = RunTrip::where('active',1)->where('canceled',2)->where('startDate',$request->edit_date)
                ->whereHas('tripData',function ($q1) use($request)
                {
                    $q1->whereHas('lines',function ($q2) use($request){

                        $q2->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id);
                    });
                })->paginate(page);


            $stationFrom_id = Station::where('id',$request->stationFrom_id)->select('id','name')->first();
            $stationTo_id = Station::where('id',$request->stationTo_id)->select('id','name')->first();
            $reservationBookingRequest = ReservationBookingRequest::find($request->reservationBookingRequest_id);

            return view('pages.ReservationBookingRequests.editPage',compact('dataAll','stations','request','stationFrom_id','stationTo_id','reservationBookingRequest'));
        }




        return view('pages.ReservationBookingRequests.searchLines',compact('stations', 'offices', 'degrees','request'));
    }



    /*** bookingPage ***/
    public function bookingPage(Request $request)
    {
        $tripData = TripData::findOrFail($request->tripData_id);
        $runTrip = RunTrip::findOrFail($request->runTrip_id);
        $tripDegrees = $tripData->tripDegrees;
        $tripSeats = TripSeat::where('tripData_id',$request->tripData_id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        $old_request = $request;
        $reservationBookings = ReservationBookingRequest::where('runTrip_id',$runTrip->id)->get();

        // for printing tabloh
        $drivers = Driver::where('active',1)->select('id','name')->get();
        $buses = Bus::where('active',1)->select('id','code')->get();
        $hosts = Admin::where('active',1)->where('type',3)->select('id','name')->get();

        $shippings = DB::table('shippings')
            ->join('run_trips','run_trips.id','=','shippings.run_trip_id')
            ->join('trip_data','trip_data.id','=','run_trips.tripData_id')
            ->where('shippings.active',1)
            ->where('run_trips.active',1)
            ->where('trip_data.active',1)
            ->where('shippings.deleted_at','=',null)
            ->where('trip_data.id',$tripData->id)->where('run_trip_id',$request->runTrip_id)->select('shippings.*','shippings.id as shipping_id')->get();

        return view('pages.ReservationBookingRequests.bookingPage',compact('old_request','tripSeats','tripDegrees','tripData','busType','shippings','reservationBookings','drivers','buses','hosts'));
    }



    /*** searchUserPhone function ***/
    public function searchUserPhone(Request $newRequest)
    {
//        return $newRequest;

        $runTrip = RunTrip::findOrFail($newRequest->runTrip_id);
        $related_runTrips = ConnectRunTrips::where('runTrip_go_id',$newRequest->runTrip_id)->get();
        $tripData = TripData::findOrFail($newRequest->tripData_id);
        $tripDegrees = $tripData->tripDegrees;
        $linesOfTrip = Line::where('tripData_id',$newRequest->tripData_id)->where('from_id',$newRequest->stationFrom_id)->where('to_id',$newRequest->stationTo_id)->get();
        $tripSeats = TripSeat::where('tripData_id',$newRequest->tripData_id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        $user = User::where('active',1)->where('mobile',$newRequest->searchUserPhone)->select('id','name','wallet')->first();
        $stationFrom = Station::find($newRequest->stationFrom_id);
        $stationTo = Station::find($newRequest->stationTo_id);
        $paymentMethodsTrip = PaymentMethodTrip::where('tripData_id',$newRequest->tripData_id)->get();


        if ($user)
        {
            $booked_package = BookedPackage::where('user_id',$user->id)->where('active',1)
                ->whereHas('package',function ($q1) use($newRequest,$runTrip) {
                    $q1->where('stationFrom_id','=',$newRequest->stationFrom_id)->where('stationTo_id','=',$newRequest->stationTo_id)->where('type',$runTrip->type);
                })->first();

            if ($booked_package)
            {
                /* عشان الوقت بتاعه ميكنشي فات */
                $time_of_now = Carbon::now();
                $booked_package_limitation = Carbon::createFromFormat('Y-m-d',$booked_package->startDate)->addDays($booked_package->package->max_duration);
                if ($time_of_now > $booked_package_limitation)
                {
                    $booked_package = null;
                }
            }

        }
       else{
           $booked_package = null;
       }

        $coupons = DB::table('coupon_trips')
            ->join('coupons','coupon_trips.coupon_id','coupons.id')
            ->where('coupon_trips.tripData_id',$newRequest->tripData_id)
            ->where('coupons.endDate','>=',Carbon::today())
            ->where('coupons.active',1)
            ->where('coupon_trips.active',1)
            ->where('coupons.deleted_at','=',null)
            ->where('coupon_trips.deleted_at','=',null)
            ->select('coupons.id','coupons.code','coupons.endDate','coupons.startDate')->get();


// return count($related_runTrips);
        return view('pages.ReservationBookingRequests.searchPhoneUser',compact('user','newRequest','tripDegrees','tripData','tripSeats','busType','coupons','linesOfTrip','runTrip','paymentMethodsTrip','booked_package','stationFrom','stationTo','related_runTrips'));
    }



    /*** create new client function ***/
    public function createNewUser(UserStoreRequest $newRequest)
    {

        $newUser = new User();
        $newUser->name = $newRequest['name'];
        $newUser->email = $newRequest['email'];
        $newUser->mobile = $newRequest['mobile'];
        $newUser->nationalId = $newRequest['nationalId'];
        $newUser->admin_id = auth('admin')->id();
        $newUser->password = Hash::make($newRequest['password']);
        $newUser->save();

        $runTrip = RunTrip::findOrFail($newRequest->runTrip_id);
        $tripData = TripData::findOrFail($newRequest->tripData_id);
        $tripDegrees = $tripData->tripDegrees;
        $linesOfTrip = Line::where('tripData_id',$newRequest->tripData_id)->where('from_id',$newRequest->stationFrom_id)->where('to_id',$newRequest->stationTo_id)->get();
        $tripSeats = TripSeat::where('tripData_id',$newRequest->tripData_id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        $coupons = DB::table('coupon_trips')
            ->join('coupons','coupon_trips.coupon_id','coupons.id')
            ->where('coupon_trips.tripData_id',$newRequest->tripData_id)
            ->where('coupons.active',1)
            ->where('coupon_trips.active',1)
            ->where('coupons.deleted_at','=',null)
            ->where('coupon_trips.deleted_at','=',null)
            ->select('coupons.id','coupons.code')->get();

        $paymentMethodsTrip = PaymentMethodTrip::where('tripData_id',$newRequest->tripData_id)->get();

        return view('pages.ReservationBookingRequests.searchPhoneUser',compact('newUser','newRequest','tripData','tripDegrees','tripSeats','busType','coupons','linesOfTrip','runTrip','paymentMethodsTrip'));
    }



    /*** calculate Booking Request ***/
    public function calc_booking(Calc_bookingRequest $request)
    {
//        return $request;

        if (!$request->has('use_package'))
        {
            if (!$request->has('payment_method'))
            {
                return redirect()->back()->with('alert-danger','وسيلة الدفع مطلوبة');
            }
        }



        if ($request->trip_type == 1)  // GO
        {
            if ($request->passenger_type == 1) // egyptian ==>  priceGo
            {
                for ($i=0; $i<count($request->seatId); $i++)
                {
                    $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                    $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                    $arr[] = "$getPriceGoOfDegree";
                    $degrees[] = $getPriceGoOfDegree;
                }

                $newArr = array_count_values($arr);

                foreach ($newArr as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiply[] = $multiply;
                }

                $total = array_sum($arrMultiply);

                $wallet = 0;


            }

            else{ // foreign ==>  priceForeignerGo

                for ($i=0; $i<count($request->seatId); $i++)
                {
                    $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                    $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                    $arr[] = "$getPriceForeignerGoOfDegree";
                    $degrees[] = $getPriceForeignerGoOfDegree;
                }

                $newArr = array_count_values($arr);

                foreach ($newArr as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiply[] = $multiply;
                }

                $total = array_sum($arrMultiply);

                $wallet = 0;
            }
        }
        else{   // BACK

            if ($request->passenger_type == 1) // egyptian ==>  priceBack
            {
                for ($i=0; $i<count($request->seatId); $i++)
                {
                    $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                    $getPriceBackOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceBack;
                    $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                    $arrPriceBack[] = "$getPriceBackOfDegree";
                    $arrPriceGo[] = "$getPriceGoOfDegree";
                    $degrees[] = $getPriceBackOfDegree;
                }

                $newArrPriceBack = array_count_values($arrPriceBack);
                foreach ($newArrPriceBack as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiplyPriceBack[] = $multiply;
                }
                $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                $newArrPriceGo = array_count_values($arrPriceGo);
                foreach ($newArrPriceGo as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiplyPriceGo[] = $multiply;
                }
                $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                $total = $totalPriceBack;
                $totalGo = $totalPriceGo;

                $wallet = $total - $totalGo;  // wallet


            }
            else{ // foreign ==>  priceForeignerBack

                for ($i=0; $i<count($request->seatId); $i++)
                {
                    $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                    $getPriceForeignerBackOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerBack;
                    $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                    $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                    $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                    $degrees[] = $getPriceForeignerBackOfDegree;
                }


                $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
                foreach ($newArrPriceForeignerBack as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiplyPriceForeignerBack[] = $multiply;
                }
                $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



                $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
                foreach ($newArrPriceForeignerGo as $key=>$value)
                {
                    $multiply = $key * $value;

                    $arrMultiplyPriceForeignerGo[] = $multiply;
                }
                $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


                $total = $totalPriceForeignerBack;
                $totalGo = $totalPriceForeignerGo;

                $wallet = $total - $totalGo;  // wallet

            }

        }


        if (!$request->coupon_id) // no coupon
        {
            $total_discount_booking = 0; // no coupons
            $sub_total_booking = $total; // no coupons

            for ($i=0; $i<count($request->seatId); $i++)
            {
                $sub_total_seat[] = $degrees[$i];
            }
        }
        else
        {
            $coupon = Coupon::where('id',$request->coupon_id)->first();
            if ($coupon->used_by > 0 ){

                if($coupon->percent == 1) // pound
                {
                    $total_discount_booking =  $coupon->amount * count($request->seatId);

                    if ($total <= $total_discount_booking)
                    {
                        $total_discount_booking = $total;
                    }

                    $sub_total_booking = $total - $total_discount_booking;

                    for ($i=0; $i<count($request->seatId); $i++)
                    {
                        $sub_total_seat[] = $degrees[$i] - $coupon->amount;
                    }


                }
                else{  // percentage %

                    for ($i=0; $i<count($request->seatId); $i++)
                    {
                        $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

                        $discount_seat = ($coupon->amount / 100) * $degrees[$i];

                        if ($discount_seat < $coupon->max_amount)
                        {
                            $getSumDegrees[] = $discount_seat;
                        }
                        else{
                            $getSumDegrees[] = $coupon->max_amount;
                        }

                        $sub_total_seat[] = $degrees[$i] - $getSumDegrees[$i];
                    }


                    $total_discount_booking = array_sum($getSumDegrees);
                    $sub_total_booking = $total - $total_discount_booking;
                }

            }
        }

//        return $total;
//        return $total_discount_booking;
//        return $sub_total_booking;

        $tripData = TripData::findOrFail($request->tripData_id);
        $newTripSeats = $request->seatId;
        $tripDegrees = $tripData->tripDegrees;
        $linesOfTrip = Line::where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->get();
        $tripSeats = TripSeat::where('tripData_id',$request->tripData_id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        $user = User::findOrFail($request->user_id);
        $coupon = Coupon::find($request->coupon_id);

        if ($request->has('use_package'))
        {
            $total = 0;
            $sub_total_booking = 0;
        }

        return view('pages.ReservationBookingRequests.calc_searchPhoneUser',compact('request','tripData','tripDegrees','tripSeats','busType','coupon','linesOfTrip','total','total_discount_booking','sub_total_booking','user','newTripSeats'));

    }



    /*** Make Booking Request ***/
    public function saveData(SaveDataRequest $request)
    {
//       return $request;

        $user = User::find($request->user_id);
        if (!$request->seatId){
          return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }

        if (!$request->user_id){
          return redirect()->back()->with('alert-danger','برجاء اختيار مستخدم');
        }


        if ($request->trip_type == 1)  // GO
        {
          if ($request->passenger_type == 1) // egyptian ==>  priceGo
          {
              for ($i=0; $i<count($request->seatId); $i++)
              {
                  $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                  $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                  $arr[] = "$getPriceGoOfDegree";
                  $degrees[] = $getPriceGoOfDegree;
              }

              $newArr = array_count_values($arr);

              foreach ($newArr as $key=>$value)
              {
                  $multiply = $key * $value;

                  $arrMultiply[] = $multiply;
              }

              $total = array_sum($arrMultiply);

              $wallet = 0;


          }

          else{ // foreign ==>  priceForeignerGo

              for ($i=0; $i<count($request->seatId); $i++)
              {
                  $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                  $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                  $arr[] = "$getPriceForeignerGoOfDegree";
                  $degrees[] = $getPriceForeignerGoOfDegree;
              }

              $newArr = array_count_values($arr);

              foreach ($newArr as $key=>$value)
              {
                  $multiply = $key * $value;

                  $arrMultiply[] = $multiply;
              }

              $total = array_sum($arrMultiply);

              $wallet = 0;
          }
        }
        else{   // BACK

          if ($request->passenger_type == 1) // egyptian ==>  priceBack
          {
              for ($i=0; $i<count($request->seatId); $i++)
              {
                  $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                  $getPriceBackOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceBack;
                  $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                  $arrPriceBack[] = "$getPriceBackOfDegree";
                  $arrPriceGo[] = "$getPriceGoOfDegree";
                  $degrees[] = $getPriceBackOfDegree;
              }

                 $newArrPriceBack = array_count_values($arrPriceBack);
                 foreach ($newArrPriceBack as $key=>$value)
                 {
                    $multiply = $key * $value;

                    $arrMultiplyPriceBack[] = $multiply;
                 }
                 $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                 $newArrPriceGo = array_count_values($arrPriceGo);
                 foreach ($newArrPriceGo as $key=>$value)
                 {
                    $multiply = $key * $value;

                    $arrMultiplyPriceGo[] = $multiply;
                 }
                 $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                   $total = $totalPriceBack;
                   $totalGo = $totalPriceGo;

                  $wallet = $total - $totalGo;  // wallet


          }
          else{ // foreign ==>  priceForeignerBack

              for ($i=0; $i<count($request->seatId); $i++)
              {
                  $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                  $getPriceForeignerBackOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerBack;
                  $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                  $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                  $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                  $degrees[] = $getPriceForeignerBackOfDegree;
              }


              $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
              foreach ($newArrPriceForeignerBack as $key=>$value)
              {
                  $multiply = $key * $value;

                  $arrMultiplyPriceForeignerBack[] = $multiply;
              }
              $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



              $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
              foreach ($newArrPriceForeignerGo as $key=>$value)
              {
                  $multiply = $key * $value;

                  $arrMultiplyPriceForeignerGo[] = $multiply;
              }
              $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


              $total = $totalPriceForeignerBack;
              $totalGo = $totalPriceForeignerGo;

              $wallet = $total - $totalGo;  // wallet

          }

        }


        if (!$request->coupon_id) // no coupon
        {
            $total_discount_booking = 0; // no coupons
            $sub_total_booking = $total; // no coupons

            for ($i=0; $i<count($request->seatId); $i++)
            {
                $sub_total_seat[] = $degrees[$i];
            }
        }
        else
         {
             $coupon = Coupon::where('id',$request->coupon_id)->first();
             if ($coupon->used_by > 0 ){

                 if($coupon->percent == 1) // pound
                 {
                     $total_discount_booking =  $coupon->amount * count($request->seatId);

                     if ($total <= $total_discount_booking)
                     {
                         $total_discount_booking = $total;
                     }

                     $sub_total_booking = $total - $total_discount_booking;

                     for ($i=0; $i<count($request->seatId); $i++)
                     {
                         $sub_total_seat[] = $degrees[$i] - $coupon->amount;
                     }


                 }
                 else{  // percentage %

                     for ($i=0; $i<count($request->seatId); $i++)
                     {
                         $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

                         $discount_seat = ($coupon->amount / 100) * $degrees[$i];

                         if ($discount_seat < $coupon->max_amount)
                         {
                             $getSumDegrees[] = $discount_seat;
                         }
                         else{
                             $getSumDegrees[] = $coupon->max_amount;
                         }

                         $sub_total_seat[] = $degrees[$i] - $getSumDegrees[$i];
                     }


                     $total_discount_booking = array_sum($getSumDegrees);
                     $sub_total_booking = $total - $total_discount_booking;
                 }

                 $coupon->used_by = $coupon->used_by - 1;
                 $coupon->used_count = $coupon->used_count + 1;
                 $coupon->update();
             }
         }




        $reservationBookingRequest = new ReservationBookingRequest();
        $reservationBookingRequest->runTrip_id = $request['runTrip_id'];
        $reservationBookingRequest->trip_id = $request['tripData_id'];
        $reservationBookingRequest->user_id = $request['user_id'];
        $reservationBookingRequest->stationFrom_id = $request['stationFrom_id'];
        $reservationBookingRequest->stationTo_id = $request['stationTo_id'];
        $reservationBookingRequest->coupon_id = $request['coupon_id'];
        $reservationBookingRequest->address = $request['address'];
        /* عشان لو كان في اشتراك موجود */
        if ($request->has('use_package'))
        {
            $reservationBookingRequest->total = 0;
        }
        else{
            $reservationBookingRequest->total = $total;
        }

        $reservationBookingRequest->discount = $total_discount_booking;

        /* عشان لو بيحجز للغير هيبقى في secret_code */
        if (isset($request->book_for_other))
        {
            $reservationBookingRequest->secret_code = random_int(100000,999999);
        }

        /*  go and back */
        if ($request->trip_type == 2)
        {
            if ($request->has('use_package'))
            {
                $reservationBookingRequest->sub_total = 0;
            }
            else{
                $old_ticket_subTotal = $sub_total_booking / 2;
                $reservationBookingRequest->sub_total = $old_ticket_subTotal;
            }

        }
        else{
            if ($request->has('use_package'))
            {
                $reservationBookingRequest->sub_total = 0;
            }
            else{
                $reservationBookingRequest->sub_total = $sub_total_booking / 2;
            }
        }

        $reservationBookingRequest->wallet = $wallet;
        $reservationBookingRequest->type = $request['trip_type'];
        $reservationBookingRequest->passenger_type = $request['passenger_type'];
        $reservationBookingRequest->admin_id = auth('admin')->id();
        $reservationBookingRequest->office_id = auth('admin')->user()->office_id;
        $reservationBookingRequest->active = 1;
        $reservationBookingRequest->save();



        /* عشان ال trip_station من خلال ال ( request['stationFrom_id'] && $request['stationTo_id']$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationFrom_id'])->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationTo_id'])->first()->id;


        for ($i=0; $i<count($request->seatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $reservationBookingRequest->id;
            $bookingSeats->runTrip_id = $request['runTrip_id'];
            $bookingSeats->seat_id = $request->seatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $sub_total_seat[$i];
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }


        /* عشان ميعملش trigger لو كان في اشتراك موجود */
        if (!$request->has('use_package'))
        {
            // create trigger
            $les = new Les();
            $les->type = 1;
            $les->ticket_id = $reservationBookingRequest->id;

            if ($request->payment_method == 1) //cash
            {
                $les->amount = $sub_total_booking;
                $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $sub_total_booking . ' جنيها ';
            }
            else{ // wallet
                if ($user->wallet > $sub_total_booking)
                {
                    $user->wallet = $user->wallet - $request->paid_from_wallet;
                    $user->update();

                    $les->amount = 0;
                    $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $request->paid_from_wallet . ' جنيها '. 'من محفظته';
                }
                elseif($user->wallet == $sub_total_booking)
                {
                    $user->wallet = $user->wallet - $sub_total_booking;
                    $user->update();

                    $les->amount = 0;
                    $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $request->paid_from_wallet . ' جنيها '. 'من محفظته';
                }
                elseif($user->wallet < $sub_total_booking)
                {
                    $user->wallet = 0;
                    $user->update();

                    $les->amount = $request->paid_cash;
                    $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $request->paid_from_wallet . ' جنيها '. ' من محفظته ' . ' وقام بدفع '. $request->paid_cash . ' نقديا ';
                }
            }

            $les->admin_id = auth('admin')->id();
            $les->office_id = auth('admin')->user()->office_id;
            $les->active = 1;
            $les->save();
        }
        else  // update booked_package
        {
            // update booked_package
            $booked_package = BookedPackage::find($request->use_package);
            $booked_package->used =  $booked_package->used + 1;
            $booked_package->update();
        }


        if ($request->trip_type == 4) // go and back
        {
            $user->wallet = $user->wallet + $sub_total_booking / 2;
            $user->update();
        }



        $reservationBookingRequest_id = $reservationBookingRequest->id;
        $runTripBack_id = $request->runTripBack;

        return redirect()->route('reservationBookingRequests.getTicketDesign',[$reservationBookingRequest_id,$runTripBack_id]);
    }



    /*** edit page ***/
    public function editPage(Request $request)
    {
        if ($request->has('search_Booking'))
        {
            $reservationBookingRequest = ReservationBookingRequest::find($request->search_Booking);
            return view('pages.ReservationBookingRequests.editPage',compact('reservationBookingRequest'));
        }

        return view('pages.ReservationBookingRequests.editPage');
    }



    /*** change seats ***/
    public function changeSeats(EditBookingRequest $request)
    {
//        return $request;
        if (isset($request->reservationBookingRequest_id))  // عشان اعرف هو جاي من changeSeats.blade ولا من changeSeatsNewTrip.blade
        {
            $reservationBookingRequest = ReservationBookingRequest::find($request->reservationBookingRequest_id);
        }
        else{
            $reservationBookingRequest = ReservationBookingRequest::find($request->newReservationBookingRequest_id);
        }


        $time_of_now = Carbon::now();
        $get_line = Line::where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first();

        // Time_to_edit
        $time_to_edit = $get_line->time_to_edit;
        $time_to_edit_add_minutes = $reservationBookingRequest->created_at->addMinutes($time_to_edit);

        // Time_to_edit_without_fee
        $time_to_edit_without_fee = $get_line->time_to_edit_without_fee;
        $time_to_edit_without_fee_add_minutes = $reservationBookingRequest->created_at->addMinutes($time_to_edit_without_fee);


        if ( $time_of_now > $time_to_edit_add_minutes)  // هل الوقت مسموح فيه التعديل
        {
            return redirect()->route('reservationBookingRequests.editPage')->with('alert-danger','لقد تخطيت الوقت المسموح به لتعديل التذكرة');
        }
        else{

            if ($request->cancelFee == 'on')
            {

                $tripData = TripData::find($reservationBookingRequest->trip_id);
                $tripDegrees = $tripData->tripDegrees;
                $tripSeats = TripSeat::where('tripData_id',$tripData->id)->get();
                $busType = BusType::findOrFail($tripData->busType->id);



                // START To get sub_total of selected seats
                $bookingSeats = $request->seatId;
                $totalCount=0;
                for ($i=0; $i<count($bookingSeats); $i++)
                {
                    $bookingSeat_subTotal = BookingSeat::find($bookingSeats[$i])->sub_total;
                    $totalCount = $totalCount + $bookingSeat_subTotal;
                }
                // END To get sub_total of selected seats


                // START To get sub_total of discount
                $linesOfBooking = DB::table('lines')
                    ->join('trip_data','trip_data.id','=','lines.tripData_id')
                    ->join('reservation_booking_requests','trip_data.id','=','reservation_booking_requests.trip_id')
                    ->join('booking_seats','reservation_booking_requests.id','=','booking_seats.booking_id')
                    ->where('lines.stationFrom_id','=',$reservationBookingRequest->stationFrom_id)
                    ->where('lines.stationTo_id','=',$reservationBookingRequest->stationTo_id)
                    ->select('lines.*')->distinct()->get();



                if ($time_of_now > $time_to_edit_without_fee_add_minutes)  // هل هيدفع غرامة تأخير
                {
                    // Start For selected seats
                    $bookingSeats = $request->seatId;
                    $totalDiscount=0;
                    for ($i=0; $i<count($bookingSeats); $i++)
                    {
                        $bookingSeat_degree_id = BookingSeat::find($bookingSeats[$i])->degree_id; //1
                        foreach ($linesOfBooking as $line)
                        {
                            if ($line->degree_id == $bookingSeat_degree_id)
                            {
                                $totalDiscount = $totalDiscount + $line->cancelFee;
                            }
                        }
                    }
                    // End For selected seats


                    // Start For the whole Booking
                    $allBookingSeats = $reservationBookingRequest->bookingSeats;
                    foreach ($allBookingSeats as $item)
                    {
                        $allBookingSeatsIds[] = $item->id;
                    }

                    $totalDiscountForAllSeats = 0;
                    for ($i=0; $i<count($allBookingSeatsIds); $i++)
                    {
                        $bookingSeat_all_degree_id = BookingSeat::find($allBookingSeatsIds[$i])->degree_id; //1
                        foreach ($linesOfBooking as $line)
                        {
                            if ($line->degree_id == $bookingSeat_all_degree_id)
                            {
                                $totalDiscountForAllSeats = $totalDiscountForAllSeats + $line->cancelFee;
                            }
                        }
                    }

                    // End For the whole Booking

                }
                else{
                    $totalDiscount=0;
                    $totalDiscountForAllSeats=0;
                    $line = Line::where('tripData_id',$reservationBookingRequest->tripData_id)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first();
                }


                // END To get sub_total of discount


                return view('pages.ReservationBookingRequests.cancelBooking',compact('reservationBookingRequest','tripData','tripDegrees','tripSeats','busType','request','totalCount','totalDiscount','line','totalDiscountForAllSeats'));
            }


            if (!$request->trip_type)
            {
                return redirect()->back()->with('alert-danger','برجاء تحديد نوع الرحلة');
            }



            if ($request->trip_type == 1) // The same trip
            {

                $tripData = TripData::find($reservationBookingRequest->trip_id);
                $tripDegrees = $tripData->tripDegrees;
                $tripSeats = TripSeat::where('tripData_id',$tripData->id)->get();
                $busType = BusType::findOrFail($tripData->busType->id);


                // START Make sure of process
                if ($request->has('old_paid'))
                {
//                return $request;
                    if (!$request->NewSeatId){
                        return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
                    }



                    if ($reservationBookingRequest->type == 1)  // GO
                    {
                        if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceGo
                        {
                            for ($i=0; $i<count($request->NewSeatId); $i++)
                            {
                                $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                $getPriceGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceGo;
                                $arr[] = "$getPriceGoOfDegree";
                                $degrees[] = $getPriceGoOfDegree;
                            }

                            $newArr = array_count_values($arr);

                            foreach ($newArr as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiply[] = $multiply;
                            }

                            $total = array_sum($arrMultiply);

                            $wallet = 0;


                        }

                        else{ // foreign ==>  priceForeignerGo

                            for ($i=0; $i<count($request->NewSeatId); $i++)
                            {
                                $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerGo;
                                $arr[] = "$getPriceForeignerGoOfDegree";
                                $degrees[] = $getPriceForeignerGoOfDegree;
                            }

                            $newArr = array_count_values($arr);

                            foreach ($newArr as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiply[] = $multiply;
                            }

                            $total = array_sum($arrMultiply);

                            $wallet = 0;
                        }
                    }
                    else{   // BACK

                        if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceBack
                        {
                            for ($i=0; $i<count($request->NewSeatId); $i++)
                            {
                                $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                $getPriceBackOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceBack;
                                $getPriceGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceGo;
                                $arrPriceBack[] = "$getPriceBackOfDegree";
                                $arrPriceGo[] = "$getPriceGoOfDegree";
                                $degrees[] = $getPriceBackOfDegree;
                            }

                            $newArrPriceBack = array_count_values($arrPriceBack);
                            foreach ($newArrPriceBack as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiplyPriceBack[] = $multiply;
                            }
                            $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                            $newArrPriceGo = array_count_values($arrPriceGo);
                            foreach ($newArrPriceGo as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiplyPriceGo[] = $multiply;
                            }
                            $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                            $total = $totalPriceBack;
                            $totalGo = $totalPriceGo;

                            $wallet = $total - $totalGo;  // wallet


                        }
                        else{ // foreign ==>  priceForeignerBack

                            for ($i=0; $i<count($request->NewSeatId); $i++)
                            {
                                $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                $getPriceForeignerBackOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerBack;
                                $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerGo;
                                $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                                $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                                $degrees[] = $getPriceForeignerBackOfDegree;
                            }


                            $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
                            foreach ($newArrPriceForeignerBack as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiplyPriceForeignerBack[] = $multiply;
                            }
                            $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



                            $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
                            foreach ($newArrPriceForeignerGo as $key=>$value)
                            {
                                $multiply = $key * $value;

                                $arrMultiplyPriceForeignerGo[] = $multiply;
                            }
                            $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


                            $total = $totalPriceForeignerBack;
                            $totalGo = $totalPriceForeignerGo;

                            $wallet = $total - $totalGo;  // wallet

                        }

                    }


                    $totalOfNewBooking = $total;
                    $totalCount = $request->totalCount;
                    $totalDiscount = $request->totalDiscount;
                    $newTripSeats = $request->NewSeatId;
                    $line = Line::find($request->line_id);

                    return view('pages.ReservationBookingRequests.changeSeats',compact('reservationBookingRequest','tripData','tripDegrees', 'newTripSeats','tripSeats','busType','request','totalCount','totalDiscount','line','totalOfNewBooking'));
                }
                // END Make sure of process




                // START To get sub_total of selected seats
                $bookingSeats = $request->seatId;
                $totalCount=0;
                for ($i=0; $i<count($bookingSeats); $i++)
                {
                    $bookingSeat_subTotal = BookingSeat::find($bookingSeats[$i])->sub_total;
                    $totalCount = $totalCount + $bookingSeat_subTotal;
                }
                // END To get sub_total of selected seats


                // START To get sub_total of discount
                $linesOfBooking = DB::table('lines')
                    ->join('trip_data','trip_data.id','=','lines.tripData_id')
                    ->join('reservation_booking_requests','trip_data.id','=','reservation_booking_requests.trip_id')
                    ->join('booking_seats','reservation_booking_requests.id','=','booking_seats.booking_id')
                    ->where('lines.stationFrom_id','=',$reservationBookingRequest->stationFrom_id)
                    ->where('lines.stationTo_id','=',$reservationBookingRequest->stationTo_id)
                    ->select('lines.*')->distinct()->get();



                if ($time_of_now > $time_to_edit_without_fee_add_minutes)
                {

                    $bookingSeats = $request->seatId;
                    $totalDiscount=0;
                    for ($i=0; $i<count($bookingSeats); $i++)
                    {
                        $bookingSeat_degree_id = BookingSeat::find($bookingSeats[$i])->degree_id; //1
                        foreach ($linesOfBooking as $line)
                        {
                            if ($line->degree_id == $bookingSeat_degree_id)
                            {
                                $totalDiscount = $totalDiscount + $line->editFee;
                            }
                        }
                    }
                }
                else{
                    $totalDiscount=0;
                    $line = Line::where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first();
                }


                // END To get sub_total of discount


                return view('pages.ReservationBookingRequests.changeSeats',compact('reservationBookingRequest','tripData','tripDegrees','tripSeats','busType','request','totalCount','totalDiscount','line'));
            }
            else if ($request->trip_type == 2) // Other Trip
            {

                if ($request->has('newReservationBookingRequest_id'))
                {
                    $old_tripData = TripData::find($reservationBookingRequest->trip_id);
                    $old_tripDegrees = $old_tripData->tripDegrees;
                    $old_tripSeats = TripSeat::where('tripData_id',$old_tripData->id)->get();
                    $old_busType = BusType::findOrFail($old_tripData->busType->id);


                    $new_tripData = TripData::find($request->new_tripData_id);
                    $new_tripDegrees = $new_tripData->tripDegrees;
                    $new_tripSeats = TripSeat::where('tripData_id',$new_tripData->id)->get();
                    $new_busType = BusType::findOrFail($new_tripData->busType->id);


                    // START Make sure of process
                    if ($request->has('old_paid'))
                    {
//                        return $request;
                        if (!$request->NewSeatId){
                            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
                        }


//                        return $request;
                        if ($reservationBookingRequest->type == 1)  // GO
                        {
                            if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceGo
                            {

                                for ($i=0; $i<count($request->NewSeatId); $i++)
                                {
                                    $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                    $getPriceGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceGo;
                                    $arr[] = "$getPriceGoOfDegree";
                                    $degrees[] = $getPriceGoOfDegree;
                                }

                                $newArr = array_count_values($arr);

                                foreach ($newArr as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiply[] = $multiply;
                                }

                                $total = array_sum($arrMultiply);

                                $wallet = 0;


                            }

                            else{ // foreign ==>  priceForeignerGo

                                for ($i=0; $i<count($request->NewSeatId); $i++)
                                {
                                    $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                    $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerGo;
                                    $arr[] = "$getPriceForeignerGoOfDegree";
                                    $degrees[] = $getPriceForeignerGoOfDegree;
                                }

                                $newArr = array_count_values($arr);

                                foreach ($newArr as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiply[] = $multiply;
                                }

                                $total = array_sum($arrMultiply);

                                $wallet = 0;
                            }
                        }
                        else{   // BACK

                            if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceBack
                            {
                                for ($i=0; $i<count($request->NewSeatId); $i++)
                                {
                                    $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                    $getPriceBackOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceBack;
                                    $getPriceGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceGo;
                                    $arrPriceBack[] = "$getPriceBackOfDegree";
                                    $arrPriceGo[] = "$getPriceGoOfDegree";
                                    $degrees[] = $getPriceBackOfDegree;
                                }

                                $newArrPriceBack = array_count_values($arrPriceBack);
                                foreach ($newArrPriceBack as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiplyPriceBack[] = $multiply;
                                }
                                $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                                $newArrPriceGo = array_count_values($arrPriceGo);
                                foreach ($newArrPriceGo as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiplyPriceGo[] = $multiply;
                                }
                                $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                                $total = $totalPriceBack;
                                $totalGo = $totalPriceGo;

                                $wallet = $total - $totalGo;  // wallet


                            }
                            else{ // foreign ==>  priceForeignerBack

                                for ($i=0; $i<count($request->NewSeatId); $i++)
                                {
                                    $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                                    $getPriceForeignerBackOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerBack;
                                    $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerGo;
                                    $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                                    $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                                    $degrees[] = $getPriceForeignerBackOfDegree;
                                }


                                $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
                                foreach ($newArrPriceForeignerBack as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiplyPriceForeignerBack[] = $multiply;
                                }
                                $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



                                $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
                                foreach ($newArrPriceForeignerGo as $key=>$value)
                                {
                                    $multiply = $key * $value;

                                    $arrMultiplyPriceForeignerGo[] = $multiply;
                                }
                                $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


                                $total = $totalPriceForeignerBack;
                                $totalGo = $totalPriceForeignerGo;

                                $wallet = $total - $totalGo;  // wallet

                            }

                        }



                        $totalOfNewBooking = $total;
                        $totalCount = $request->totalCount;
                        $totalDiscount = $request->totalDiscount;
                        $newTripSeats = $request->NewSeatId;
                        $line = Line::find($request->line_id);


                        return view('pages.ReservationBookingRequests.changeSeatsNewTrip',compact('reservationBookingRequest','old_tripData','old_tripDegrees', 'newTripSeats','old_tripSeats','old_busType','request','totalCount','totalDiscount','line','totalOfNewBooking','new_tripData','new_tripDegrees','new_tripSeats','new_busType'));
                    }
                    // END Make sure of process


                    // START To get sub_total of selected seats
                    $bookingSeats = $request->seatId;
                    $totalCount=0;
                    for ($i=0; $i<count($bookingSeats); $i++)
                    {
                        $bookingSeat_subTotal = BookingSeat::find($bookingSeats[$i])->sub_total;
                        $totalCount = $totalCount + $bookingSeat_subTotal;
                    }
                    // END To get sub_total of selected seats


                    // START To get sub_total of fee
                    $linesOfBooking = DB::table('lines')
                        ->join('trip_data','trip_data.id','=','lines.tripData_id')
                        ->join('reservation_booking_requests','trip_data.id','=','reservation_booking_requests.trip_id')
                        ->join('booking_seats','reservation_booking_requests.id','=','booking_seats.booking_id')
                        ->where('lines.stationFrom_id','=',$reservationBookingRequest->stationFrom_id)
                        ->where('lines.stationTo_id','=',$reservationBookingRequest->stationTo_id)
                        ->select('lines.*')->distinct()->get();

//                    return $request;
                    if ($time_of_now > $time_to_edit_without_fee_add_minutes)
                    {
                        $bookingSeats = $request->seatId;
                        $totalDiscount=0;
                        for ($i=0; $i<count($bookingSeats); $i++)
                        {
                            $bookingSeat_degree_id = BookingSeat::find($bookingSeats[$i])->degree_id; //1
                            foreach ($linesOfBooking as $line)
                            {
                                if ($line->degree_id == $bookingSeat_degree_id)
                                {
                                    $totalDiscount = $totalDiscount + $line->editFee;
                                }
                            }
                        }
                    }
                    else{

                        $totalDiscount=0;
                        $line = Line::where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first();
                    }




                    // END To get sub_total of fee

                    return view('pages.ReservationBookingRequests.changeSeatsNewTrip',compact('reservationBookingRequest','old_tripData','old_tripDegrees','old_tripSeats','old_busType','request','totalCount','totalDiscount','line','new_busType','new_tripData','new_tripDegrees','new_tripSeats'));
                }

//            $stations = Station::select('id','name')->get();

//            return view('pages.ReservationBookingRequests.editPage',compact('stations','reservationBookingRequest','request'));
            }
        }



        $stations = Station::select('id','name')->get();


        return view('pages.ReservationBookingRequests.editPage',compact('stations','reservationBookingRequest','request'));

    }



    /*** Make new Booking Request ***/
    public function newBookingAfterChangeSeats(Request $request)
    {

        $reservationBookingRequest = ReservationBookingRequest::find($request->reservationBookingRequest_id);

         $runTrip = RunTrip::find($reservationBookingRequest->runTrip_id);

        if (!$request->NewSeatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }


        if ($request->totalOfNewBooking != 0) // To prevent him from click sure before calc
        {
            if ($reservationBookingRequest->type == 1)  // GO
            {
                if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceGo
                {
                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceGo;
                        $arr[] = "$getPriceGoOfDegree";
                        $degrees[] = $getPriceGoOfDegree;
                    }

                    $newArr = array_count_values($arr);

                    foreach ($newArr as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiply[] = $multiply;
                    }

                    $total = array_sum($arrMultiply);

                    $wallet = 0;

                }

                else{ // foreign ==>  priceForeignerGo

                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerGo;
                        $arr[] = "$getPriceForeignerGoOfDegree";
                        $degrees[] = $getPriceForeignerGoOfDegree;
                    }

                    $newArr = array_count_values($arr);

                    foreach ($newArr as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiply[] = $multiply;
                    }

                    $total = array_sum($arrMultiply);

                    $wallet = 0;
                }
            }
            else{   // BACK

                if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceBack
                {
                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceBackOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceBack;
                        $getPriceGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceGo;
                        $arrPriceBack[] = "$getPriceBackOfDegree";
                        $arrPriceGo[] = "$getPriceGoOfDegree";
                        $degrees[] = $getPriceBackOfDegree;
                    }

                    $newArrPriceBack = array_count_values($arrPriceBack);
                    foreach ($newArrPriceBack as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceBack[] = $multiply;
                    }
                    $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                    $newArrPriceGo = array_count_values($arrPriceGo);
                    foreach ($newArrPriceGo as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceGo[] = $multiply;
                    }
                    $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                    $total = $totalPriceBack;
                    $totalGo = $totalPriceGo;

                    $wallet = $total - $totalGo;  // wallet


                }
                else{ // foreign ==>  priceForeignerBack

                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceForeignerBackOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerBack;
                        $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$reservationBookingRequest->trip_id)->where('degree_id',$getDegree)->where('from_id',$reservationBookingRequest->stationFrom_id)->where('to_id',$reservationBookingRequest->stationTo_id)->first()->priceForeignerGo;
                        $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                        $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                        $degrees[] = $getPriceForeignerBackOfDegree;
                    }


                    $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
                    foreach ($newArrPriceForeignerBack as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceForeignerBack[] = $multiply;
                    }
                    $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



                    $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
                    foreach ($newArrPriceForeignerGo as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceForeignerGo[] = $multiply;
                    }
                    $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


                    $total = $totalPriceForeignerBack;
                    $totalGo = $totalPriceForeignerGo;

                    $wallet = $total - $totalGo;  // wallet

                }

            }
        }
        else{
            return redirect()->back()->with('alert-danger','برجاء حساب الحجز أولا');
        }




        // Create New Booking Request
        $newReservationBookingRequest = new ReservationBookingRequest();
        $newReservationBookingRequest->runTrip_id = $reservationBookingRequest->runTrip_id;
        $newReservationBookingRequest->trip_id = $reservationBookingRequest->trip_id;
        $newReservationBookingRequest->user_id = $reservationBookingRequest->user_id;
        $newReservationBookingRequest->stationFrom_id = $reservationBookingRequest->stationFrom_id;
        $newReservationBookingRequest->stationTo_id = $reservationBookingRequest->stationTo_id;
        $newReservationBookingRequest->address = $reservationBookingRequest->address;
        $newReservationBookingRequest->total = $total;
        $newReservationBookingRequest->discount = 0;
        $newReservationBookingRequest->sub_total = $total;
        $newReservationBookingRequest->wallet = $wallet;
        $newReservationBookingRequest->type = $reservationBookingRequest->type;
        $newReservationBookingRequest->passenger_type = $reservationBookingRequest->passenger_type;
        $newReservationBookingRequest->admin_id = auth('admin')->id();
        $newReservationBookingRequest->office_id = auth('admin')->user()->office_id;
        $newReservationBookingRequest->active = 1;
        $newReservationBookingRequest->save();


        /* عشان ال trip_station من خلال ال ( reservationBookingRequest->stationFrom_id && $reservationBookingRequest->stationTo_id$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$reservationBookingRequest->trip_id)->where('station_id',$reservationBookingRequest->stationFrom_id)->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$reservationBookingRequest->trip_id)->where('station_id',$reservationBookingRequest->stationTo_id)->first()->id;


        // Create New Seats in Booking Request
        for ($i=0; $i<count($request->NewSeatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $newReservationBookingRequest->id;
            $bookingSeats->runTrip_id = $newReservationBookingRequest->runTrip_id;
            $bookingSeats->seat_id = $request->NewSeatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $degrees[$i];
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }



        // create trigger
        $les = new Les();
        $les->amount = $request->totalRemain;
        $les->type = 1;
        $les->ticket_id = $newReservationBookingRequest->id;
        $les->action =      ' تم إلغاء عدد مقاعد ' . count($request->seatId) . ' التابعة للتذكرة رقم '. $reservationBookingRequest->id  . ' وتم حجز عدد مقاعد '. count($request->NewSeatId) .' التابعة للتذكرة رقم '. $newReservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $request->totalRemain . ' جنيها ';
        $les->admin_id = auth('admin')->id();
        $les->office_id = auth('admin')->user()->office_id;
        $les->active = 1;
        $les->save();


        // Delete old Seats in Booking Request
        $sub_total_of_old_booking_seats = 0;
        for ($i=0; $i<count($request->seatId); $i++)
        {
            $bookingSeats = BookingSeat::find($request->seatId[$i]);
            $sub_total_of_old_booking_seats += $bookingSeats->sub_total;
            $bookingSeats->delete();
        }


        // Minus sub_total of deleted seats from its ticket
        $reservationBookingRequest->sub_total -= $sub_total_of_old_booking_seats;
        $reservationBookingRequest->update();


        return redirect()->route('reservationBookingRequests.editPage')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** Make new Booking Request new trip ***/
    public function newBookingAfterChangeSeatsNewTrip(Request $request)
    {

        $reservationBookingRequest = ReservationBookingRequest::find($request->reservationBookingRequest_id);
        $run_trip = RunTrip::find($request->new_runTrip_id);

        if (!$request->NewSeatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }

//        return $request;

        if ($request->totalOfNewBooking != 0) // To prevent him from click sure before calc
        {
            if ($reservationBookingRequest->type == 1)  // GO
            {
                if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceGo
                {
//                            return $request->NewSeatId;
                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceGo;
                        $arr[] = "$getPriceGoOfDegree";
                        $degrees[] = $getPriceGoOfDegree;
                    }

                    $newArr = array_count_values($arr);

                    foreach ($newArr as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiply[] = $multiply;
                    }

                    $total = array_sum($arrMultiply);

                    $wallet = 0;


                }

                else{ // foreign ==>  priceForeignerGo

                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerGo;
                        $arr[] = "$getPriceForeignerGoOfDegree";
                        $degrees[] = $getPriceForeignerGoOfDegree;
                    }

                    $newArr = array_count_values($arr);

                    foreach ($newArr as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiply[] = $multiply;
                    }

                    $total = array_sum($arrMultiply);

                    $wallet = 0;
                }
            }
            else{   // BACK

                if ($reservationBookingRequest->passenger_type == 1) // egyptian ==>  priceBack
                {
                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceBackOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceBack;
                        $getPriceGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceGo;
                        $arrPriceBack[] = "$getPriceBackOfDegree";
                        $arrPriceGo[] = "$getPriceGoOfDegree";
                        $degrees[] = $getPriceBackOfDegree;
                    }

                    $newArrPriceBack = array_count_values($arrPriceBack);
                    foreach ($newArrPriceBack as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceBack[] = $multiply;
                    }
                    $totalPriceBack = array_sum($arrMultiplyPriceBack); // total of priceBack



                    $newArrPriceGo = array_count_values($arrPriceGo);
                    foreach ($newArrPriceGo as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceGo[] = $multiply;
                    }
                    $totalPriceGo = array_sum($arrMultiplyPriceGo); // total of priceGo


                    $total = $totalPriceBack;
                    $totalGo = $totalPriceGo;

                    $wallet = $total - $totalGo;  // wallet


                }
                else{ // foreign ==>  priceForeignerBack

                    for ($i=0; $i<count($request->NewSeatId); $i++)
                    {
                        $getDegree = TripSeat::where('tripData_id',$request->new_tripData_id)->where('id',$request->NewSeatId[$i])->first()->degree->id; //1
                        $getPriceForeignerBackOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerBack;
                        $getPriceForeignerGoOfDegree  = Line::where('tripData_id',$request->new_tripData_id)->where('degree_id',$getDegree)->where('from_id',$request->new_stationFrom_id)->where('to_id',$request->new_stationTo_id)->first()->priceForeignerGo;
                        $arrPriceForeignerBack[] = "$getPriceForeignerBackOfDegree";
                        $arrPriceForeignerGo[] = "$getPriceForeignerGoOfDegree";
                        $degrees[] = $getPriceForeignerBackOfDegree;
                    }


                    $newArrPriceForeignerBack = array_count_values($arrPriceForeignerBack);
                    foreach ($newArrPriceForeignerBack as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceForeignerBack[] = $multiply;
                    }
                    $totalPriceForeignerBack = array_sum($arrMultiplyPriceForeignerBack);  // total of priceBack



                    $newArrPriceForeignerGo = array_count_values($arrPriceForeignerGo);
                    foreach ($newArrPriceForeignerGo as $key=>$value)
                    {
                        $multiply = $key * $value;

                        $arrMultiplyPriceForeignerGo[] = $multiply;
                    }
                    $totalPriceForeignerGo = array_sum($arrMultiplyPriceForeignerGo);  // total of priceBack


                    $total = $totalPriceForeignerBack;
                    $totalGo = $totalPriceForeignerGo;

                    $wallet = $total - $totalGo;  // wallet

                }

            }

        }
        else{
            return redirect()->back()->with('alert-danger','برجاء حساب الحجز أولا');
        }




        // Create New Booking Request
        $newReservationBookingRequest = new ReservationBookingRequest();
        $newReservationBookingRequest->runTrip_id = $request->new_runTrip_id;
        $newReservationBookingRequest->trip_id = $request->new_tripData_id;
        $newReservationBookingRequest->user_id = $reservationBookingRequest->user_id;
        $newReservationBookingRequest->stationFrom_id = $request->new_stationFrom_id;
        $newReservationBookingRequest->stationTo_id = $request->new_stationTo_id;
        $newReservationBookingRequest->address = $reservationBookingRequest->address;
        $newReservationBookingRequest->total = $total;
        $newReservationBookingRequest->discount = 0;
        $newReservationBookingRequest->sub_total = $total;
        $newReservationBookingRequest->wallet = $wallet;
        $newReservationBookingRequest->type = $reservationBookingRequest->type;
        $newReservationBookingRequest->passenger_type = $reservationBookingRequest->passenger_type;
        $newReservationBookingRequest->admin_id = auth('admin')->id();
        $newReservationBookingRequest->office_id = auth('admin')->user()->office_id;
        $newReservationBookingRequest->active = 1;
        $newReservationBookingRequest->save();



        /* عشان ال trip_station من خلال ال ( request->new_stationFrom_id  &&  $request->new_stationTo_id$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$request->new_tripData_id)->where('station_id',$request->new_stationFrom_id)->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$request->new_tripData_id)->where('station_id',$request->new_stationTo_id)->first()->id;



        // Create New Seats in Booking Request
        for ($i=0; $i<count($request->NewSeatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->NewSeatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $newReservationBookingRequest->id;
            $bookingSeats->runTrip_id = $newReservationBookingRequest->runTrip_id;
            $bookingSeats->seat_id = $request->NewSeatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $degrees[$i];
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }


        // create trigger
        $les = new Les();
        $les->amount = $request->totalRemain;
        $les->type = 1;
        $les->ticket_id = $newReservationBookingRequest->id;
        $les->action =      ' تم إلغاء عدد مقاعد ' . count($request->seatId) . ' التابعة للتذكرة رقم '. $reservationBookingRequest->id  . ' وتم حجز عدد مقاعد '. count($request->NewSeatId) .' التابعة للتذكرة رقم '. $newReservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $request->totalRemain . ' جنيها ';
        $les->admin_id = auth('admin')->id();
        $les->office_id = auth('admin')->user()->office_id;
        $les->active = 1;
        $les->save();


        // Delete old Seats in Booking Request
        $sub_total_of_old_booking_seats = 0;
        for ($i=0; $i<count($request->seatId); $i++)
        {
            $bookingSeats = BookingSeat::find($request->seatId[$i]);
            $sub_total_of_old_booking_seats += $bookingSeats->sub_total;
            $bookingSeats->delete();
        }


        // Minus sub_total of deleted seats from its ticket
        $reservationBookingRequest->sub_total -= $sub_total_of_old_booking_seats;
        $reservationBookingRequest->update();




        return redirect()->route('reservationBookingRequests.editPage')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** Cancel Booking Request new trip ***/
    public function cancelBooking(Request $request)
    {

        $reservationBookingRequest = ReservationBookingRequest::find($request->reservationBookingRequest_id);


        if ($request->has('totalCount'))  // Delete only old seats
        {
            // create trigger
            $les = new Les();
            $les->amount = $request->totalRemain;
            $les->type = 2;
            $les->ticket_id = null;
            $les->action =  ' تم إلغاء عدد مقاعد ' . count($request->seatId) . ' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل باسترداد مبلغ قدره ' . $request->totalRemain . ' جنيها ';
            $les->admin_id = auth('admin')->id();
            $les->office_id = auth('admin')->user()->office_id;
            $les->active = 1;
            $les->save();


            // Delete old Seats in Booking Request
            $sub_total_of_old_booking_seats = 0;
            for ($i=0; $i<count($request->seatId); $i++)
            {
                $bookingSeats = BookingSeat::find($request->seatId[$i]);
                $sub_total_of_old_booking_seats += $bookingSeats->sub_total;
                $bookingSeats->delete();
            }


            // Minus sub_total of deleted seats from its ticket
            $reservationBookingRequest->sub_total -= $sub_total_of_old_booking_seats;
            $reservationBookingRequest->update();

        }
         else{ // Delete the whole Ticket


             // related seats of the ticket
             $booking_seats = $reservationBookingRequest->bookingSeats;

             // create trigger
             $les = new Les();
             $les->amount = $request->totalRemain;
             $les->type = 2;
             $les->ticket_id = null;
             $les->action =  ' تم إلغاء التذكرة رقم ' . $reservationBookingRequest->id . ' والتي تحتوي علي عدد مقاعد '.  count($booking_seats)  .' وقام العميل باسترداد مبلغ قدره ' . $request->totalRemain . ' جنيها ';
             $les->admin_id = auth('admin')->id();
             $les->office_id = auth('admin')->user()->office_id;
             $les->active = 1;
             $les->save();


             // Delete old Seats in Booking Request
             $sub_total_of_old_booking_seats = 0;
             foreach ($booking_seats as $seat)
             {

                 $sub_total_of_old_booking_seats += $seat->sub_total;
                 $seat->delete();
             }

             // Delete the ticket
             $reservationBookingRequest->delete();
         }




        return redirect()->route('reservationBookingRequests.editPage')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** get ticket design ***/
    public function getTicketDesign(Request $request,$reservationBookingRequest_id, $runTripBack_id = null)
    {

        // لو هو جاي من البحث بالرقم السري
        if (isset($request->secret_code))
        {
            $reservationBookingRequest = ReservationBookingRequest::where('secret_code',$request->secret_code)->first();

            if ($reservationBookingRequest)
            {
                return view('pages.ReservationBookingRequests.ticketDesign',compact('reservationBookingRequest','request','runTripBack_id'));
            }
            else{
                return redirect()->back()->with('alert-danger','البيانات غير متطابقة');
            }

        }



        $reservationBookingRequest = ReservationBookingRequest::find($reservationBookingRequest_id);

//        if ($paid_user != null) // الرحلة ذهاب وعودة
//        {
//            return view('pages.ReservationBookingRequests.ticketDesign',compact('reservationBookingRequest','paid_user','company_arabic_name','company_english_name'));
//        }
        return view('pages.ReservationBookingRequests.ticketDesign',compact('reservationBookingRequest','runTripBack_id'));
    }



    /*** ticket_back page ***/
    public function ticket_back(Request $request,$id)
    {
        $date_of_now = Carbon::now()->toDateString();

        $old_reservationBookingRequest = ReservationBookingRequest::find($id);

        if($request->has('startDate') && $request->has('endDate'))
        {
            $get_run_trips = RunTrip::whereBetween('startDate',[$request->startDate,$request->endDate])->
            where('startDate','>=',$date_of_now)->
            whereHas('tripData',function ($q1) use($old_reservationBookingRequest)
            {
                $q1->whereHas('lines',function ($q2) use($old_reservationBookingRequest)
                {
                    $q2->where('to_id',$old_reservationBookingRequest->stationFrom_id)
                        ->where('from_id',$old_reservationBookingRequest->stationTo_id);
                });

            })->paginate(50);
            return view('pages.ReservationBookingRequests.showRunTripsTicketBack',compact('old_reservationBookingRequest','request','get_run_trips'));
        }

        $get_run_trips = RunTrip::where('startDate','>=',$date_of_now)->
        whereHas('tripData',function ($q1) use($old_reservationBookingRequest)
        {
            $q1->whereHas('lines',function ($q2) use($old_reservationBookingRequest)
            {
                $q2->where('to_id',$old_reservationBookingRequest->stationFrom_id)
                    ->where('from_id',$old_reservationBookingRequest->stationTo_id);
            });

        })->paginate(50);

        return view('pages.ReservationBookingRequests.showRunTripsTicketBack',compact('old_reservationBookingRequest','get_run_trips'));

    }



    /*** chooseSeats_ticketBack ***/
    public function chooseSeats_ticketBack(Request $request)
    {
//        return $request;
        $runTrip_back = RunTrip::findOrFail($request->runTrip_id);
        $tripSeats = TripSeat::where('tripData_id',$runTrip_back->tripData_id)->get();
        $busType = BusType::findOrFail($runTrip_back->tripData->busType->id);
        $old_reservationBookingRequest = ReservationBookingRequest::find($request->old_reservationBookingRequest);

       $bookedSeats = $old_reservationBookingRequest->bookingSeats;

         /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */
        foreach ($bookedSeats as $bookedSeat)
        {
            $array[] =  $bookedSeat->degree_id;
        }
        $degrees_with_count = array_count_values($array);
        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */


        return view('pages.ReservationBookingRequests.ticketBack.ticketBack',compact('request','runTrip_back','bookedSeats','old_reservationBookingRequest','tripSeats','busType','degrees_with_count'));
    }



    /*** calc_ticket_back ***/
    public function calc_ticket_back(Request $request)
    {
//        return $request;

        $old_ticket = ReservationBookingRequest::find($request->old_reservationBookingRequest_id);
        $user = User::findOrFail($old_ticket->user_id);
        $new_tripData_id = TripData::findOrFail($request->tripData_id);

        if (!$request->seatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }

        if (count($request->newSeats) < count($request->seatId))
        {
            return redirect()->back()->with('alert-danger','بيانات المقاعد غير متطابقة');
        }




        /* عشان اجيب الفرق بين الكراسي المحجوزة */
        $pay_money = 0;
        for ($i=0; $i<count($request->oldSeats); $i++)
        {
            $degree_of_old_seat = TripSeat::where('id',$request->oldSeats[$i])->first()->degree->id;
            $degree_of_new_seat = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;
            if ( $degree_of_old_seat != $degree_of_new_seat)
            {
                $priceOldSeat = BookingSeat::where('seat_id',$request->oldSeats[$i])->where('booking_id',$request->old_reservationBookingRequest_id)->first()->sub_total;

                if ($old_ticket->passenger_type == 1) // egyptian ==>  priceGo
                {
                    $priceNewSeat = Line::where('degree_id',$degree_of_new_seat)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                }
                else{
                    $priceNewSeat = Line::where('degree_id',$degree_of_new_seat)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                }

                if ($priceNewSeat > $priceOldSeat)
                {
                    $pay_money = $pay_money + ($priceNewSeat - $priceOldSeat);
                }
            }
        }
//        return $pay_money;


        $runTrip_back = RunTrip::findOrFail($request->runTrip_id);
        $tripSeats = TripSeat::where('tripData_id',$runTrip_back->tripData_id)->get();
        $busType = BusType::findOrFail($runTrip_back->tripData->busType->id);
        $old_reservationBookingRequest = ReservationBookingRequest::find($request->old_reservationBookingRequest);
        $linesOfTrip = Line::where('tripData_id',$runTrip_back->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->get();
        $bookedSeats = $old_ticket->bookingSeats;
        $newTripSeats = $request->seatId;

        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */
        foreach ($bookedSeats as $bookedSeat)
        {
            $array[] =  $bookedSeat->degree_id;
        }
        $degrees_with_count = array_count_values($array);
        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */



        return view('pages.ReservationBookingRequests.ticketBack.calc_ticketBack',compact('request','pay_money','old_reservationBookingRequest','tripSeats','busType','bookedSeats','degrees_with_count','runTrip_back','linesOfTrip','newTripSeats'));
    }


    /*** save_ticket_back ***/
    public function save_ticket_back(Request $request)
    {
//        return $request;

        $old_ticket = ReservationBookingRequest::find($request->old_reservationBookingRequest_id);
        $user = User::findOrFail($old_ticket->user_id);

        if (!$request->seatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }



        /*  التذكرة ذهاب فقط */
        if ($old_ticket->passenger_type == 1) // egyptian ==>  priceGo
        {
            for ($i=0; $i<count($request->seatId); $i++)
            {
                $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                $arr[] = "$getPriceGoOfDegree";
                $degrees[] = $getPriceGoOfDegree;
            }

            $newArr = array_count_values($arr);

            foreach ($newArr as $key=>$value)
            {
                $multiply = $key * $value;

                $arrMultiply[] = $multiply;
            }

            $total = array_sum($arrMultiply);

            $wallet = 0;


        }
        else{ // foreign ==>  priceForeignerGo

            for ($i=0; $i<count($request->seatId); $i++)
            {
                $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                $arr[] = "$getPriceForeignerGoOfDegree";
                $degrees[] = $getPriceForeignerGoOfDegree;
            }

            $newArr = array_count_values($arr);

            foreach ($newArr as $key=>$value)
            {
                $multiply = $key * $value;

                $arrMultiply[] = $multiply;
            }

            $total = array_sum($arrMultiply);

            $wallet = 0;
        }
        /*  التذكرة ذهاب فقط */



        // no coupons
        $total_discount_booking = 0; // no coupons
        $sub_total_booking = $old_ticket->sub_total; // no coupons

        for ($i=0; $i<count($request->seatId); $i++)
        {
            $sub_total_seat[] = $degrees[$i];
        }




        // make new ticket
        $reservationBookingRequest = new ReservationBookingRequest();
        $reservationBookingRequest->runTrip_id = $request['runTrip_id'];
        $reservationBookingRequest->trip_id = $request['tripData_id'];
        $reservationBookingRequest->go_ticket_id = $old_ticket->id;
        $reservationBookingRequest->user_id = $old_ticket->user_id;
        $reservationBookingRequest->stationFrom_id = $request['stationFrom_id'];
        $reservationBookingRequest->stationTo_id = $request['stationTo_id'];
        $reservationBookingRequest->total = $total;
        $reservationBookingRequest->discount = $total_discount_booking;
        $reservationBookingRequest->sub_total = $sub_total_booking;
        $reservationBookingRequest->wallet = $wallet;
        $reservationBookingRequest->type = 1;  // التذكرة ذهاب فقط
        $reservationBookingRequest->passenger_type = $old_ticket->passenger_type;
        $reservationBookingRequest->admin_id = auth('admin')->id();
        $reservationBookingRequest->office_id = auth('admin')->user()->office_id;
        $reservationBookingRequest->active = 1;
        $reservationBookingRequest->save();


        // update old ticket
        $old_ticket->go_ticket_id = $reservationBookingRequest->id;
        $old_ticket->update();



        /* عشان ال trip_station من خلال ال ( request['stationFrom_id']  &&  $request['stationTo_id']$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationFrom_id'])->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationTo_id'])->first()->id;



        // create booking seats
        for ($i=0; $i<count($request->seatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $reservationBookingRequest->id;
            $bookingSeats->runTrip_id = $request['runTrip_id'];
            $bookingSeats->seat_id = $request->seatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $sub_total_seat[$i];
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }

        if ($request->pay_money > 0 )
        {
            // create trigger
            $les = new Les();
            $les->amount = $request->pay_money;
            $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $les->amount . ' جنيها ';
            $les->type = 1;
            $les->ticket_id = $reservationBookingRequest->id;
            $les->admin_id = auth('admin')->id();
            $les->office_id =  auth('admin')->user()->office_id;
            $les->active = 1;
            $les->save();
        }


        // update user_wallet
        $user->wallet = $user->wallet - $old_ticket->sub_total;
        $user->update();


        $reservationBookingRequest_id = $reservationBookingRequest->id;

        return redirect()->route('reservationBookingRequests.getTicketDesign',$reservationBookingRequest_id);
    }



    /*** chooseSeats_ticketBack ***/
    public function chooseSeats_ticketBack_closed(Request $request)
    {
//        return $request;
        $runTrip_back = RunTrip::findOrFail($request->runTripBack_id);
        $tripSeats = TripSeat::where('tripData_id',$runTrip_back->tripData_id)->get();
        $busType = BusType::findOrFail($runTrip_back->tripData->busType->id);
        $old_reservationBookingRequest = ReservationBookingRequest::find($request->old_reservationBookingRequest);
        $linesOfTrip = Line::where('tripData_id',$runTrip_back->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->get();

        $bookedSeats = $old_reservationBookingRequest->bookingSeats;

        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */
        foreach ($bookedSeats as $bookedSeat)
        {
            $array[] =  $bookedSeat->degree_id;
        }
        $degrees_with_count = array_count_values($array);
        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */

//        return $bookedSeats;

        return view('pages.ReservationBookingRequests.ticketBack.ticketBack_closed',compact('request','old_reservationBookingRequest','tripSeats','busType','bookedSeats','degrees_with_count','runTrip_back','linesOfTrip'));
    }


    /*** calc_ticket_back_closed ***/
    public function calc_ticket_back_closed(Request $request)
    {
//        return $request;

        $old_ticket = ReservationBookingRequest::find($request->old_reservationBookingRequest_id);
        $user = User::findOrFail($old_ticket->user_id);
        $new_tripData_id = TripData::findOrFail($request->tripData_id);

        if (!$request->seatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }

        if (count($request->newSeats) < count($request->seatId))
        {
            return redirect()->back()->with('alert-danger','بيانات المقاعد غير متطابقة');
        }




        /* عشان اجيب الفرق بين الكراسي المحجوزة */
        $pay_money = 0;
        for ($i=0; $i<count($request->oldSeats); $i++)
        {
             $degree_of_old_seat = TripSeat::where('id',$request->oldSeats[$i])->first()->degree->id;
             $degree_of_new_seat = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;
            if ( $degree_of_old_seat != $degree_of_new_seat)
            {
                $priceOldSeat = BookingSeat::where('seat_id',$request->oldSeats[$i])->where('booking_id',$request->old_reservationBookingRequest_id)->first()->sub_total;

                if ($old_ticket->passenger_type == 1) // egyptian ==>  priceGo
                {
                    $priceNewSeat = Line::where('degree_id',$degree_of_new_seat)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                }
                else{
                    $priceNewSeat = Line::where('degree_id',$degree_of_new_seat)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                }

                if ($priceNewSeat > $priceOldSeat)
                {
                    $pay_money = $pay_money + ($priceNewSeat - $priceOldSeat);
                }
            }
        }
//        return $pay_money;


        $runTrip_back = RunTrip::findOrFail($request->runTrip_id);
        $tripSeats = TripSeat::where('tripData_id',$runTrip_back->tripData_id)->get();
        $busType = BusType::findOrFail($runTrip_back->tripData->busType->id);
        $old_reservationBookingRequest = ReservationBookingRequest::find($request->old_reservationBookingRequest);
        $linesOfTrip = Line::where('tripData_id',$runTrip_back->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->get();
        $bookedSeats = $old_ticket->bookingSeats;
        $newTripSeats = $request->seatId;

        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */
        foreach ($bookedSeats as $bookedSeat)
        {
            $array[] =  $bookedSeat->degree_id;
        }
        $degrees_with_count = array_count_values($array);
        /* هات عدد الكراسي المحجوزة تبع كل درجة للتذكرة المذكورة */




        return view('pages.ReservationBookingRequests.ticketBack.calc_ticketBack_closed',compact('request','pay_money','old_reservationBookingRequest','tripSeats','busType','bookedSeats','degrees_with_count','runTrip_back','linesOfTrip','newTripSeats'));
    }


    /*** save_ticket_back ***/
    public function save_ticket_back_closed(Request $request)
    {


        $old_ticket = ReservationBookingRequest::find($request->old_reservationBookingRequest_id);
        $user = User::findOrFail($old_ticket->user_id);

        if (!$request->seatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }






        /*  التذكرة ذهاب فقط */
        if ($old_ticket->passenger_type == 1) // egyptian ==>  priceGo
        {
            for ($i=0; $i<count($request->seatId); $i++)
            {
                $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
                $arr[] = "$getPriceGoOfDegree";
                $degrees[] = $getPriceGoOfDegree;
            }

            $newArr = array_count_values($arr);

            foreach ($newArr as $key=>$value)
            {
                $multiply = $key * $value;

                $arrMultiply[] = $multiply;
            }

            $total = array_sum($arrMultiply);

            $wallet = 0;


        }
        else{ // foreign ==>  priceForeignerGo

            for ($i=0; $i<count($request->seatId); $i++)
            {
                $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id; //1
                $getPriceForeignerGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceForeignerGo;
                $arr[] = "$getPriceForeignerGoOfDegree";
                $degrees[] = $getPriceForeignerGoOfDegree;
            }

            $newArr = array_count_values($arr);

            foreach ($newArr as $key=>$value)
            {
                $multiply = $key * $value;

                $arrMultiply[] = $multiply;
            }

            $total = array_sum($arrMultiply);

            $wallet = 0;
        }
        /*  التذكرة ذهاب فقط */



        // no coupons
        $total_discount_booking = 0; // no coupons
        $sub_total_booking = $old_ticket->sub_total; // no coupons

        for ($i=0; $i<count($request->seatId); $i++)
        {
            $sub_total_seat[] = $degrees[$i];
        }




        // make new ticket
        $reservationBookingRequest = new ReservationBookingRequest();
        $reservationBookingRequest->runTrip_id = $request['runTrip_id'];
        $reservationBookingRequest->trip_id = $request['tripData_id'];
        $reservationBookingRequest->go_ticket_id = $old_ticket->id;
        $reservationBookingRequest->user_id = $old_ticket->user_id;
        $reservationBookingRequest->stationFrom_id = $request['stationFrom_id'];
        $reservationBookingRequest->stationTo_id = $request['stationTo_id'];
        $reservationBookingRequest->total = $total;
        $reservationBookingRequest->discount = $total_discount_booking;
        $reservationBookingRequest->sub_total = $sub_total_booking;
        $reservationBookingRequest->wallet = $wallet;
        $reservationBookingRequest->type = 1;  // التذكرة ذهاب فقط
        $reservationBookingRequest->passenger_type = $old_ticket->passenger_type;
        $reservationBookingRequest->admin_id = auth('admin')->id();
        $reservationBookingRequest->office_id = auth('admin')->user()->office_id;
        $reservationBookingRequest->active = 1;
        $reservationBookingRequest->save();


        // update old ticket
        $old_ticket->go_ticket_id = $reservationBookingRequest->id;
        $old_ticket->update();



        /* عشان ال trip_station من خلال ال ( request['stationFrom_id']  &&  $request['stationTo_id']$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationFrom_id'])->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationTo_id'])->first()->id;



        // create booking seats
        for ($i=0; $i<count($request->seatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $reservationBookingRequest->id;
            $bookingSeats->runTrip_id = $request['runTrip_id'];
            $bookingSeats->seat_id = $request->seatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $sub_total_seat[$i];
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }


        if ($request->pay_money > 0 )
        {
            // create trigger
            $les = new Les();
            $les->amount = $request->pay_money;
            $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $les->amount . ' جنيها ';
            $les->type = 1;
            $les->ticket_id = $reservationBookingRequest->id;
            $les->admin_id = auth('admin')->id();
            $les->office_id =  auth('admin')->user()->office_id;
            $les->active = 1;
            $les->save();
        }



        // update user_wallet
        $user->wallet = $user->wallet - $old_ticket->sub_total;
        $user->update();


        $reservationBookingRequest_id = $reservationBookingRequest->id;
//        $paid_user = $les->amount;

        return redirect()->route('reservationBookingRequests.getTicketDesign',$reservationBookingRequest_id);
    }


    /*** ticket_road page ***/
    public function ticket_road(Request $request)
    {
//        return $request;
        $tripData = TripData::findOrFail($request->tripData_id);
        $tripDegrees = $tripData->tripDegrees;
        $linesOfTrip = Line::where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->get();
        $tripSeats = TripSeat::where('tripData_id',$request->tripData_id)->get();
        $busType = BusType::findOrFail($tripData->busType->id);
        return view('pages.ReservationBookingRequests.ticketRoad.ticketRoad',compact('request','tripDegrees','tripData','tripSeats','busType','linesOfTrip'));
    }



    /*** save_ticket_road ***/
    public function save_ticket_road(Request $request)
    {
//        return $request;
        if (!$request->seatId){
            return redirect()->back()->with('alert-danger','برجاء اختيار مقعد');
        }



        $trip_type = 3; // road booking
        $passenger_type = 1;  // egyptian

        for ($i=0; $i<count($request->seatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->seatId[$i])->where('tripData_id',$request->tripData_id)->first()->degree->id; //1
            $getPriceGoOfDegree  = Line::where('degree_id',$getDegree)->where('tripData_id',$request->tripData_id)->where('from_id',$request->stationFrom_id)->where('to_id',$request->stationTo_id)->first()->priceGo;
            $arr[] = "$getPriceGoOfDegree";
            $degrees[] = $getPriceGoOfDegree;
        }

        $newArr = array_count_values($arr);

        foreach ($newArr as $key=>$value)
        {
            $multiply = $key * $value;

            $arrMultiply[] = $multiply;
        }
        $total = array_sum($arrMultiply);
        $wallet = 0;




        // no coupons
        $total_discount_booking = 0; // no coupons
        $sub_total_booking = $request->save_ticket_road ;
        $sub_total_seat =($sub_total_booking / count($request->seatId));




        // make new ticket
        $reservationBookingRequest = new ReservationBookingRequest();
        $reservationBookingRequest->runTrip_id = $request['runTrip_id'];
        $reservationBookingRequest->trip_id = $request['tripData_id'];
        $reservationBookingRequest->stationFrom_id = $request['stationFrom_id'];
        $reservationBookingRequest->stationTo_id = $request['stationTo_id'];
        $reservationBookingRequest->total = $total;
        $reservationBookingRequest->discount = $total_discount_booking;
        $reservationBookingRequest->sub_total = $sub_total_booking;
        $reservationBookingRequest->wallet = $wallet;
        $reservationBookingRequest->type = $trip_type;
        $reservationBookingRequest->passenger_type = $passenger_type;
        $reservationBookingRequest->admin_id = auth('admin')->id();
        $reservationBookingRequest->office_id =  auth('admin')->user()->office_id;
        $reservationBookingRequest->active = 1;
        $reservationBookingRequest->save();




        /* عشان ال trip_station من خلال ال ( request['stationFrom_id']  &&  $request['stationTo_id']$ ) عشان لما اجي ابحث عن الخطوط في search_for_lines */
        $trip_station_from_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationFrom_id'])->first()->id;
        $trip_station_to_id = TripStation::where('tripData_id',$request['tripData_id'])->where('station_id',$request['stationTo_id'])->first()->id;



        // create booking seats
        for ($i=0; $i<count($request->seatId); $i++)
        {
            $getDegree = TripSeat::where('id',$request->seatId[$i])->first()->degree->id;

            $bookingSeats = new BookingSeat();
            $bookingSeats->booking_id = $reservationBookingRequest->id;
            $bookingSeats->runTrip_id = $request['runTrip_id'];
            $bookingSeats->seat_id = $request->seatId[$i];
            $bookingSeats->tripStationFrom_id = $trip_station_from_id;
            $bookingSeats->tripStationTo_id = $trip_station_to_id;
            $bookingSeats->degree_id = $getDegree;
            $bookingSeats->office_id =  auth('admin')->user()->office_id;
            $bookingSeats->city_id = auth('admin')->user()->office->station->city_id;
            $bookingSeats->total =  $degrees[$i];
            $bookingSeats->sub_total =  $sub_total_seat;
            $bookingSeats->admin_id = auth('admin')->id();
            $bookingSeats->active = 1;
            $bookingSeats->save();
        }


        // create trigger
        $les = new Les();
        $les->amount = $sub_total_booking;
        $les->type = 1;
        $les->ticket_id = $reservationBookingRequest->id;
        $les->action =  ' تم حجز عدد مقاعد '. count($request->seatId) .' التابعة للتذكرة رقم '. $reservationBookingRequest->id  .' وقام العميل بدفع مبلغ قدره ' . $sub_total_booking . ' جنيها ';
        $les->admin_id = auth('admin')->id();
        $les->office_id =  auth('admin')->user()->office_id;
        $les->active = 1;
        $les->save();



        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');

//        $reservationBookingRequest_id = $reservationBookingRequest->id;

//        return redirect()->route('reservationBookingRequests.getTicketDesign',$reservationBookingRequest_id);
    }



    /*** print_tabloh ***/
    public function print_tabloh(Request $request)
    {
        // all trip_seats
        $trip_seats = TripSeat::where('tripData_id',$request->tripData_id)->get();

        // only booked seats
        $get_booking_seats = BookingSeat::whereHas('reservationBooking',function($q) use ($request){
              $q->where('stationFrom_id','=',$request->stationFrom_id)->where('stationTo_id','=',$request->stationTo_id)
                ->where('runTrip_id','=',$request->runTrip_id)->where('trip_id','=',$request->tripData_id);
        });


        // get only booked seats
        $booking_seats = $get_booking_seats->get();

        // sub_total of booked seats
        $booking_seats_sub_total = $get_booking_seats->sum('sub_total');

        $run_trip = RunTrip::find($request->runTrip_id);

        $trip_data = TripData::find($request->tripData_id);

        $station_from = Station::find($request->stationFrom_id);

        $station_to = Station::find($request->stationTo_id);

        $bus = Bus::find($request->bus_id);

        $driver = Driver::find($request->driver_id);

        $extra_driver = Driver::find($request->extra_driver_id);

        $host = Admin::find($request->host_id);

        $company_arabic_name = $this->company_arabic_name;
        $company_english_name = $this->company_english_name;

        return view('pages.ReservationBookingRequests.print_tabloh_page',compact('booking_seats','trip_seats','booking_seats_sub_total','run_trip','trip_data','station_from','station_to','bus','driver','extra_driver','host','request','company_arabic_name','company_english_name'));

    }



    /*** print_noulon ***/
    public function print_noulon(Request $request)
    {
//        return $request;


          $get_shippings = Shipping::whereHas('runTrip',function($q1) use ($request){

                $q1->where('id',$request->runTrip_id)->whereHas('tripData',function($q2) use($request){

                    $q2->where('id',$request->tripData_id);
                });
          })->where('from_station_id',$request->stationFrom_id)->where('to_station_id',$request->stationTo_id);



        $shippings = $get_shippings->get();

        // sub_total of shippings
        $shippings_sub_total = $get_shippings->sum('price');

        $run_trip = RunTrip::find($request->runTrip_id);

        $trip_data = TripData::find($request->tripData_id);

        $station_from = Station::find($request->stationFrom_id);

        $station_to = Station::find($request->stationTo_id);

        $bus = Bus::find($request->bus_id);

        $driver = Driver::find($request->driver_id);



        return view('pages.ReservationBookingRequests.print_noloun_page',compact('shippings','shippings_sub_total','run_trip','trip_data','station_from','station_to','bus','driver','request'));

    }



} //end of class
