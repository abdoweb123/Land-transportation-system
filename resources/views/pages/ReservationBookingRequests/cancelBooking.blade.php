@extends('layouts.master')
@section('css')
@section('title')
       إلغاء الحجز
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 2px solid #00000073;}
        .bookSeatColor{background-color:rgb(0,128,0) !important; color:white;}
        /*.bookSeatColorBack{background-color:beige !important; color:black;}*/
        /*input[type="hidden"]:not([type="radio"]){display:block}*/
        .accounting{text-align: initial;margin-top: 15px;font-weight: bolder;}
    </style>
@section('PageTitle')
    إلغاء الحجز
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
                                             <h4 class="accounting">حسابات المقاعد</h4>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المدفوع :  {{$totalCount}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المخصوم :  {{$totalDiscount}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المتبقي :  {{$totalCount - $totalDiscount}}</p>
                                         </div>
                                         <div class="col">
                                             <h4 class="accounting">حسابات التذكرة كلها</h4>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المدفوع :  {{$reservationBookingRequest->sub_total}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المخصوم :  {{$totalDiscountForAllSeats}}</p>
                                             <p class="mt-4 font-weight-bold text-left mb-2"> المبلغ المتبقي :  {{$reservationBookingRequest->sub_total - $totalDiscountForAllSeats}}</p>
                                         </div>
                                     </div>

                                     <div style="border-bottom:1px solid #737070; width:500px; margin: auto">
                                     </div>

                                 </div>
                                <div class="col-md-6 bus_design mx-auto text-center overflow-auto">

                                        <h3 style="font-family: 'Cairo', sans-serif;"><span style="visibility:hidden">Abo Sallam</span></h3>

                                    <form class="inside d-inline-block" action="{{route('reservationBookingRequests.cancelBooking')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="reservationBookingRequest_id" value="{{$reservationBookingRequest->id}}">
                                        <input type="hidden" name="totalCount" value="{{$totalCount}}">
                                        <input type="hidden" name="totalRemain" value="{{$totalCount - $totalDiscount}}">
                                        @foreach($request->seatId as $seat_id)
                                            <input type="hidden" name="seatId[]" value="{{$seat_id}}">
                                        @endforeach

                                        <button type="submit" class="button">إلغاء المقاعد المحددة</button>
                                    </form>
                                    <form class="inside d-inline-block" action="{{route('reservationBookingRequests.cancelBooking')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="reservationBookingRequest_id" value="{{$reservationBookingRequest->id}}">
                                        <input type="hidden" name="totalRemain" value="{{$reservationBookingRequest->sub_total - $totalDiscountForAllSeats}}">
                                        <button type="submit" class="button">إلغاء التذكرة كلها</button>
                                    </form>

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


