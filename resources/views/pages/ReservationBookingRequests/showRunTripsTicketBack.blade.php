@extends('layouts.master')
@section('css')
@section('title')
   عرض الرحلات المتاحة
@stop


<style>
    .process{border:none; border-radius:3px; padding:3px 5px;}
     select{padding:10px !important;}
    .process
    {
        cursor:pointer;
        background-color:white;
        border-radius:3px;
        border: 1px solid #dddd;
        padding: 5px 3px 0 4px;
        margin-left: 2px;
    }
    input[type="date"]{height:45px}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   عرض الرحلات المتاحة
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <?php use Jenssegers\Date\Date;
    Date::setLocale('ar'); ?>
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

                        <form action="{{route('reservationBookingRequests.ticket_back',$old_reservationBookingRequest->id)}}">
                            <div class="row mb-3">
                                <div class="col-3 my-auto">
                                    <input type="date" name="startDate" @isset($request) value="{{$request->startDate}}" @endisset class="form-control" required>
                                </div>
                                <div class="col-3 my-auto">
                                    <input type="date" name="endDate" @isset($request) value="{{$request->endDate}}" @endisset class="form-control" required>
                                </div>
{{--                                <div class="col-2">--}}
{{--                                    <input type="submit" name="search" value="ابحث" class="btn btn-success" style="cursor:pointer">--}}
{{--                                </div>--}}
                                <div class="col-2 my-auto">
                                    <input type="submit" value="ابحث" class="btn btn-success form-control main_color" style="color: white; font-size: 16px; padding:12px;">
                                </div>
                            </div>
                        </form>



                        <div class="table-responsive">
                        <table class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>الكود</th>
                                <th>اسم الرحلة</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>محطة الانطلاق</th>
                                <th>محطة الوصول</th>
                                <th>المقاعد المتاحة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($get_run_trips)
                            @foreach ($get_run_trips as $item)
                                {{-- عشان نجيب المقاعد المشغولة --}}
                                <?php
                                $count_busy_seats = 0;

                                $arr_busy_seats = null;
                                unset($arr_busy_seats);

                                $array_same_seat = null;
                                unset($array_same_seat);

                                /* عشان نجيب ال rank بتاع ال request->stationFrom_id */
                                $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id', $old_reservationBookingRequest->stationTo_id)->where('tripData_id', $item->tripData_id)->first()->rank;
                                $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id', $old_reservationBookingRequest->stationFrom_id)->where('tripData_id', $item->tripData_id)->first()->rank;


                                $bookingSeats = App\Models\BookingSeat::where('runTrip_id',$item->id)->get();

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
                                $aviliable_trip_seats = \App\Models\TripSeat::where('tripData_id',$item->tripData_id)->whereHas('seat',function ($q) use($item){
                                    $q->where('type',1);
                                })->count();

                                ?>
                                {{-- اظهر له الرحلات في حالة لو المقاعد المتبقية المتاحة للحجز > 0 او لو الفلتر موجود --}}
                                @if($aviliable_trip_seats - $count_busy_seats > 0)

                                    <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>@isset($item->tripData->name)  {{ $item->tripData->name }} @else _____ @endisset</td>
                                    <td> {{ $item->startDate }}</td>
                                    <td> {{date("g:iA", strtotime($item->startTime))}}</td>
                                    <td>{{$old_reservationBookingRequest->stationTo->name}}</td>
                                    <td>{{$old_reservationBookingRequest->stationFrom->name}}</td>
                                        {{-- عشان نجيب المقاعد المتبقية المتاحة للحجز --}}
                                    <td>{{$aviliable_trip_seats - $count_busy_seats}}</td>
                                    <td>
                                        <form action="{{route('reservationBookingRequests.chooseSeats_ticketBack')}}" method="get" class="d-inline-block" enctype="multipart/form-data">
                                            @csrf
                                        <input type="hidden" name="runTrip_id" value="{{$item->id}}">
                                        <input type="hidden" name="tripData_id" value="{{$item->tripData_id}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$old_reservationBookingRequest->stationTo_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$old_reservationBookingRequest->stationFrom_id}}">
                                        <input type="hidden" name="old_reservationBookingRequest" value="{{$old_reservationBookingRequest->id}}">

                                        <button type="submit" class="btn btn-success">
                                            <i style="color:white; font-size:18px;" class="ti-ticket"></i>&nbsp; حجز </button>

                                        </form>
                                    </td>
                                </tr>
                            @endif

                            @endforeach
                            @endisset
                        </table>
                        @isset($get_run_trips)
                        <div> {{$get_run_trips->links('pagination::bootstrap-4')}}</div>
                         @endisset
                    </div>
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
        });
    </script>
@endsection




