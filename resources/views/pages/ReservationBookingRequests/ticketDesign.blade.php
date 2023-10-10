@extends('layouts.master')
@section('css')
@section('title')
    عرض التذكرة
@stop


<style>
    .up_right
    {
        width: 200px;
        height: 100px;
        background-color: #84ba3f;
        color: white;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-left:15px
    }
    .contain .row{
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .contain .col{
        padding-left: 0;
        padding-right: 0;
    }
    p{font-size:14px}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   عرض التذكرة
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <?php use Jenssegers\Date\Date;
    Date::setLocale('ar'); ?>

    <div class="row" id="father" style="max-width:800px; margin:auto;">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body" style="padding:0" id="GFG">
                    <div id="head" class="head mb-3" style="text-align:center">
                        <div class="row" style="margin-right: 10px;">
                            <div class="col" style="padding:5px 0; margin: 11px 0 4px 0; background-color:white; max-width: 65px;">
                                <i class="ti-ticket ti_ticket_print" style="font-size:32px; color: #84ba3f;"></i>
                            </div>

                           <div class="col" style="padding:5px 0; margin: 11px 225px 4px 0;  text-align:initial;">
                               <h6 style="color:white; font-weight:bold">{{company_name_arabic()}}</h6>
                           </div>
                       </div>
                    </div>
                    <div id="contain" class="contain" style="padding: 15px 40px;">
                       <div class="row" style=" margin-left: 0 !important; margin-right: 0 !important;">
                           <h5 style="color:#84ba3f; font-weight:bold;">بيانات التذكرة</h5>
                       </div>
                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold"> رقم التذكرة </p>
                                <p> {{$reservationBookingRequest->id}}</p>
                            </div>
                            <div class="col">
                                <p class="font-weight-bold">نوع الحجز </p>
                                <p> {{$reservationBookingRequest->type == 1 ? 'ذهاب فقط' : 'ذهاب وعودة' }}</p>
                            </div>
                        </div>
                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold"> عدد المسافرين </p>
                                <p>{{count($reservationBookingRequest->bookingSeats)}}</p>
                            </div>
                            <div class="col">
                                <p class="font-weight-bold">الإجمالي المدفوع </p>
                                <p>@if($reservationBookingRequest->type == 1) {{$reservationBookingRequest->sub_total }} @else @if($reservationBookingRequest->go_ticket_id == null) {{$reservationBookingRequest->sub_total * 2}} @else {{$reservationBookingRequest->sub_total }} @endif @endif  جنيه  </p>
                            </div>
                        </div>
                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold"> تاريخ إصدار التذكرة  </p>
                                <p>{{Date::createFromDate($reservationBookingRequest->created_at)->format('l j F Y h:i:s')}}</p>
                            </div>
                            @if($reservationBookingRequest->secret_code != null)
                                <div class="col">
                                    <p class="font-weight-bold"> الكود السري  </p>
                                    <p>{{$reservationBookingRequest->secret_code}}</p>
                                </div>
                            @endif
                        </div>
                        <div class="separator" style="margin-bottom:20px; margin-top:20px"></div>
                        <div class="row" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <h5 style="color:#84ba3f; font-weight:bold;">بيانات الرحلة</h5>
                        </div>

                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold">رقم الرحلة</p>
                                <p>{{$reservationBookingRequest->runTrip_id}}</p>
                            </div>
                        </div>
                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold">من </p>
                                <p>{{$reservationBookingRequest->stationFrom->name}} </p>
                            </div>
                            <div class="col">
                                <p class="font-weight-bold">إلى </p>
                                <p>{{$reservationBookingRequest->stationTo->name}} </p>
                            </div>
                        </div>
                        <div class="row m-3" style=" margin-left: 0 !important; margin-right: 0 !important;">
                            <div class="col">
                                <p class="font-weight-bold">تاريخ الرحلة </p>
                                <p>{{Date::createFromDate($reservationBookingRequest->runTrip->startDate)->format('l j F Y')}}</p>
                            </div>
                            <div class="col">
                                <p class="font-weight-bold">توقيت الرحلة </p>
                                <p>{{date("g:iA", strtotime($reservationBookingRequest->runTrip->startTime))}}</p>
                            </div>
                        </div>
                        @isset($reservationBookingRequest->user->name)
                            <div  class="separator" style="margin-bottom:20px; margin-top:20px; margin-left: 0 !important; margin-right: 0 !important;"></div>
                            <div class="row" style=" margin-left: 0 !important; margin-right: 0 !important;">
                                <h5 style="color:#84ba3f; font-weight:bold;">بيانات المسافر</h5>
                            </div>
                            <div class="row m-3" style="margin-bottom:80px !important;">
                                <div class="col">
                                    <p class="font-weight-bold">الاسم</p>
                                    <p> {{$reservationBookingRequest->user->name}}</p>
                                </div>
                                <div class="col">
                                    <p class="font-weight-bold">الهاتف</p>
                                    <p>{{$reservationBookingRequest->user->mobile}}</p>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            @isset($request->secret_code)  {{-- بحيث لو بيبحث عن تذكرة بكود سري لا يظهر له (حجز تذكرة العودة) --}}
            @else
                {{-- ذهاب وعودة مفتوحة --}}
                @if($reservationBookingRequest->type == 4 && $reservationBookingRequest->user->wallet >= $reservationBookingRequest->sub_total)
                    <div class="mb-4">
                        <a href="{{route('reservationBookingRequests.ticket_back',$reservationBookingRequest->id)}}" class="text-left btn btn-success" style="margin-bottom: 1px;">
                            حجز تذكرة العودة </a>
                    </div>
                {{-- ذهاب وعودة --}}
                @elseif($reservationBookingRequest->type == 2 && $reservationBookingRequest->user->wallet >= $reservationBookingRequest->sub_total)
                    <div class="mb-4">
                        <form action="{{route('reservationBookingRequests.chooseSeats_ticketBack_closed')}}"  method="get" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="runTrip_id" value="{{$reservationBookingRequest->runTrip_id}}">
                            <input type="hidden" name="runTripBack_id" value="{{$runTripBack_id}}">
                            <input type="hidden" name="tripData_id" value="{{$reservationBookingRequest->trip_id}}">
                            <input type="hidden" name="stationFrom_id" value="{{$reservationBookingRequest->stationTo_id}}">
                            <input type="hidden" name="stationTo_id" value="{{$reservationBookingRequest->stationFrom_id}}">
                            <input type="hidden" name="old_reservationBookingRequest" value="{{$reservationBookingRequest->id}}">
                            <button class="text-left btn btn-success" style="margin-bottom: 1px;">حجز تذكرة العودة</button>
                        </form>
                    </div>
                @endif
            @endisset

{{--            @isset($paid_user)--}}
{{--                <div class="mb-4">--}}
{{--                    <p class="text-left" style="margin-bottom: 1px;">المبلغ الذي سيدفعه العميل  </p>--}}
{{--                    <p style="font-weight:bold;"> {{$paid_user}}</p>--}}
{{--                </div>--}}
{{--            @endisset--}}
        </div>
        <div class="col mb-4">
            <button class="btn btn-success" type="button" onclick="printDiv()"><i class="ti-printer"></i> إطبع </button>
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




