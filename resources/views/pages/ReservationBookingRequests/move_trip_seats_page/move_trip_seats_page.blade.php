@extends('layouts.master')
@section('css')
@section('title')
    نقل مقاعد رحلة إلى أخرى
@stop


<style>
    #datatable_filter , .dataTables_empty
    {
        display:none
    }
    .edit_from_trip > div , .table_from_trip > div
    {
        border: 1px solid #7e7373a3;
        margin: 5px; padding: 5px;
    }
    table th {border-top:none !important}
    table thead {border-bottom: 1px solid #ddd;}
    /*input[type='submit']*/
    /*{*/
    /*    background-color: #84ba3f;*/
    /*    border-color: #84ba3f;*/
    /*}*/
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   نقل مقاعد رحلة إلى أخرى
@stop
<!-- breadcrumb -->
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
                            <div class="alert alert-{{$msg}} messages">
                                {{Session::get('alert-'.$msg)}}
                            </div>
                        @endif
                    @endforeach

                    {{--  button of add_modal_employee  --}}
                  <div class="text-center mb-2">
                      <form id="move_seats_form" action="{{route('make_movements_of_tripSeats')}}" method="post" class="d-inline-block">
                          @csrf
                          <input type="hidden" name="old_run_trip" value="@isset($old_runTrip)  {{$old_runTrip->id}} @endisset">
                          <input type="hidden" name="new_run_trip_id" class="form-control" value="@isset($new_runTrip) {{$new_runTrip->id}} @endisset " style=" height:5px; display:inline-block !important;">

                          <input type="submit" name="move_seats" class="button" value="موافق على التحويل بين الرحلتين">
                      </form>

                  </div>

                  <div class="row">
                      <div class="col-6">
                          <div class="edit_from_trip">
                              <div class="row" style="">
                                  <div class="col-7">
                                      <div class="row">
                                          <div class="col-4" style="padding-left:0;">
                                              <label>تعديل من رحلة</label>
                                          </div>
                                          <form action="{{route('search_for_old_run_trip')}}" method="get" class="col-8 row" style="padding-left:0">
                                               @csrf
                                              <div class="col-6"  style=" padding-left: 0;padding-right: 0;">
                                                  <input type="text" name="edit_from_trip_id" class="form-control" value="@isset($request_old_run_trip) {{$request_old_run_trip->edit_from_trip_id}} @else @isset($request_new_run_trip) @isset($old_runTrip->id) {{$old_runTrip->id}} @endisset @else @endisset @endisset" style=" height:5px; display:inline-block !important;">
                                              </div>
                                              <div class="col-6" style="padding-left:0">
                                                  <input type="submit" name="search_edit_from_trip" class="btn btn-success" value="بحث" style="padding: 3px 12px; width:100%">
                                              </div>
                                          </form>
                                      </div>
                                      <div class="mt-1 p-2" style="min-height: 100px; border: 1px solid #ddd; background-color: #dddddd24;">
                                          @isset($old_runTrip )
                                              <p>  <span style="font-weight:bold">رقم الرحلة :</span> <span> {{$old_runTrip->id}}</span></p>
                                              <p>  <span style="font-weight:bold">التاريخ :</span>  <span> {{$old_runTrip->startDate}}</span></p>
                                              <p> <span style="font-weight:bold"> الموعد :</span>  <span> {{date("g:iA", strtotime($old_runTrip->startTime))}}</span></p>
                                              <p> <span style="font-weight:bold"> النوع :</span>  <span> {{ $old_runTrip->type  == 1 ? 'ذهاب' : 'ذهاب وعودة' }}</span></p>
                                          @else
                                              @isset($old_runTrip)
                                                  <p>  <span style="font-weight:bold">رقم الرحلة :</span> <span> {{$old_runTrip->id}}</span></p>
                                                  <p>  <span style="font-weight:bold">التاريخ :</span>  <span> {{$old_runTrip->startDate}}</span></p>
                                                  <p> <span style="font-weight:bold"> الموعد :</span>  <span> {{date("g:iA", strtotime($old_runTrip->startTime))}}</span></p>
                                                  <p> <span style="font-weight:bold"> النوع :</span>  <span> {{ $old_runTrip->type  == 1 ? 'ذهاب' : 'ذهاب وعودة' }}</span></p>
                                              @endisset

                                          @endisset
                                      </div>
                                  </div>
                                  <div class="col">
                                      <input type="submit" name="search_edit_from_trip" class="btn btn-success w-100 mb-2" value="توقيف الرحلة">
                                      <div class="row">
                                          <div class="d-inline-block col-2" style="padding-left: 0;"><span>من</span> </div>
                                          <div class="d-inline-block col">
                                              <select class="form-control mb-2" name="from_ticket_old_runTrip" style="display:inline-block !important; height:33px; padding:3px">
                                                  <option value=" "></option>
                                                  @isset($old_runTrip)
                                                      @foreach($old_tickets as $old_ticket)
                                                      <option value="{{$old_ticket->id}}">{{$old_ticket->id}}</option>
                                                      @endforeach
                                                  @else
                                                      @isset($old_runTrip)
                                                          @foreach($old_tickets as $old_ticket)
                                                          <option value="{{$old_ticket->id}}">{{$old_ticket->id}}</option>
                                                          @endforeach
                                                      @endisset
                                                  @endisset
                                              </select>
                                          </div>
                                      </div>
                                      <div>
                                         <div class="row">
                                             <div class="d-inline-block col-2" style="padding-left: 0;"><span>إلى</span> </div>
                                             <div class="d-inline-block col">
                                                 <select class="form-control mb-2" name="to_ticket_old_runTrip" style="display:inline-block !important; height:33px; padding:3px">
                                                     <option value=" "></option>
                                                     @isset($old_runTrip)
                                                         @foreach($old_tickets as $old_ticket)
                                                             <option value="{{$old_ticket->id}}">{{$old_ticket->id}}</option>
                                                         @endforeach
                                                     @else
                                                         @isset($old_runTrip)
                                                             @foreach($old_tickets as $old_ticket)
                                                                 <option value="{{$old_ticket->id}}">{{$old_ticket->id}}</option>
                                                             @endforeach
                                                         @endisset
                                                     @endisset
                                                 </select>
                                             </div>
                                         </div>
                                      </div>
                                      <div>
                                          <div class="row">
                                              <div class="d-inline-block col-2 hidden" style="padding-left: 0;"><span>إلى</span> </div>
                                              <div class="d-inline-block col">
                                                  <input type="submit" name="search_edit_from_trip" class="btn btn-success" value="تصفية" style="padding: 3px 12px; width:48.99%">
                                                  <input type="submit" name="make_ticket_from_to_empty" class="btn btn-success" value="إلغاء" style="padding: 3px 12px; width:48.99%">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="table_from_trip">
                              <div style="padding:0;  border: 2px solid #0000008a; max-height: 250px; overflow:auto">
                                  <div class="table-responsive">
                                      <table class="table table-bordered table-hover table-sm p-0 mb-0" data-page-length="50"
                                             style="text-align: center">
                                          <thead>
                                          <tr>
                                              <th>رقم التذكرة</th>
                                              <th>المقعد</th>
                                              <th>من منطقة</th>
                                              <th>إلى منطقة</th>
                                              <th>المكتب</th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          @isset($old_runTrip)
                                              @foreach ($old_booking_seats as $item)
                                                  <tr>
                                                      <td>{{ $item->booking_id }}</td>
                                                      <td>{{ $item->seat_id }}</td>
                                                      <td>@isset($item->reservationBooking->stationFrom->name) {{ $item->reservationBooking->stationFrom->name }} @endisset</td>
                                                      <td>@isset($item->reservationBooking->stationTo->name) {{ $item->reservationBooking->stationTo->name }} @endisset</td>
                                                      <td>@isset($item->reservationBooking->office->name) {{ $item->reservationBooking->office->name }} @endisset</td>
                                                  </tr>
                                              @endforeach
                                          @else
                                              @isset($old_runTrip)
                                                 @foreach ($old_booking_seats as $item)
                                                  <tr>
                                                      <td>{{ $item->seat_id }}</td>
                                                      <td>@isset($item->reservationBooking->stationFrom->name) {{ $item->reservationBooking->stationFrom->name }} @endisset</td>
                                                      <td>@isset($item->reservationBooking->stationTo->name) {{ $item->reservationBooking->stationTo->name }} @endisset</td>
                                                      <td>@isset($item->reservationBooking->office->name) {{ $item->reservationBooking->office->name }} @endisset</td>
                                                  </tr>
                                                @endforeach
                                              @endisset
                                           @endisset
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-6">
                          <div class="edit_from_trip">
                              <div class="row" style="">
                                  <div class="col-7">
                                      <div class="row">
                                          <div class="col-4" style="padding-left:0;">
                                              <label>تعديل إلى رحلة</label>
                                          </div>
                                          <form id="search_for_new_run_trip" action="{{route('search_for_new_run_trip')}}" method="get" class="col-8 row" style="padding-left:0">
                                              @csrf
                                              <input type="hidden" name="old_run_trip" value="@isset($old_runTrip) {{$old_runTrip->id}} @endisset">
                                              <div class="col-6"  style=" padding-left: 0;padding-right: 0;">
                                                  <input type="text" name="edit_from_new_trip_id" class="form-control" value="@isset($new_runTrip) {{$new_runTrip->id}} @endisset " style=" height:5px; display:inline-block !important;">
                                              </div>
                                              <div class="col-6" style="padding-left:0">
                                                  <input type="submit" name="search_edit_from_trip" class="btn btn-success" value="بحث" style="padding: 3px 12px; width:100%">
                                              </div>
                                          </form>
                                      </div>
                                      <div class="mt-1 p-2" style="min-height: 100px; border: 1px solid #ddd; background-color: #dddddd24;">
                                          @isset($new_runTrip)
                                              <p>  <span style="font-weight:bold">رقم الرحلة :</span> <span> {{$new_runTrip->id}}</span></p>
                                              <p>  <span style="font-weight:bold">التاريخ :</span>  <span> {{$new_runTrip->startDate}}</span></p>
                                              <p> <span style="font-weight:bold"> الموعد :</span>  <span> {{date("g:iA", strtotime($new_runTrip->startTime))}}</span></p>
                                              <p> <span style="font-weight:bold"> النوع :</span>  <span> {{ $new_runTrip->type  == 1 ? 'ذهاب' : 'ذهاب وعودة' }}</span></p>
                                          @endisset
                                      </div>
                                  </div>
                                  <div class="col">
                                      <button type="button" class="btn btn-success w-100 mb-2" data-toggle="modal" data-target="#create_new_runTrip">
                                          إنشاء رحلة
                                      </button>
{{--                                      <input type="submit" name="search_edit_from_trip" class="btn btn-success w-100 mb-2" value="إنشاء الرحلة">--}}
                                      <div class="row">
                                          <div class="d-inline-block col-2" style="padding-left: 0;"><span>من</span> </div>
                                          <div class="d-inline-block col">
                                              <select class="form-control mb-2" name="from_seat_new_runTrip" style="display:inline-block !important; height:33px; padding:3px">
                                                  <option value=" "></option>
                                                  @isset($new_runTrip)
                                                      @isset($new_trip_seats)
                                                          @foreach($new_trip_seats as $new_trip_seat)
                                                              <option value="{{$new_trip_seat->seat_id}}">{{$new_trip_seat->seat_id}}</option>
                                                          @endforeach
                                                      @endisset
                                                  @endisset
                                              </select>
                                          </div>
                                      </div>
                                      <div>
                                          <div class="row">
                                              <div class="d-inline-block col-2" style="padding-left: 0;"><span>إلى</span> </div>
                                              <div class="d-inline-block col">
                                                  <select class="form-control mb-2" name="to_seat_new_runTrip" style="display:inline-block !important; height:33px; padding:3px">
                                                      <option value=" "></option>
                                                      @isset($new_runTrip)
                                                          @isset($new_trip_seats)
                                                              @foreach($new_trip_seats as $new_trip_seat)
                                                                  <option value="{{$new_trip_seat->seat_id}}">{{$new_trip_seat->seat_id}}</option>
                                                              @endforeach
                                                          @endisset
                                                      @endisset
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div>
                                          <div class="row">
                                              <div class="d-inline-block col-2 hidden" style="padding-left: 0;"><span>إلى</span> </div>
                                              <div class="d-inline-block col">
                                                  <input type="submit" name="search_edit_from_trip" class="btn btn-success" value="تصفية" style="padding: 3px 12px; width:48.99%">
                                                  <input type="submit" name="make_ticket_from_to_empty" class="btn btn-success" value="إلغاء" style="padding: 3px 12px; width:48.99%">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="table_from_trip">
                              <div style="padding:0;  border: 2px solid #0000008a; max-height: 250px; overflow:auto">
                                  <div class="table-responsive">
                                      <table class="table table-bordered table-hover table-sm p-0 mb-0" data-page-length="50"
                                             style="text-align: center">
                                          <thead>
                                          <tr>
                                              <th>رقم التذكرة</th>
                                              <th>المقعد</th>
                                              <th>من منطقة</th>
                                              <th>إلى منطقة</th>
                                              <th>المكتب</th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          @isset($new_runTrip)
                                              @isset($new_booking_seats)
                                                  @foreach ($new_booking_seats as $item)
                                                      <tr>
                                                          <td>{{ $item->booking_id }}</td>
                                                          <td>{{ $item->seat_id }}</td>
                                                          <td>@isset($item->reservationBooking->stationFrom->name) {{ $item->reservationBooking->stationFrom->name }} @endisset</td>
                                                          <td>@isset($item->reservationBooking->stationTo->name) {{ $item->reservationBooking->stationTo->name }} @endisset</td>
                                                          <td>@isset($item->reservationBooking->office->name) {{ $item->reservationBooking->office->name }} @endisset</td>
                                                      </tr>
                                                  @endforeach
                                              @endisset
                                          @endisset
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_employee -->
       @include('pages.ReservationBookingRequests.move_trip_seats_page.create_new_runTrip')
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".messages").delay(5000).slideUp(300);
        });



        $('select[name="from_ticket_old_runTrip"]').on("change", function(){
            $('#move_seats_form').append('<input type="hidden" name="from_ticket_old_runTrip" value="'+ $('select[name="from_ticket_old_runTrip"]').val() +'">');
        });


        $('select[name="to_ticket_old_runTrip"]').on("change", function(){
            $('#move_seats_form').append('<input type="hidden" name="to_ticket_old_runTrip" value="'+ $('select[name="to_ticket_old_runTrip"]').val() +'">');
        });


        $('select[name="from_seat_new_runTrip"]').on("change", function(){
            $('#move_seats_form').append('<input type="hidden" name="from_seat_new_runTrip" value="'+ $('select[name="from_seat_new_runTrip"]').val() +'">');
        });


        $('select[name="to_seat_new_runTrip"]').on("change", function(){
            $('#move_seats_form').append('<input type="hidden" name="to_seat_new_runTrip" value="'+ $('select[name="to_seat_new_runTrip"]').val() +'">');
        });

    </script>
@endsection



