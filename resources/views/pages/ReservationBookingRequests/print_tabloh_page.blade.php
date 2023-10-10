@extends('layouts.master')
@section('css')
@section('title')
      طباعة التابلوه
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
     طباعة التابلوه
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div id="GFG" class="card-body">

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


                    <div class="row mb-2">
                        <div class="col text-left">
                            <h5 style="color:black !important;">{{company_name_arabic()}}</h5>
                        </div>
                        <div class="col text-right">
                            <h5 style="color:black !important;">{{company_name_english()}}</h5>
                        </div>
                    </div>


                        <div class="row mb-2 mx-2" style="border: 1px solid #9b9393; border-radius: 10px; background-color:#ddd">
                            <div class="col-3 p-2" style="margin-right: 30px;">
                                <h6 class="m-0"> لوحة الحجز لرحلة رقم {{$trip_data->id}}</h6>
                            </div>
                            <div class="col-1 p-2">

                            </div>
                            <div class="col-4 p-2" style="margin-right: 30px;">
                                <h6 class="m-0"> اسم الرحلة <span style="margin-right: 30px;">{{$trip_data->name}}</span></h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 mx-2">
                                <div  style="border: 1px solid #9b9393;">
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> رقم الرحلة </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">{{$run_trip->id}} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> ميعاد الرحلة </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">{{$run_trip->created_at}} </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-1" style="border: 1px solid #9b9393;">
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> من منطقة </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">{{$station_from->name}} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> إلى منطقة </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">{{$station_to->name}} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1" style="border: 1px solid #9b9393;">
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> الإصدار </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">{{\Illuminate\Support\Carbon::now()}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mx-2">
                                <div  style="border: 1px solid #9b9393;">
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> الأتوبيس </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">@isset($bus) {{$bus->code}} @else {{$run_trip->bus->code}} @endisset</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> السائق </p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">@isset($driver) {{$driver->name}} @else {{$run_trip->driver->name}} @endisset</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> السائق الإضافي</p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">@isset($extra_driver) {{$extra_driver->name}} @else ____ @endisset</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 p-1"> المضيف</p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1">@isset($host) {{$host->name}} @else ____ @endisset</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 mx-2">
                                <div  style="border: 1px solid #9b9393;">
                                    <div class="row text-center">
                                        <div class="col">
                                            <p class="m-0 p-1"> العدد </p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1"> الفئة </p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                        </div>
                                        <div class="col">
                                            <p class="m-0 p-1"> القيمة </p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                            <p class="m-0 p-1">0.0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="table-responsive mx-2" style="max-width:100%">
                        <table class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>المقعد</th>
                                <th>التذكرة</th>
                                <th>القيمة</th>
                                <th>الركوب</th>
                                <th>المغادرة</th>
                                <th>العميل</th>
                                <th>مكتب الحجز</th>
                                <th>بيانات العميل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trip_seats as $item)
                                <tr>
                                    <td>{{ $item->seat_id  }}</td>

                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                             @isset($bookingSeat->booking_id )    {{ $bookingSeat->booking_id  }}  @else @endif
                                            @else

                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                             @isset( $bookingSeat->sub_total )    {{ $bookingSeat->sub_total  }}  @else @endif
                                                @break
                                            @else

                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                              @isset($bookingSeat->reservationBooking->stationFrom->name )   {{ $bookingSeat->reservationBooking->stationFrom->name  }} @else @endif
                                            @else

                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                               @isset( $bookingSeat->reservationBooking->stationTo->name )  {{ $bookingSeat->reservationBooking->stationTo->name  }}  @else @endif
                                            @else

                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                              @isset($bookingSeat->reservationBooking->user->name )  {{ $bookingSeat->reservationBooking->user->name  }} @else @endif
                                            @else

                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($booking_seats as $bookingSeat)
                                            @if($bookingSeat->seat_id == $item->id)
                                               @isset($bookingSeat->reservationBooking->admin->office->name  )  {{ $bookingSeat->reservationBooking->admin->office->name  }}   @else @endif
                                            @else

                                            @endif
                                        @endforeach
                                    </td>
                                    <td></td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @if($request->submit == 'طباعة')
        <div class="mb-4 text-center">
            <button class="btn btn-success" type="button" onclick="printDiv()"><i class="ti-printer"></i> إطبع </button>
        </div>
    @endif

@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);
        });


        function printDiv() {
            var divContents = document.getElementById("GFG").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">');
            // a.document.write('<style>"#contain{max-width:800px}"</style');
            // document.getElementById('contain').css('max-width','800px');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();

        }
    </script>
@endsection


