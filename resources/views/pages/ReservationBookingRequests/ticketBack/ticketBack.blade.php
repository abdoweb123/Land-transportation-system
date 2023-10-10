@extends('layouts.master')
@section('css')
@section('title')
        حجز تذكرة العودة
@stop

<style>

    .old_seat input,  .new_seat input
    {
        border:none;
        outline:none;
        text-align: center;
    }
</style>

@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
    </style>
@section('PageTitle')
    حجز تذكرة العودة
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
                                            <h4>عدد الكراسي المستحقة لهذا المستخدم</h4>
                                            @foreach($degrees_with_count as $key=>$value)
                                            <h5> - <span>{{$value}}  {{$value == 1 ? 'كرسي' : 'كراسي'}} </span> <span>  للدرجة   ( {{\App\Models\Degree::find($key)->name}} ) </span></h5>

                                            @endforeach
                                        </div>
                                    </div>

                                    <form class="inside" action="{{route('reservationBookingRequests.calc_ticket_back')}}" method="post" enctype="multipart/form-data" style="position:absolute; bottom:0; width:100%; height:80%;">
                                        @csrf
                                        <div class="table-responsive mt-2 w-75">
                                            <table class="table table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                                                <thead>
                                                <tr>
                                                    <th>حدد</th>
                                                    <th>الكرسي القديم</th>
                                                    <th>الدرجة</th>
                                                    <th>الكرسي الجديد</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($bookedSeats as $bookedSeat)
                                                    <tr class="{{$loop->index}}">
                                                        <td class="old_seat_radio"><input type="radio" name="choose_old_seat"></td>
                                                        {{-- دي عشان ال request --}}
                                                        <td class="old_seat" style="display:none"><input type="text" name="oldSeats[]" value="{{$bookedSeat->seat_id}}" readonly/></td>
                                                        {{-- دي عشان التصميم --}}
                                                        <td class="old_seat"><input type="text" value="{{$bookedSeat->tripSeat->seat_id}}" readonly/></td>
                                                        <td>{{\App\Models\Degree::find($bookedSeat->degree_id)->name}}</td>
                                                        <td class="new_seat"><input type="text" name="newSeats[]" readonly/></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <input type="hidden" name="old_reservationBookingRequest_id" value="{{$old_reservationBookingRequest->id}}">
                                        <input type="hidden" name="runTrip_id" value="{{$runTrip_back->id}}">
                                        <input type="hidden" name="tripData_id" value="{{$runTrip_back->tripData_id}}">
                                        <input type="hidden" name="stationFrom_id" value="{{$request->stationFrom_id}}">
                                        <input type="hidden" name="stationTo_id" value="{{$request->stationTo_id}}">

                                        <button type="submit" class="btn btn-success mt-4">حساب الحجز</button>
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
                                                        <span class="seat_name" id="{{$item->seat->name}}">{{$item->seat->name}}</span>
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



            $('.bookSeat div').on('click',function (){

              $(this).parent().toggleClass('bookSeatColor');

              let color =  $(this).parent().css('background-color');

              let id =  $(this).attr('id');

              let className =  $(this).attr('class');

              let seat_name =  $(this).find('.seat_name').attr('id');

              let divClass =  $(this).attr('class');


              if (color === 'rgb(0, 128, 0)')
              {
                  $('.inside').append('<input type="hidden" name="seatId[]" value="'+ id +'"> <input type="hidden" name="degreeId[]" value="'+ className +'">');


                  /* عشان يحط الكرسي الجديد أمام الكرسي القديم */
                  if ($('.old_seat_radio .input[name="choose_old_seat"]:checked'))
                  {
                      // $('.old_seat_radio input[name="choose_old_seat"]:checked').parent().siblings().children('.new_seat input').val(seat_name);
                      $('.old_seat_radio input[name="choose_old_seat"]:checked').parent().siblings().children('.new_seat input').val(seat_name);
                  }

              }
               else {
                    $('input[value="'+ id +'"][type="hidden"]').remove();
                    $('input[value="'+ className +'"][type="hidden"]').remove();
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


