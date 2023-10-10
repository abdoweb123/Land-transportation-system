@extends('layouts.master')
@section('css')
@section('title')
        حجز تذكرة
@stop

<style>
    ul{list-style:none; margin:0; padding:0 !important;}
    ul .li-tab
    {
        display:inline-block;
        background-color:  <?php echo main_color_class_button_background(); ?>;
        padding:5px;
        cursor:pointer;
        margin-left: 10px;
        color:white}
    ul .inactive{
        background-color: <?php echo hover_and_focus_color_class_button_background(); ?>;
        border-color: <?php echo main_color_class_button_background(); ?>;
    }
    .my-container ~ div{min-height:200px; margin-top:20px; /*background-color:#eee; padding:10px; */ }
    .my-container > div:not(:first-of-type){display:none}

    .table td{padding: 8px;}
    .process{padding: 4px 2px 0px 3px;}
    footer{width:98%; margin:auto;}
    .row_child{margin-left:10px}
</style>


@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:green !important; color:white;}
    </style>
@section('PageTitle')
    حجز تذكرة
@stop
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


                     <div class="">
                         <div class="row mb-3" style="margin-left:0; margin-right:0;">
                             <div class="row_child">
                                 <div class="bookTicket">
                                     <form action="{{route('reservationBookingRequests.searchUserPhone')}}" method="get" enctype="multipart/form-data">
                                         @csrf
                                         <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                                         <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                                         <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                                         <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                                         <input type="hidden" name="startDate" value="{{$old_request->startDate}}">
                                         <button type="submit" class="button"><i class="ti-ticket" style="font-size:18px"></i>حجز مقعد </button>
                                     </form>
                                 </div>
                             </div>
                             <div class="row_child">
                                 <div class="bookNoulon">
                                     <form action="{{route('shippings.create')}}" method="get" enctype="multipart/form-data">
                                         @csrf
                                         <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                                         <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                                         <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                                         <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                                         <button type="submit" class="button"> <i class="ti-bag" style="font-size:18px"></i> حجز نولون </button>
                                     </form>
                                 </div>
                             </div>
                             <div class="row_child">
                                 <div class="bookRoad">
                                     <form action="{{route('reservationBookingRequests.ticket_road')}}" method="get" enctype="multipart/form-data">
                                         @csrf
                                         <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                                         <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                                         <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                                         <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                                         <button type="submit" class="button"> <i class="ti-truck" style="font-size:18px; padding-left:4px"></i>حجز طريق  </button>
                                     </form>
                                 </div>
                             </div>
                             <div class="row_child">
                                 <div class="print_tabloh">
                                     <button type="button" class="button" data-toggle="modal" data-target="#print_tabloh">
                                         <i class="ti-notepad" style="font-size:18px;"></i>      طباعة التابلوه
                                     </button>
                                 </div>
                             </div>
                             <div class="row_child">
                                 <div class="bookRoad">
                                     <form action="{{route('reservationBookingRequests.print_noulon')}}" method="get" enctype="multipart/form-data">
                                         @csrf
                                         <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                                         <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                                         <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                                         <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                                         <button type="submit" class="button"><i class="ti-printer" style="font-size:18px;"></i> طباعة النولونات </button>
                                     </form>
                                 </div>
                            </div>
                             <div class="row_child">
                                 <div class="search_secret_code">
                                     <button type="button" class="button" data-toggle="modal" data-target="#search_secret_code">
                                         <i class="ti-search" style="font-size:18px;"></i>     الكود السري
                                     </button>
                                 </div>
                             </div>
                     </div>
                     <div class="border">

                     </div>

                        <div class="my-container">
                            <ul id="my-taps" class="text-left mt-3 mb-2">
                                <li id="tap1" class="btn li-tab" style="padding: 8px 12px;">
                                    <i class="ti-ticket" style="font-size:18px;  padding-left:4px;"></i>التذاكر
                                </li>
                                <li id="tap2" class="btn inactive li-tab" style="padding: 8px 12px;">
                                    <i class="ti-bag" style="font-size:18px;  padding-left:4px;"></i>النولونات
                                </li>
                            </ul>



                            <div id="tap1-content">
                                {{-- bookings --}}
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm table-bordered p-0" data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>الرقم</th>
                                            <th>الاسم</th>
                                            <th>محطة الانطلاق</th>
                                            <th>محطة الوصول</th>
                                            <th>الإجمالي</th>
                                            <th>الحالة</th>
                                            <th>مدخل البيانات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($reservationBookings as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>@isset($item->user->name)  {{ $item->user->name }} @else _____ @endisset</td>
                                                <td>{{ $item->stationFrom->name}}</td>
                                                <td>{{ $item->stationTo->name}}</td>
                                                <td>{{ $item->total}}</td>
                                                <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                                <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____ @endisset</td>
                                            </tr>


                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div id="tap2-content">
                                {{-- Shipping --}}
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm table-bordered p-0" data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الوصف</th>
                                            <th>الاسم</th>
                                            <th>هاتف المستخدم</th>
                                            <th>محطة الانطلاق</th>
                                            <th>محطة الوصول</th>
                                            <th>اسم المستلم</th>
                                            <th>هاتف المستلم</th>
                                            <th>مدخل البيانات</th>
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($shippings as $item)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ \App\Models\User::find($item->user_id)->name }}</td>
                                                <td>{{ $item->user_phone }}</td>
                                                <td>{{ \App\Models\Station::find($item->from_station_id)->name }}</td>
                                                <td>{{ \App\Models\Station::find($item->to_station_id)->name }}</td>
                                                <td>{{ $item->receiver_name == null ? '_____' : $item->receiver_name }}</td>
                                                <td>{{ $item->receiver_phone == null ? '_____' : $item->receiver_phone }}</td>
                                                <td>{{ \App\Models\Admin::find($item->admin_id)->name }}</td>
                                                <td>
                                                    <a href="{{route('shippings.edit',[$item->shipping_id,$old_request->tripData_id])}}" class="process" style="cursor:pointer; background-color:white; border-radius:3px; border: 1px solid #dddd;">
                                                        <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></a>

                                                    <button type="button" class="process" style="cursor:pointer; background-color:white; border-radius:3px; border: 1px solid #dddd;"
                                                            data-toggle="modal" data-target="#delete{{ $item->shipping_id }}" title="حذف">
                                                        <i style="color:red; font-size:18px;" class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>

                                            <!--  page of delete_modal_city -->
{{--                                        @include('pages.Shippings.edit')--}}
                                        @include('pages.Shippings.delete')
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @include('pages.ReservationBookingRequests.print_tabloh')
        @include('pages.ReservationBookingRequests.search_secret_code')
        </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);



            $("#my-taps li").click(function(){

                var myId = $(this).attr("id");

                $(this).removeClass("inactive").siblings().addClass("inactive");

                $(".my-container > div").hide();

                $("#" + myId + "-content").fadeIn(0);
            });





        }); //end of document
    </script>
@endsection


