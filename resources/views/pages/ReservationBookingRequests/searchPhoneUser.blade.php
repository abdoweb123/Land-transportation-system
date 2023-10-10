@extends('layouts.master')
@section('css')
@section('title')
        حجز مقعد
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
        label{font-weight:bold}
        .related_runTrips{display:none}
    </style>
@section('PageTitle')
    حجز مقعد
@stop

@endsection

@section('style')
    <style>
        .table td{padding: 8px;}
    </style>
@endsection


@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    @foreach(['danger','warning','success','info'] as $msg)
                        @if(Session::has('alert-'.$msg))
                            <div class="alert alert-{{$msg}}">
                                {{Session::get('alert-'.$msg)}}
                            </div>
                        @endif
                    @endforeach


                    <br><br>


                    <!-- Start bus design and edit seats-->
                    @if(!$tripSeats->isEmpty())
                        @if(count($tripSeats) == count($tripSeats))  <!-- عدد مقاعد الرحلة = عدد مقاعد الأسطول التي تتبع له الرحلة -->
                             <div class="row">
                                <div class="col-md-6" style="border-left:2px solid #ddd">
                                    <form action="{{route('reservationBookingRequests.searchUserPhone')}}" method="get" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="runTrip_id" value="{{$newRequest->runTrip_id}}">
                                        <input type="hidden" name="tripData_id" value="{{$newRequest->tripData_id}}">
                                        <input type="hidden" name="tripData_name" value="{{$newRequest->tripData_name}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$newRequest->stationFrom_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$newRequest->stationTo_id}}">
                                        <input type="hidden" name="startDate" value="{{$newRequest->startDate}}">

                                        <label class="d-block">ادخل رقم الهاتف :</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" name="searchUserPhone" value="@isset($newRequest->searchUserPhone) {{$newRequest->searchUserPhone}} @else @isset($newUser) {{$newUser->mobile}} @endisset @endisset" class="form-control">
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" class="button" style="width: 100%; padding:11px 0;">ابحث</button>
                                            </div>
                                        </div>
                                        <label class="d-block mt-3">اسم العميل :</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" name="username" value="@isset($user) {{$user->name}} @else @isset($newUser) {{$newUser->name}} @endisset @endisset" class="form-control" readonly>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="button" data-toggle="modal" data-target="#exampleModal" style="padding:11px 0; width:100%;">
                                                    إضافة عميل جديد
                                                </button>
                                            </div>
                                        </div>
                                        @isset($user)
                                            <label class="d-block mt-3">المبلغ الموجود بالمحفظة :</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="username" value="{{$user->wallet}}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        @else
                                            @isset($newUser)
                                                <label class="d-block mt-3">المبلغ الموجود بالمحفظة :</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" name="username" value="{{$newUser->wallet}}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            @endisset
                                        @endisset
                                    </form>
                                    @isset($calc_request)
                                        <form class="inside" action="{{route('reservationBookingRequests.saveData')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                    @else
                                        <form class="inside" action="{{route('reservationBookingRequests.calc_booking')}}" method="get" enctype="multipart/form-data">
                                        @csrf
                                    @endisset
                                        <input type="hidden" name="user_id" value="@isset($user){{$user->id}}@else @isset($newUser){{$newUser->id}}@endisset @endisset" required>
                                        <input type="hidden" name="runTrip_id" value="{{$newRequest->runTrip_id}}">
                                        <input type="hidden" name="tripData_id" value="{{$newRequest->tripData_id}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$newRequest->stationFrom_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$newRequest->stationTo_id}}">
                                        <input type="hidden" name="startDate" value="{{$newRequest->startDate}}">
                                        <div class="row mt-4">
                                            @if($runTrip->type == 2)
                                                <div class="col-3">
                                                    <label class="d-block">نوع الرحلة :</label>
                                                    <div class="type-div type_go">
                                                        <input type="radio" name="trip_type" value="1" required style="margin-left:3px">ذهاب
                                                    </div>
                                                    @if(count($related_runTrips) > 0)
                                                    <div class="type-div type_go_back">
                                                        <input type="radio" name="trip_type" value="2" required style="margin-left:3px">ذهاب وعودة
                                                    </div>
                                                    @endif
                                                    <div class="type-div type_go_back_open">
                                                        <input type="radio" name="trip_type" value="4" required style="margin-left:3px">ذهاب وعودة مفتوحة
                                                    </div>
                                                </div>
                                            @endisset

                                            <div class="col-3">
                                                <label class="d-block">نوع الراكب :</label>
{{--                                                <div class="row">--}}
                                                    <div class="type-div">
                                                        <input type="radio" name="passenger_type" value="1" required style="margin-left:3px">مصري
                                                    </div>
                                                    <div class="type-div">
                                                        <input type="radio" name="passenger_type" value="2" required style="margin-left:3px">أجنبي
                                                    </div>
{{--                                                </div>--}}
                                            </div>
                                            <div class="col-6">
                                               <div class="row">
                                                   <div class="col">
                                                       <label class="mb-3"></label> <input type="checkbox" name="book_for_other" style="margin-left:3px"> حجز للغير
                                                   </div>
                                               </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mx-1 table-responsive">
                                            <div class="related_runTrips">
                                                <table id="datatable" class="table table-sm table-bordered p-0" data-page-length="50"
                                                       style="text-align: center">
                                                    <tr>
                                                        <th>الكود</th>
                                                        <th>اسم الرحلة</th>
                                                        <th>التاريخ</th>
                                                        <th>الوقت</th>
                                                        <th>محطة الانطلاق</th>
                                                        <th>محطة الوصول</th>
                                                        <th>المقاعد المتاحة</th>
                                                        <th>اختيار</th>
                                                    </tr>
                                                    @isset($related_runTrips)
                                                        @foreach($related_runTrips as $runTrip_back)
                                                            {{-- عشان نجيب المقاعد المشغولة --}}
                                                            <?php
                                                            $count_busy_seats = 0;

                                                            $arr_busy_seats = null;
                                                            unset($arr_busy_seats);

                                                            $array_same_seat = null;
                                                            unset($array_same_seat);

                                                            /* عشان نجيب ال rank بتاع ال request->stationFrom_id */
                                                            $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id', $newRequest->stationTo_id)->where('tripData_id', $runTrip->tripData_id)->first()->rank;
                                                            $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id', $newRequest->stationFrom_id)->where('tripData_id', $runTrip->tripData_id)->first()->rank;


                                                            $bookingSeats = App\Models\BookingSeat::where('runTrip_id',$runTrip_back->runTrip_back->id)->get();

                                                            foreach ($bookingSeats as $bookingSeat) {

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


                                                            /* عشان لو نفس الكرسي محجوز اكثر من مرة بين محطتين مختلفتين ميعدهمش مرتين */
                                                            for ($i=0; $i<count($arr_busy_seats); $i++)
                                                            {
                                                                $array_same_seat[] = $arr_busy_seats[$i]->seat_id;
                                                            }

                                                            /* عشان لو ملقاش عناصر يرجع لي array فاضية وميحصلش error */
                                                            if (!isset($array_same_seat)){
                                                                $array_same_seat = [];
                                                            }

                                                            $count_busy_seats =  count(array_unique($array_same_seat));



                                                            /*  عشان نجيب المقاعد الكلية المتاحة للحجز (عدد كراسي الأتوبيس حيث ال type == 1) */
                                                            $aviliable_trip_seats = \App\Models\TripSeat::where('tripData_id',$runTrip_back->runTrip_back->tripData_id)->whereHas('seat',function ($q) use($runTrip_back){
                                                                $q->where('type',1);
                                                            })->count();

                                                            ?>
                                                           @if($aviliable_trip_seats - $count_busy_seats > 0)
                                                            <tr>
                                                                <th>{{$runTrip_back->runTrip_back_id}}</th>
                                                                <th>{{$runTrip_back->runTrip_back->tripData->name}}</th>
                                                                <th>{{$runTrip_back->runTrip_back->startDate}}</th>
                                                                <th>{{date("g:iA", strtotime($runTrip_back->runTrip_back->startTime))}}</th>
                                                                <th>{{$stationTo->name}}</th>
                                                                <th>{{$stationFrom->name}}</th>
                                                                <th>{{$aviliable_trip_seats - $count_busy_seats}}</th>
                                                                <th><input type="radio" name="runTripBack" value="{{$runTrip_back->runTrip_back_id}}"></th>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    @endisset
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class="col-3">
                                                <label class="d-block">وسيلة الدفع :</label>
                                                @foreach($paymentMethodsTrip as $paymentMethodTrip)
                                                    <div class="type-div">
                                                        <input type="radio" name="payment_method" value="{{$paymentMethodTrip->paymentMethod_id}}" style="margin-left:3px"> @if($paymentMethodTrip->paymentMethod_id == 1) كاش @elseif($paymentMethodTrip->paymentMethod_id == 2) محفظة @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($booked_package !== null)
                                                @if($booked_package->package->stationFrom_id == $newRequest->stationFrom_id && $booked_package->package->stationTo_id == $newRequest->stationTo_id && $booked_package->used < $booked_package->package->max_trips && $booked_package->package->type == $runTrip->type)
                                                    <div class="col-3">
                                                        <label class="mb-3"> </label> <input type="checkbox" name="use_package" value="{{$booked_package->id}}" style="margin-left:3px"> استخدام الاشتراك
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col">
                                                <label for="city_id" class="mr-sm-2">اختر كوبون :</label>
                                                <select class="form-control mr-sm-2 p-2" name="coupon_id">
                                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                                    @foreach($coupons as $coupon)
                                                        <option value="{{$coupon->id}}">{{ $coupon->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <label for="city_id" class="mr-sm-2">العنوان :</label>
                                                <textarea class="form-control" rows="6" name="address"></textarea>
                                            </div>
                                        </div>
                                        @isset($calc_request)

                                             {{$total}}     {{$total_discount_booking}}   {{$sub_total_booking}}
                                             <div class="row mt-4">
                                                <div class="col-6">
                                                    <button type="submit" class="button mt-4">تأكيد الحجز</button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <button type="submit" class="button" style="width: 100%; padding:11px 0;">حساب الحجز</button>
                                                </div>
                                            </div>
                                        @endisset
                                    </form>

                                    <?php
                                    $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id',$newRequest->stationFrom_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id',$newRequest->stationTo_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    ?>

                                </div>
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">
                                    <h3 style="font-family: 'Cairo', sans-serif;">حجز مقعد </h3>
                                    <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                        @foreach($tripSeats as $item)
                                            <div class="bookSeat" style="cursor:pointer;
                                                @if($item->bookingSeats)
                                                    @foreach($item->bookingSeats as $subItem)
                                                        @if($subItem->runTrip_id == $newRequest->runTrip_id)
{{--                                                        @if(($subItem->reservationBooking->stationFrom_id == $newRequest->stationFrom_id && $subItem->reservationBooking->stationTo_id == $newRequest->stationTo_id))--}}
                                                        @if(
                                                            ($subItem->tripStationFrom->rank == $request_of_trip_station_from_rank && $subItem->tripStationTo->rank == $request_of_trip_station_to_rank)
                                                            ||
                                                            ($subItem->tripStationTo->rank > $request_of_trip_station_to_rank && $subItem->tripStationFrom->rank == $request_of_trip_station_from_rank)
                                                            ||
                                                            ($subItem->tripStationFrom->rank < $request_of_trip_station_from_rank && $subItem->tripStationTo->rank == $request_of_trip_station_to_rank)
                                                            ||
                                                            ($subItem->tripStationFrom->rank < $request_of_trip_station_from_rank && $subItem->tripStationTo->rank > $request_of_trip_station_to_rank)
                                                            ||
                                                            ($subItem->tripStationTo->rank < $request_of_trip_station_to_rank && $subItem->tripStationTo->rank > $request_of_trip_station_from_rank)
                                                            ||
                                                            ($subItem->tripStationFrom->rank < $request_of_trip_station_to_rank && $subItem->tripStationFrom->rank > $request_of_trip_station_from_rank)
                                                            )
                                                            background-color:red !important; color:white;
                                                        @else
                                                            background-color:beige;
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @if($item->seat->type == 3) visibility:hidden; color:white;
                                            @elseif($item->seat->type == 2) visibility:hidden;
                                            @else background-color:beige;  @endif width:100px; height:90px; margin:10px; text-align:center; position:relative;">
                                                <div class="{{$item->degree_id}}" id="{{$item->id}}" style="cursor:pointer; padding:23px 0;">
                                                    <a>
                                                        {{$item->seat->name}}
                                                        <p>{{$item->degree->name}}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="admin_table_details text-left mb-3 pb-2" style=" border-bottom:1px solid #737070;">
                                        <div class="driver_div d-inline-block" style="background-color:beige; width:25px; height:25px; margin-left:4px"></div>
                                        <label style="margin-left:20px">متاح</label>
                                        <div class="driver_div d-inline-block" style="background-color:red; width:25px; height:25px; margin-left:4px"></div>
                                        <label style="margin-left:20px">محجوز</label>
                                        <div class="driver_div d-inline-block" style="background-color:green; width:25px; height:25px; margin-left:4px"></div>
                                        <label style="margin-left:20px">محدد</label>
                                    </div>
                                    <p class="mt-4 font-weight-bold text-left mb-2"> السعر للمصري</p>
                                    <div class="row mb-3 pb-2" style="text-align:initial;">
                                        @foreach($linesOfTrip as $line)
                                            <div class="col-6 mb-2">
                                                <p>{{$line->degree->name}} (سعر الذهاب)  :   {{$line->priceGo}}</p>
                                                <p>{{$line->degree->name}}  (سعر الذهاب والعودة)  :  {{$line->priceBack}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div style="border-bottom:1px solid #737070; width:80%; margin: auto">
                                    </div>
                                    <p class="mt-4 font-weight-bold text-left mb-2"> السعر للأجنبي</p>
                                     <div class="row" style="text-align:initial">
                                        @foreach($linesOfTrip as $line)
                                            <div class="col-6 mb-2">
                                                <p>{{$line->degree->name}} (سعر الذهاب)  :   {{$line->priceForeignerGo}}</p>
                                                <p>{{$line->degree->name}}  (سعر الذهاب والعودة)  :  {{$line->priceForeignerBack}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <h3 class="text-center">لم يتم تصميم هذه الرحلة بعد!</h3>
                    @endif
                    <!-- End seats information -->
                </div>
            </div>
        </div>


        @include('pages.ReservationBookingRequests.createNewClient')

    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);



            $('.bookSeat div').on('click',function (){

              $(this).parent().toggleClass('bookSeatColor');

              let color =  $(this).parent().css('background-color');

              let id =  $(this).attr('id');

              let divClass =  $(this).attr('class');


              if (color === 'rgb(0, 128, 0)')
              {
                  $('.inside').append('<input type="hidden" name="seatId[]" value="'+ id +'">');
              }
               else {
                    $('input[value="'+ id +'"][type="hidden"]').remove();
              }

            });






            // عشان الذهاب والعودة
            $('.type_go_back input[name="trip_type"]').on("click", function()
            {
                $('.related_runTrips').slideDown();
            });
            // عشان الذهاب والعودة
            $('.type_go_back_open input[name="trip_type"]').on("click", function()
            {
                $('.related_runTrips').slideUp();
            });
            // عشان الذهاب والعودة
            $('.type_go input[name="trip_type"]').on("click", function()
            {
                $('.related_runTrips').slideUp();
            });




        }); //end of document
    </script>
@endsection


