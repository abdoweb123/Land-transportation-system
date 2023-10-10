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
        .calc_title{font-weight:bold}
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
                                    <div class="row">
                                        <div class="col">
                                            <label class="d-block mt-3">اسم العميل</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="username" value="@isset($user) {{$user->name}} @endisset" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="d-block mt-3">المبلغ المتبقي بالمحفظة</label>
                                            <div class="row">
                                                <div class="col">
                                                    @if($request->payment_method == 1)
                                                        <input type="text" name="remain_in_wallet" value="{{$user->wallet}}" class="form-control" readonly>
                                                        @else
                                                            @if( $sub_total_booking >= $user->wallet)
                                                                <input type="text" name="remain_in_wallet" value="0" class="form-control" readonly>
                                                            @else
                                                                <input type="text" name="remain_in_wallet" value="{{$user->wallet - $sub_total_booking}}" class="form-control" readonly>
                                                            @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form class="inside" action="{{route('reservationBookingRequests.saveData')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <input type="hidden" name="runTripBack" value="{{$request->runTripBack}}">
                                        <input type="hidden" name="runTrip_id" value="{{$request->runTrip_id}}">
                                        <input type="hidden" name="tripData_id" value="{{$request->tripData_id}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$request->stationFrom_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$request->stationTo_id}}">
                                        <input type="hidden" name="trip_type" value="{{$request->trip_type}}">
                                        <input type="hidden" name="passenger_type" value="{{$request->passenger_type}}">
                                        <input type="hidden" name="coupon_id" value="{{$request->coupon_id}}">
                                        <input type="hidden" name="address" value="{{$request->address}}">
                                        <input type="hidden" name="payment_method" value="{{$request->payment_method}}">
                                        @if($request->payment_method == 1)
                                            <input type="hidden" name="remain_in_wallet" value="{{$user->wallet}}" class="form-control" readonly>
                                        @else
                                            @if( $sub_total_booking == $user->wallet)
                                                <input type="hidden" name="remain_in_wallet" value="0" class="form-control" readonly>
                                                <input type="hidden" name="paid_from_wallet" value="{{$user->wallet}}" class="form-control" readonly>
                                            @elseif($sub_total_booking > $user->wallet)
                                                <input type="hidden" name="remain_in_wallet" value="0" class="form-control" readonly>
                                                <input type="hidden" name="paid_from_wallet" value="{{$user->wallet}}" class="form-control" readonly>
                                            @else
                                                <input type="hidden" name="remain_in_wallet" value="{{$user->wallet - $sub_total_booking}}" class="form-control" readonly>
                                                <input type="hidden" name="paid_from_wallet" value="{{$sub_total_booking}}" class="form-control" readonly>
                                            @endif
                                        @endif
                                        @isset($request->use_package)
                                            <input type="hidden" name="use_package" value="{{$request->use_package}}">
                                        @endisset
                                        <div class="row mt-4">
                                            <div class="col">
                                                <label class="d-block mb-3">نوع الرحلة</label>
                                                <input type="text" value="@if($request->trip_type == 1) ذهاب @elseif($request->trip_type == 2) ذهاب وعودة   @else ذهاب وعودة مفتوحة@endif" class="form-control" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="d-block mb-3">نوع الراكب</label>
                                                <input type="text" value="{{$request->passenger_type == 1 ? 'مصري' : 'أجنبي'}}" class="form-control" readonly>
                                            </div>
                                        </div>


                                        <div class="row mt-4">
                                            @isset($coupon->code)
                                            <div class="col">
                                                <label for="city_id" class="mr-sm-2">الكوبون :</label>
                                                <input type="text"  value="{{$coupon->code}}" class="form-control" readonly>
                                            </div>
                                            @endisset
                                            <div class="col">
                                                <label for="city_id" class="mr-sm-2">العنوان :</label>
                                                <input type="text"  value="{{$request->address}}" class="form-control" readonly>
                                            </div>
                                                @isset($request->book_for_other)  <input type="hidden" name="book_for_other" value="{{$request->book_for_other}}">@endisset
                                        </div>


                                        <div class="row mt-4">
                                            <div class="col row">
                                                <div class="col total">
                                                    <p class="calc_title">الإجمالي</p>
                                                    <p>{{$total}}</p>
                                                </div>
                                                <div class="col">
                                                    <p class="calc_title">الخصم</p>
                                                    <p>{{$total_discount_booking}}</p>
                                                </div>
                                            </div>
                                            <div class="col row">
                                                <div class="col sub_total">
                                                    <p class="calc_title sub_total">المطلوب دفعه</p>
                                                    @if($request->payment_method == 1)
                                                        <p>{{$sub_total_booking}}</p>
                                                        <input type="hidden" value="{{$sub_total_booking}}">
                                                    @else
                                                        @if($sub_total_booking > $user->wallet)
                                                            <p>{{$sub_total_booking - $user->wallet}}</p>
                                                            <input type="hidden" value="{{$sub_total_booking - $user->wallet }}">
                                                        @else
                                                            <p>0</p>
                                                            <input type="hidden" value="0">
                                                        @endif
                                                    @endif


                                                </div>
                                                <div class="col">
                                                    <p class="calc_title sub_total">وسيلة الدفع</p>
                                                    <p>{{$request->payment_method == 1 ? 'كاش' : 'محفظة'}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col paid">
                                                <label  class="mr-sm-2">المدفوع :</label>
                                                @if($request->payment_method == 1)
                                                    <input type="text" name="paid_cash" class="form-control" required>
                                                @else
                                                    @if($sub_total_booking > $user->wallet)
                                                        <input type="text" name="paid_cash" class="form-control" required>
                                                    @elseif($sub_total_booking == $user->wallet)
                                                        <input type="text" name="paid_cash" value="0" class="form-control" readonly>
                                                    @else
                                                        <input type="text" name="paid_cash" value="0" class="form-control" readonly>
                                                    @endif
                                                @endif

                                            </div>
                                            <div class="col remain">
                                                <label  class="mr-sm-2">المتبقي :</label>
                                                @if($request->payment_method == 1)
                                                    <input type="text" name="remain" class="form-control" readonly>
                                                @else
                                                    @if($sub_total_booking > $user->wallet)
                                                        <input type="text" name="remain" class="form-control" readonly>
                                                    @elseif($sub_total_booking == $user->wallet)
                                                        <input type="text" name="remain" value="0" class="form-control" readonly>
                                                    @else
                                                        <input type="text" name="remain" class="form-control" value="0" readonly>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                            @isset($newTripSeats)
                                                @foreach($newTripSeats as $newTripSeat)
                                                    <input type="hidden" name="seatId[]" value="{{$newTripSeat}}">
                                                @endforeach
                                            @endisset
                                        <div class="row mt-4">
                                            <div class="col-6">
                                                <button type="submit" class="button mt-4">تأكيد الحجز</button>
                                            </div>
                                        </div>

                                    </form>
                                    <?php
                                    $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id',$request->stationFrom_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id',$request->stationTo_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    ?>
                                </div>
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">
                                    <h3 style="font-family: 'Cairo', sans-serif;">حجز مقعد </h3>
                                    <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                        @foreach($tripSeats as $item)
                                            <div class="bookSeat @isset($newTripSeats)
                                            @foreach($newTripSeats as $newTripSeat)
                                            @if($newTripSeat == $item->id)
                                                bookSeatColor
                                            @endif
                                            @endforeach
                                            @endisset" style="cursor:pointer;
                                                @if($item->bookingSeats)
                                                    @foreach($item->bookingSeats as $subItem)
                                                    @if($subItem->runTrip_id == $request->runTrip_id)
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
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);



            // $('.bookSeat div').on('click',function (){
            //
            //     let old_color =  $(this).parent().css('background-color');
            //     let old_id =  $(this).attr('id');
            //
            //     if ( old_color === 'rgb(0, 128, 0)')
            //     {
            //         $(this).parent().toggleClass('bookSeatColorBack');
            //         $('input[value="'+ old_id +'"][type="hidden"]').remove();
            //     }
            //
            //     $(this).parent().toggleClass('bookSeatColor');
            //
            //     let id =  $(this).attr('id');
            //
            //     let color =  $(this).parent().css('background-color');
            //
            //     let divClass =  $(this).attr('class');
            //
            //
            //
            //     if (color === 'rgb(0, 128, 0)')
            //     {
            //         $('.inside').append('<input type="hidden" name="NewSeatId[]" value="'+ id +'">');
            //     }
            //
            //
            //     else {
            //         $('input[value="'+ id +'"][type="hidden"]').remove();
            //     }
            //
            //
            // });



            $('.paid input').on('keyup', function (){
                $('.remain input').val($('.paid input').val() - $('.sub_total input').val());
                if ($('.paid input').val() == 0)
                {
                    $('.remain input').val(0);
                }
            });






        }); //end of document
    </script>
@endsection


{{--<label class="d-block mt-3">اسم العميل</label>--}}
{{--<div class="row">--}}
{{--    <div class="col">--}}
{{--        <input type="text" name="username" value="@isset($user) {{$user->name}} @endisset" class="form-control" readonly>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<label class="d-block mt-3">المبلغ الموجود بالمحفظة</label>--}}
{{--<div class="row">--}}
{{--    <div class="col">--}}
{{--        <input type="text" name="username" value="{{$user->wallet}}" class="form-control" readonly>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</form>--}}
{{--@isset($calc_request)--}}
{{--    <form class="inside" action="{{route('reservationBookingRequests.saveData')}}" method="post" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        @else--}}
{{--            <form class="inside" action="{{route('reservationBookingRequests.calc_booking')}}" method="post" enctype="multipart/form-data">--}}
{{--                @csrf--}}
{{--                @endisset--}}
{{--                <input type="hidden" name="user_id" value="@isset($user){{$user->id}}@else @isset($newUser){{$newUser->id}}@endisset @endisset">--}}
{{--                <input type="hidden" name="runTrip_id" value="{{$request->runTrip_id}}">--}}
{{--                <input type="hidden" name="tripData_id" value="{{$request->tripData_id}}">--}}
{{--                <input type="hidden" name="stationFrom_id" value="{{$request->stationFrom_id}}">--}}
{{--                <input type="hidden" name="stationTo_id" value="{{$request->stationTo_id}}">--}}
{{--                <input type="hidden" name="startDate" value="{{$request->startDate}}">--}}
{{--                <div class="row mt-4">--}}
{{--                    <div class="col">--}}
{{--                        <label class="d-block mb-3">نوع الرحلة</label>--}}
{{--                        <input type="text" value="{{$request->trip_type == 1 ? 'ذهاب' : 'ذهاب وعودة'}}" class="form-control" readonly>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mt-4">--}}
{{--                    <div class="col">--}}
{{--                        <label class="d-block mb-3">نوع الراكب</label>--}}
{{--                        <input type="text" value="{{$request->passenger_type == 1 ? 'ذهاب' : 'ذهاب وعودة'}}" class="form-control" readonly>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="row mt-4">--}}
{{--                    <div class="col">--}}
{{--                        <label for="city_id" class="mr-sm-2">الكوبون :</label>--}}
{{--                        <input type="text"  value="{{$coupon->code}}" class="form-control" readonly>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mt-4">--}}
{{--                    <div class="col">--}}
{{--                        <label for="city_id" class="mr-sm-2">العنوان :</label>--}}
{{--                        <input type="text"  value="{{$request->address}}" class="form-control" readonly>--}}
{{--                    </div>--}}
{{--                </div>--}}
