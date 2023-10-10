@extends('layouts.master')
@section('css')
@section('title')
   إضافة حجز
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
    #datatable_filter{display:none}
    .offices_filter,
    .date_filter,
    .station_filter,
    .degree_filter,
    .checkbox_filter,
    .up,
    .search
    {
        /*border-bottom: 1px solid #ddd;*/
        padding: 1rem !important;
        color: white;
    }
    .offices_filter {background: #c04822b8;}
    .date_filter {background: #b1b11182;}
    .station_filter {background: #848420a3;}
    .degree_filter {background: wheat;}
    .checkbox_filter{background: #c04822b8;}
    .search{background: #dbc082d6;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    إضافة حجز
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->


    <div class="row">
        <div class="mb-30" style="width:23%">
            <div class="card card-statistics h-100">
                <form action="{{route('reservationBookingRequests.searchLines')}}" method="get" enctype="multipart/form-data">
                    @csrf
                    @isset($request->old_ticket_id)
                        <input type="hidden" name="old_ticket_id" value="{{$request->old_ticket_id}}">
                    @endisset
                    <div class="offices_filter">
                         <label class="d-block" style="font-weight:bold">المكتب</label>
                         <div class="row">
                             <div class="m-auto text-center" style="width:13%">
                                 <label class="d-block">من</label>
                             </div>
                             <div class="mb-2" style="width:81%; margin-left: 15px;">
                                 <select class="form-control mr-sm-2 p-2" name="from_office_id">
                                     <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                     @foreach($offices as $office)
                                         <option value="{{$office->id}}" {{ $office->id == $request->from_office_id ? 'selected' : ''}}>{{ $office->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                         <div class="row mb-3">
                             <div class="m-auto text-center" style="width:13%">
                                 <label class="d-block">إلى</label>
                             </div>
                             <div class="mb-2" style="width:81%; margin-left: 15px;">
                                 <select class="form-control mr-sm-2 p-2" name="to_office_id">
                                     <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                     @foreach($offices as $office)
                                         <option value="{{$office->id}}" {{ $office->id == $request->to_office_id ? 'selected' : ''}}>{{ $office->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                     </div>
                    <div class="date_filter">
                        <label class="d-block" style="font-weight:bold">التاريخ</label>
                        <div class="row">
                            <div class="m-auto text-center" style="width:13%">
                                <label class="d-block">من</label>
                            </div>
                            <div class="mb-2" style="width:81%; margin-left: 15px;">
                                <input type="date" name="from_date" class="form-control" @isset($request) value="{{$request->from_date}}" @endisset>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="m-auto text-center" style="width:13%">
                                <label class="d-block">إلى</label>
                            </div>
                            <div class="mb-2" style="width:81%; margin-left: 15px;">
                                <input type="date" name="to_date" class="form-control" @isset($request) value="{{$request->to_date}}" @endisset>
                            </div>
                        </div>
                    </div>
                    <div class="station_filter">
                        <label class="d-block" style="font-weight:bold">المنطقة</label>
                        <div class="row">
                            <div class="m-auto text-center" style="width:13%">
                                <label class="d-block">من</label>
                            </div>
                            <div class="mb-2" style="width:81%; margin-left: 15px;">
                                <select class="form-control mr-sm-2 p-2" name="stationFrom_id">
                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                    @foreach($stations as $station)
                                        <option value="{{$station->id}}" {{ $station->id == $request->stationFrom_id ? 'selected' : ''}}>{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="m-auto text-center" style="width:13%">
                                <label class="d-block">إلى</label>
                            </div>
                            <div class="mb-2" style="width:81%; margin-left: 15px;">
                                <select class="form-control mr-sm-2 p-2" name="stationTo_id">
                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                    @foreach($stations as $station)
                                        <option value="{{$station->id}}" {{ $station->id == $request->stationTo_id ? 'selected' : ''}}>{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="degree_filter">
                        <label class="d-block" style="font-weight:bold">نوع الخدمة</label>
                        <div class="row mb-3">
                            <div class="m-auto" style="width:90%; margin-left: 15px;">
                                <select class="form-control mr-sm-2 p-2" name="degree_id">
                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                    @foreach($degrees as $degree)
                                        <option value="{{$degree->id}}" {{ $degree->id == $request->degree_id ? 'selected' : ''}}>{{ $degree->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox_filter">
                        <div class="row mb-3">
                            <div class="m-auto" style="width:90%; margin-left: 15px;">
                                <div class="checkBox mb-1"> {{-- unactive --}}
                                    <input type="checkbox" name="show_unActive_trips" {{$request->show_unActive_trips == 'on' ? 'checked' : '' }} ><span class="mx-1">عرض الرحلات غير المتاحة للحجز</span>
                                </div>
                                <div class="checkBox mb-1"> {{-- canceled --}}
                                    <input type="checkbox" name="show_canceled_trips" {{$request->show_canceled_trips == 'on' ? 'checked' : '' }} ><span class="mx-1">عرض الرحلات الملغية أو المغلقة</span>
                                </div>
                                <div class="checkBox mb-1"> {{-- ($aviliable_trip_seats - $count_busy_seats) == 0 --}}
                                    <input type="checkbox" name="show_completed_tripSeats" {{$request->show_completed_tripSeats == 'on' ? 'checked' : '' }} ><span class="mx-1">عرض الرحلات التي لا يوجد بها مقاعد متاحة للحجز</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search">
                        <input type="submit" value="ابحث" class="btn btn-success form-control main_color" style="color: white; font-size: 16px; padding:12px; margin-top: 5px;">
                    </div>
                </form>
            </div>
        </div>
        <div class="mb-30" style="width:2%">

        </div>
        <div class="mb-30" style="width:75%">
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

{{--                       <div class="up mb-4">--}}
                           <button type="button" class="button x-small" data-toggle="modal" data-target="#print_ticket" style="margin-left:10px">
                               <i class="ti-printer"></i>  طباعة تذكرة
                           </button>

                           <a href="{{route('reservationBookingRequests.editPage')}}" class="button x-small" style="margin-left:10px">
                               <i class="fa fa-edit" style="font-size:16px; margin-left: 7px;"></i>تعديل حجز
                           </a>

                           <button type="button" class="button x-small mb-3" data-toggle="modal" data-target="#search_secret_code" style="margin-left:10px">
                               <i class="ti-search" style="font-size:16px;"></i>     كود سري
                           </button>
{{--                       </div>--}}


                        <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>الكود</th>
                                <th>الرحلة</th>
                                <th>من</th>
                                <th>إلى</th>
                                <th>نوع الرحلة</th>
                                <th>التاريخ</th>
                                <th>الموعد</th>
                                <th>المحجوز</th>
                                <th>المتبقي</th>
                                @if($request->show_unActive_trips == 'on')<th>حالة النشاط</th> @endif
                                @if($request->show_canceled_trips == 'on')<th>الحالة</th> @endif
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($dataAll)
                            @foreach ($dataAll as $item)
                                {{-- عشان نجيب المقاعد المشغولة --}}
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
                                @if($aviliable_trip_seats - $count_busy_seats > 0 || $request->show_completed_tripSeats == 'on')

                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>@isset($item->tripData->name)  {{ $item->tripData->name }} @else _____ @endisset</td>
                                    <td>{{$stationFrom_id->name}}</td>
                                    <td>{{$stationTo_id->name}}</td>
                                    <td>{{ $item->type == 1 ? 'ذهاب' : 'ذهاب وعودة'}}</td>
                                    <td>@isset($item->startDate)  {{ $item->startDate }} @else _____ @endisset</td>
                                    <td>@isset($item->startTime)   {{date("g:iA", strtotime($item->startTime))}} @else _____ @endisset</td>

                                    {{-- عشان نجيب المقاعد المتبقية المتاحة للحجز --}}
                                    <td>{{$count_busy_seats}}</td>
                                    <td>{{$aviliable_trip_seats - $count_busy_seats}}</td>
                                    @if($request->show_unActive_trips == 'on') <td>{{$item->active == 1 ? 'نشط' : 'غير نشط'}}</td>@endif
                                    @if($request->show_canceled_trips == 'on') <td>{{$item->canceled == 1 ? 'ملغي' : 'مفعل'}}</td>@endif
                                    <td>
                                        <form action="{{route('reservationBookingRequests.bookingPage')}}" method="get" class="d-inline-block" enctype="multipart/form-data">
                                            @csrf
                                        <input type="hidden" name="runTrip_id" value="{{$item->id}}">
                                        <input type="hidden" name="tripData_id" value="{{$item->tripData_id}}">
                                        <input type="hidden" name="tripData_name" value="{{$item->name}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$stationFrom_id->id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$stationTo_id->id}}">
                                        <input type="hidden" name="startDate" value="{{$item->startDate}}">

                                        <button type="submit" class="btn btn-success">
                                            <i style="color:white; font-size:18px;" class="ti-ticket"></i>&nbsp; حجز </button>

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
                </div>
            </div>
        </div>
        @include('pages.ReservationBookingRequests.print_ticket.search_ticket_to_print')
        @include('pages.ReservationBookingRequests.search_secret_code')
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




