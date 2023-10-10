@extends('layouts.master')
@section('css')
@section('title')
       تعديل الحجز
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        /*.bookSeatColorBack{background-color:beige !important; color:black;}*/
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
    </style>
@section('PageTitle')
    تعديل الحجز
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
            <h5 style="color: #0a58ca">&nbsp; رحلة : &nbsp;{{$tripData->name}}</h5>
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



                    <!-- Start bus design and edit seats-->
                    @if(!$tripSeats->isEmpty())
                        @if(count($tripSeats) == count($tripSeats))  <!-- عدد مقاعد الرحلة = عدد مقاعد الأسطول التي تتبع له الرحلة -->
                             <div class="row">
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">
                                     <h3 style="font-family: 'Cairo', sans-serif;">الحجز االقديم </h3>
                                     <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px; outline: 2px solid #01010147;">
                                         @foreach($tripSeats as $item)
                                             <div class="" style="cursor:pointer;
                                                 @foreach($request->seatId as $seat_id)
                                                     @foreach($item->bookingSeats as $bookingSeat)
                                                         @if($seat_id == $bookingSeat->id)
                                                             background-color:red !important; color:white;
                                                         @endif
                                                     @endforeach
                                                 @endforeach

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

                                     <div class="row mx-auto my-3" style="width:500px;">
                                         <div class="col">
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المدفوع :  {{$totalCount}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المخصوم :  {{$totalDiscount}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ الإجمالي :  {{$totalCount - $totalDiscount}}</p>
                                         </div>
                                     </div>

                                     <div style="border-bottom:1px solid #737070; width:500px; margin: auto">
                                     </div>

                                    <?php
                                    $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id',$reservationBookingRequest->stationFrom_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id',$reservationBookingRequest->stationTo_id)->where('tripData_id',$tripData->id)->first()->rank;
                                    ?>

                                 </div>
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">

                                        <h3 style="font-family: 'Cairo', sans-serif;">الحجز الجديد </h3>
                                        <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px; outline: 2px solid #01010147;">
                                            @foreach($tripSeats as $item)
                                                <div class="bookSeat
                                                @isset($newTripSeats)
                                                    @foreach($newTripSeats as $newTripSeat)
                                                    @if($newTripSeat == $item->id)
                                                        bookSeatColor
                                                    @endif
                                                    @endforeach
                                                @endisset" style="cursor:pointer;
                                                @if($item->bookingSeats)
                                                    @foreach($item->bookingSeats as $subItem)
                                                    @if($subItem->runTrip_id == $reservationBookingRequest->runTrip_id)
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
                                                    @else background-color:beige;
                                                    @endif


                                                    width:100px; height:90px; margin:10px; text-align:center; position:relative;">
                                                    <div class="{{$item->degree_id}}" id="{{$item->id}}" style="cursor:pointer; padding:23px 0;">
                                                        <a>
                                                            {{$item->seat->name}}
                                                            <p>{{$item->degree->name}}</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row mx-auto my-3" style="width:500px;">
                                            <div class="col">
                                                <div class="mt-4 font-weight-bold text-left mb-2"> المبلغ الإجمالي : <div class="d-inline paid">@isset($totalOfNewBooking) {{$totalOfNewBooking}} @else 0.0 @endisset</div></div>
                                                <div class="mt-4 font-weight-bold text-left mb-2"> المبلغ المدفوع مسبقا :  <div class="d-inline fee">{{$totalCount - $totalDiscount}}</div></div>
                                                <div class="mt-4 font-weight-bold text-left mb-2"> المبلغ المطلوب سداده :  <div class="d-inline totalRemain">@isset($totalOfNewBooking){{ ($totalOfNewBooking - ($totalCount - $totalDiscount)) > 0 ? $totalOfNewBooking - ($totalCount - $totalDiscount) : '0.0'}}@else 0.0 @endisset</div></div>
                                            </div>
                                            <div class="col position-relative">
                                                <form class="inside" action="{{route('reservationBookingRequests.changeSeats')}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="reservationBookingRequest_id" value="{{$reservationBookingRequest->id}}">
                                                    <input type="hidden" name="old_paid" value="{{$totalCount - $totalDiscount}}">
                                                    <input type="hidden" name="trip_type" value="1">
                                                    <input type="hidden" name="totalCount" value="{{$totalCount}}">
                                                    <input type="hidden" name="totalDiscount" value="{{$totalDiscount}}">
                                                    <input type="hidden" name="line_id" value="{{$line->id}}">
                                                    @foreach($request->seatId as $seat_id)
                                                        <input type="hidden" name="seatId[]" value="{{$seat_id}}">
                                                    @endforeach
                                                    @isset($newTripSeats)
                                                        @foreach($newTripSeats as $newTripSeat)
                                                            <input type="hidden" name="NewSeatId[]" value="{{$newTripSeat}}">
                                                        @endforeach
                                                    @endisset
                                                    <button type="submit" class="btn btn-secondary mt-4 position-absolute" style="bottom:40px; left:0; padding: 6px 14px;">حساب الحجز</button>
                                                </form>

                                                <form class="inside" action="{{route('reservationBookingRequests.newBookingAfterChangeSeats')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="reservationBookingRequest_id" value="{{$reservationBookingRequest->id}}">
                                                    <input type="hidden" name="trip_type" value="1">
                                                    <input type="hidden" name="totalOfNewBooking" value="@isset($totalOfNewBooking){{$totalOfNewBooking}}@endisset">
                                                    <input type="hidden" name="totalRemain" value="@isset($totalOfNewBooking){{ ($totalOfNewBooking - ($totalCount - $totalDiscount)) > 0 ? $totalOfNewBooking - ($totalCount - $totalDiscount) : '0'}}@else 0 @endisset">
                                                    <input type="hidden" name="totalDiscount" value="{{$totalDiscount}}">
                                                    <input type="hidden" name="les_type" value="1"> {{-- plus --}}
                                                    <input type="hidden" name="line_id" value="{{$line->id}}">
                                                    @foreach($request->seatId as $seat_id)
                                                        <input type="hidden" name="seatId[]" value="{{$seat_id}}">
                                                    @endforeach
                                                    @isset($newTripSeats)
                                                        @foreach($newTripSeats as $newTripSeat)
                                                            <input type="hidden" name="NewSeatId[]" value="{{$newTripSeat}}">
                                                        @endforeach
                                                    @endisset
                                                    <button type="submit" class="btn btn-success mt-4 position-absolute" style="bottom:0; left:0">تأكيد العملية</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div style="border-bottom:1px solid #737070; width:500px; margin: auto">
                                        </div>


                                </div>
                            </div>
                        @endif
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



            $('.bookSeat div').on('click',function (){

                let old_color =  $(this).parent().css('background-color');
                let old_id =  $(this).attr('id');

                if ( old_color === 'rgb(0, 128, 0)')
                {
                    $(this).parent().toggleClass('bookSeatColorBack');
                    $('input[value="'+ old_id +'"][type="hidden"]').remove();
                }

                $(this).parent().toggleClass('bookSeatColor');

                let id =  $(this).attr('id');

                let color =  $(this).parent().css('background-color');

                let divClass =  $(this).attr('class');



              if (color === 'rgb(0, 128, 0)')
              {
                  $('.inside').append('<input type="hidden" name="NewSeatId[]" value="'+ id +'">');
              }


               else {
                  $('input[value="'+ id +'"][type="hidden"]').remove();
              }


            });




            // $('.getSeat').filter(function (){
            //     return $(this).css('color') == 'rgb(0,128,0)';
            // }).each(function (){
            //     // console.log( $(this).attr('id'));
            //
            //     $(this).css('display','none');
            // })






        }); //end of document
    </script>
@endsection


