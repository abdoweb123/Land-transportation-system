@extends('layouts.master')
@section('css')
@section('title')
        حجز طريق
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
    </style>
@section('PageTitle')
    حجز طريق
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
                                    <form class="inside" action="{{route('reservationBookingRequests.save_ticket_road')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="runTrip_id" value="{{$request->runTrip_id}}">
                                        <input type="hidden" name="tripData_id" value="{{$request->tripData_id}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$request->stationFrom_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$request->stationTo_id}}">

                                       <div class="row">
                                           <div class="col-md-6">
                                               <label>إجمالي حجز الطريق :</label>
                                               <input type="text" class="form-control" name="save_ticket_road">
                                           </div>
                                           <div class="col-md-6">
                                               <label style="visibility: hidden; display: block"> :</label>
                                               <button type="submit" class="button" style="padding:11px 20px;">تأكيد الحجز</button>
                                           </div>
                                       </div>
                                    </form>

                                    <?php
                                    $request_of_trip_station_from_rank = \App\Models\TripStation::where('station_id',$request->stationFrom_id)->where('tripData_id',$request->tripData_id)->first()->rank;
                                    $request_of_trip_station_to_rank = \App\Models\TripStation::where('station_id',$request->stationTo_id)->where('tripData_id',$request->tripData_id)->first()->rank;
                                    ?>

                                </div>
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">
                                    <h3 style="font-family: 'Cairo', sans-serif;">حجز مقعد </h3>
                                    <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                        @foreach($tripSeats as $item)
                                            <div class="bookSeat" style="cursor:pointer;
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
                                                       )                                                            background-color:red !important; color:white;
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
                                            <div class="col">
                                                <p>{{$line->degree->name}} (سعر الذهاب)  :   {{$line->priceGo}}</p>
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


