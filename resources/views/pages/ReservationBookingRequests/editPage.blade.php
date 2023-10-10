@extends('layouts.master')
@section('css')
@section('title')
   تعديل حجز
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        .dataTables_filter{display:none}
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
    </style>
@section('PageTitle')
  تعديل حجز
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

                    <div class="row">
                        <div class="col-md-6" style="/*border-left:2px solid #ddd*/">
                            <form action="{{route('reservationBookingRequests.editPage')}}" method="get" enctype="multipart/form-data">
                                @csrf

                                <label class="d-block">ابحث بكود التذكرة</label>
                                <div class="row">
                                    <div class="col-8">
                                        <input type="text" name="search_Booking" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->id}} @endisset" class="form-control">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="button">ابحث</button>
                                    </div>
                                </div>
                            </form>

                            @isset($reservationBookingRequest)
                                <form class="inside" action="{{route('reservationBookingRequests.changeSeats')}}" method="get" enctype="multipart/form-data">
                                    <div class="row mt-5">
                                        <input type="hidden" name="reservationBookingRequest_id" value="{{$reservationBookingRequest->id}}">
                                        <div class="col-3 m-auto">
                                            <input type="radio" name="trip_type" value="1"> <span style="font-size:15px"> نفس الرحلة</span>
                                        </div>
                                        <div class="col-3 m-auto">
                                            <input type="radio" name="trip_type" value="2"> <span style="font-size:15px">رحلة أخرى</span>
                                        </div>
                                        <div class="col-2 m-auto">
                                            <input type="checkbox" name="cancelFee"> إلغاء
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="button" style="padding: 11px 16px;">التالي</button>
                                        </div>
                                    </div>
{{--                                    <div class="row mt-5">--}}
{{--                                        <div class="col-4 m-auto">--}}
{{--                                            <input type="radio" name="editBooking" value="1"> <span style="font-size:15px">تعديل</span>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-4 m-auto">--}}
{{--                                            <input type="radio" name="cancelBooking" value="2"> <span style="font-size:15px">إلغاء</span>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-4">--}}
{{--                                            <button type="submit" class="button" style="padding: 11px 16px;">التالي</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </form>
                            @endisset


                            @isset($stations)
                                <form action="{{route('reservationBookingRequests.searchLines')}}" method="get" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="reservationBookingRequest_id" value="@isset($reservationBookingRequest){{$reservationBookingRequest->id}}@endisset">
                                    @isset($request)
                                        @foreach($request->seatId as $seat_id)
                                            <input type="hidden" name="seatId[]" value="{{$seat_id}}">
                                        @endforeach
                                    @endisset
                                    <div class="mt-4" style="border-top: 1px solid #ddd; width:85%;">
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2">محطة الانطلاق :</label>
                                            <select class="form-control mr-sm-2 p-2" name="stationFrom_id">
                                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                                @foreach($stations as $station)
                                                    <option value="{{$station->id}}" @isset($request) {{ $station->id == $request->stationFrom_id ? 'selected' : ''}} @endisset>{{ $station->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2">محطة الوصول :</label>
                                            <select class="form-control mr-sm-2 p-2" name="stationTo_id">
                                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                                @foreach($stations as $station)
                                                    <option value="{{$station->id}}" @isset($request) {{ $station->id == $request->stationTo_id ? 'selected' : ''}}@endisset>{{ $station->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2">التاريخ :</label>
                                            <input class="form-control" type="text" name="edit_date" @isset($request) value="{{$request->edit_date}}" @endisset  id="datepicker-action" data-date-format="yyyy-mm-dd" style="padding:13px">
                                        </div>
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2"> </label>
                                            <input type="submit" value="ابحث" class="btn btn-success form-control" style="background-color: #84ba3f; color: white; font-size: 16px; padding:12px; margin-top: 5px;">
                                        </div>
                                    </div>

                                </form>

                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>رقم الرحلة</th>
                                            <th>اسم الرحلة</th>
                                            <th>التاريخ</th>
                                            <th>الوقت</th>
                                            <th>المقاعد المتاحة</th>
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($dataAll)
                                            @foreach ($dataAll as $item)
                                                <?php
                                                $count_busy_seats = 0;

                                                $arr_busy_seats = null;
                                                unset($arr_busy_seats);

                                                $array_same_seat = null;
                                                unset($array_same_seat);

                                                /* عشان نجيب ال rank بتاع ال request->stationFrom_id */
                                                $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id', $request->stationFrom_id)->where('tripData_id', $item->tripData_id)->first()->rank;
                                                $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id', $request->stationTo_id)->where('tripData_id', $item->tripData_id)->first()->rank;


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
                                                @if($aviliable_trip_seats - $count_busy_seats > 0  /* && $item->id != $reservationBookingRequest->runTrip_id */)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>@isset($item->tripData->name)  {{ $item->tripData->name }} @else _____ @endisset</td>
                                                    <td>@isset($item->startDate)  {{ $item->startDate }} @else _____ @endisset</td>
                                                    <td>@isset($item->startTime)   {{date("g:iA", strtotime($item->startTime))}} @else _____ @endisset</td>
                                                    {{-- عشان نجيب المقاعد المتبقية المتاحة للحجز --}}
                                                    <td>{{$aviliable_trip_seats - $count_busy_seats}}</td>
                                                    <td>
                                                        <form action="{{route('reservationBookingRequests.changeSeats')}}" method="get" class="d-inline-block" enctype="multipart/form-data">
                                                            @csrf

                                                            <input type="hidden" name="new_runTrip_id" value="{{$item->id}}">
                                                            <input type="hidden" name="new_tripData_id" value="{{$item->tripData_id}}">
                                                            <input type="hidden" name="stationFrom_id" value="{{$stationFrom_id->id}}">
                                                            <input type="hidden" name="stationTo_id" value="{{$stationTo_id->id}}">
                                                            <input type="hidden" name="startDate" value="{{$item->startDate}}">
                                                            <input type="hidden" name="trip_type" value="2">
                                                            @foreach($request->seatId as $seat_id)
                                                                <input type="hidden" name="seatId[]" value="{{$seat_id}}">
                                                            @endforeach
                                                            <input type="hidden" name="newReservationBookingRequest_id" value="@isset($reservationBookingRequest){{$reservationBookingRequest->id}}@endisset">

                                                            <button type="submit" class="btn btn-success" style="background-color: #84ba3f">
                                                                <i style="color:white; font-size:18px;" class="fa fa-ticket"></i>&nbsp; حجز </button>

                                                        </form>

                                                    </td>
                                                </tr>
                                                @endif
                                                <!--  page of delete_modal_city -->
                                        @include('pages.ReservationBookingRequests.delete')

                                        @endforeach
                                        @endisset
                                    </table>
                                    @isset($dataAll)
                                        <div> {{$dataAll->links('pagination::bootstrap-4')}}</div>
                                    @endisset
                                </div>
                            @endisset

                        </div>
                        <div class="col-md-6 bus_design mx-auto">
                            <div class="row">
                                <div class="col-md-12 mb-30">
                                    <div class="card card-statistics h-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>اسم الرحلة : </label>
                                                        <input  type="text" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->tripData->name}} @endisset" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>كود التشغيل : </label>
                                                        <input  class="form-control" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->runTrip_id}} @endisset" type="text" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>محطة الانطلاق : </label>
                                                        <input  type="text" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->stationFrom->name}} @endisset"  class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>محطة الوصول : </label>
                                                        <input  class="form-control" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->stationTo->name}} @endisset" type="text"  readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>نوع التذكرة : </label>
                                                        <input type="text" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->type == 1 ? 'ذهاب' : 'ذهاب وعودة'}} @endisset"  class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>المبلغ المدفوع : </label>
                                                        <input  class="form-control" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->sub_total}} @endisset" type="text"  readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>عدد المقاعد المحجوزة : </label>
                                                        <input type="text" value="@isset($reservationBookingRequest) {{$reservationBookingRequest->bookingSeats->count()}} @endisset"  class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            @isset($reservationBookingRequest)
                                                <h5 class="mt-3">اختر المقاعد المراد تغييرها</h5>
                                                 <div class="contain">
                                                    @foreach($reservationBookingRequest->bookingSeats as $item)
                                                        <div class="bookSeat d-inline-block" style="cursor:pointer; width:100px; height:90px; margin:10px; text-align:center; position:relative;  background: red; color:white;">
                                                            <div class="{{$item->tripSeat->seat->id}}" id="{{$item->id}}" style="cursor:pointer; padding:23px 0;">
                                                                <a>
                                                                    {{$item->tripSeat->seat->name}}
                                                                    <p>{{$item->degree->name}}</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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


        }); //end of document
    </script>
@endsection


