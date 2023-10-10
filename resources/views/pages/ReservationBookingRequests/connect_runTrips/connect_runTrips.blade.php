@extends('layouts.master')
@section('css')
@section('title')
  ربط رحلات الذهاب والعودة
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
    input[type="date"],input[type="time"]
    {
        height: 35px;
    }
    .label_div{
        color: black;
        text-align: left;
        margin:auto;
    }
    .mini_submit
    {
        padding:4px !important;
    }
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   ربط رحلات الذهاب والعودة
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
                      <form id="get_connect_runTrip" action="{{route('connect_runTrip')}}" method="post" class="d-inline-block">
                          @csrf
                          <input type="submit" name="get_connect_runTrip" class="button" value="الربط بين رحلات الذهاب والعودة">
                      </form>
                  </div>

                  <div class="row">
                      <div class="col-6">
                          <div class="edit_from_trip">
                             <div>
                                 <form action="{{route('get_go_trips')}}" method="get" enctype="multipart/form-data">
                                     @csrf
                                     <div class="row" style="">
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> من منطقة</span> </div>
                                             <div class="d-inline-block col">
                                                 <select class="form-control mb-2" name="from_station_go" style="display:inline-block !important; height:33px; padding:3px" required>
                                                     <option value=" ">---</option>
                                                     @foreach($stations as $station)
                                                         <option value="{{$station->id}}" @isset($old_request) {{$old_request->from_station_go == $station->id ? 'selected' : ''}} @else @isset($new_request) {{$new_request->from_station_go == $station->id ? 'selected' : ''}} @endisset @endisset>{{$station->name}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> إلى منطقة</span> </div>
                                             <div class="d-inline-block col">
                                                 <select class="form-control mb-2" name="to_station_go" style="display:inline-block !important; height:33px; padding:3px" required>
                                                     <option value=" ">---</option>
                                                     @foreach($stations as $station)
                                                         <option value="{{$station->id}}" @isset($old_request) {{$old_request->to_station_go == $station->id ? 'selected' : ''}} @else @isset($new_request) {{$new_request->to_station_go == $station->id ? 'selected' : ''}} @endisset @endisset>{{$station->name}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row" style="">
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> من تاريخ</span> </div>
                                             <div class="d-inline-block col">
                                                 <input type="date" name="from_date_go" class="form-control mb-2" @isset($old_request) value="{{$old_request->from_date_go}}" @else @isset($new_request) value="{{$new_request->from_date_go}}" @endisset @endisset required>
                                             </div>
                                         </div>
                                         <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                             <div class="col-9 row">
                                                 <div class="col">
                                                     <input type="radio" checked readonly>   ذهاب
                                                 </div>
                                                 <div class="col">
                                                     <input type="radio" readonly> عودة
                                                 </div>
                                             </div>
                                             <div class="col row">
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row" style="">
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> إلى تاريخ</span> </div>
                                             <div class="d-inline-block col">
                                                 <input type="date" name="to_date_go" class="form-control mb-2" @isset($old_request) value="{{$old_request->to_date_go}}" @else @isset($new_request) value="{{$new_request->to_date_go}}" @endisset @endisset required>
                                             </div>
                                         </div>

                                         <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                             <div class="col-9">
                                                 <input type="time" name="time_go" class="form-control mb-2" @isset($old_request) value="{{$old_request->time_go}}" @else @isset($new_request) value="{{$new_request->time_go}}" @endisset @endisset>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row" style="">
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span>نوع الخدمة</span> </div>
                                             <div class="d-inline-block col">
                                                 <select class="form-control mb-2" name="degree_go" style="display:inline-block !important; height:33px; padding:3px">
                                                     <option value=" ">---</option>
                                                     @foreach($degrees as $degree)
                                                         <option value="{{$degree->id}}"  @isset($old_request) {{$old_request->degree_go == $degree->id ? 'selected' : ''}}  @else @isset($new_request) {{$new_request->degree_go == $degree->id ? 'selected' : ''}} @endisset @endisset>{{$degree->name}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                             <div class="col-9 row">

                                             </div>
                                             <div class="col row">
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row" style="">
                                         <div class="col row">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> </span> </div>
                                             <div class="d-inline-block col">
                                                 <div class="row m-auto justify-content-between" style="max-width: 100%">
                                                     <div class="">
                                                         <button class="btn btn-success mini_submit">تحديد الكل</button>
                                                     </div>
                                                     <div class="">
                                                         <button class="btn btn-success mini_submit">إلغاء الكل</button>
                                                     </div>
                                                     <div class="">
                                                         <button class="btn btn-success mini_submit">تصفية</button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                             <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> </span> </div>
                                             <div class="d-inline-block col">
                                                 <input type="submit" class="btn btn-success w-100" value="عرض">
                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                          </div>
                          <div class="table_from_trip">
                              <div style="padding:0;  border: 2px solid #0000008a; max-height: 250px; overflow:auto">
                                  <div class="table-responsive">
                                      <table class="table table-bordered table-hover table-sm p-0 mb-0" data-page-length="50"
                                             style="text-align: center">
                                          <thead>
                                          <tr>
                                              <th>تشغيل</th>
                                              <th>التاريخ</th>
                                              <th>الوقت</th>
                                              <th>من</th>
                                              <th>إلى</th>
                                              <th>نوع الخدمة</th>
                                              <th>الحالة</th>
                                              <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          @isset($runTrips_go)
                                              @foreach ($runTrips_go as $runTrip)
                                                  <tr>
                                                      <td>{{ $runTrip->id }}</td>
                                                      <td>{{ $runTrip->startDate }}</td>
                                                      <td>{{date("g:iA", strtotime($runTrip->startTime))}}</td>
                                                      <td>@isset($runTrip) {{ $stationFrom_request->name }} @endisset</td>
                                                      <td>@isset($runTrip) {{ $stationTo_request->name }} @endisset</td>
                                                      <td>
                                                      @isset($runTrip)
                                                          @foreach($runTrip->tripData->tripDegrees as $tripDegree)
                                                                @isset($tripDegree) {{ $tripDegree->degree->name }} , @endisset
                                                          @endforeach
                                                      @endisset
                                                      </td>
                                                      <td>{{ $runTrip->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                                      <td><input type="radio" name="runTrip_go" value="{{$runTrip->id}}"></td>
                                                  </tr>
                                              @endforeach
                                           @endisset
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-6">
                          <div class="edit_from_trip">
                              <div>
                                  <form action="{{route('get_back_trips')}}" method="get" enctype="multipart/form-data">
                                      @csrf
                                      <input type="hidden" name="from_station_go" @isset($old_request->from_station_go) value="{{$old_request->from_station_go}}" @else @isset($new_request)  value="{{$new_request->from_station_go}}" @endisset @endisset>
                                      <input type="hidden" name="to_station_go" @isset($old_request->to_station_go) value="{{$old_request->to_station_go}}" @else @isset($new_request)  value="{{$new_request->to_station_go}}" @endisset @endisset>
                                      <input type="hidden" name="from_date_go" @isset($old_request->from_date_go) value="{{$old_request->from_date_go}}" @else @isset($new_request)  value="{{$new_request->from_date_go}}" @endisset @endisset>
                                      <input type="hidden" name="to_date_go" @isset($old_request->to_date_go) value="{{$old_request->to_date_go}}" @else @isset($new_request)  value="{{$new_request->to_date_go}}" @endisset @endisset>
                                      <input type="hidden" name="time_go" @isset($old_request->time_go) value="{{$old_request->time_go}}" @else @isset($new_request)  value="{{$new_request->time_go}}" @endisset @endisset>
                                      <input type="hidden" name="degree_go" @isset($old_request->degree_go) value="{{$old_request->degree_go}}" @else @isset($new_request)  value="{{$new_request->degree_go}}" @endisset @endisset>
                                      <div class="row" style="">
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> من منطقة</span> </div>
                                              <div class="d-inline-block col">
                                                  <select class="form-control mb-2" name="from_station_back" style="display:inline-block !important; height:33px; padding:3px" required>
                                                      <option value=" ">---</option>
                                                      @foreach($stations as $station)
                                                          <option value="{{$station->id}}" @isset($new_request) {{$new_request->from_station_back == $station->id ? 'selected' : ''}} @endisset>{{$station->name}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> إلى منطقة</span> </div>
                                              <div class="d-inline-block col">
                                                  <select class="form-control mb-2" name="to_station_back" style="display:inline-block !important; height:33px; padding:3px" required>
                                                      <option value=" ">---</option>
                                                      @foreach($stations as $station)
                                                          <option value="{{$station->id}}" @isset($new_request) {{$new_request->to_station_back == $station->id ? 'selected' : ''}} @endisset>{{$station->name}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row" style="">
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> من تاريخ</span> </div>
                                              <div class="d-inline-block col">
                                                  <input type="date" name="from_date_back" class="form-control mb-2" @isset($new_request) value="{{$new_request->from_date_back}}" @endisset required>
                                              </div>
                                          </div>
                                          <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                              <div class="col-9 row">
                                                  <div class="col">
                                                      <input type="radio" checked readonly>   ذهاب
                                                  </div>
                                                  <div class="col">
                                                      <input type="radio" readonly> عودة
                                                  </div>
                                              </div>
                                              <div class="col row">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row" style="">
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> إلى تاريخ</span> </div>
                                              <div class="d-inline-block col">
                                                  <input type="date" name="to_date_back" class="form-control mb-2" @isset($new_request) value="{{$new_request->to_date_back}}" @endisset required>
                                              </div>
                                          </div>

                                          <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                              <div class="col-9">
                                                  <input type="time" name="time_back" class="form-control mb-2" @isset($new_request) value="{{$new_request->time_back}}" @endisset>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row" style="">
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span>نوع الخدمة</span> </div>
                                              <div class="d-inline-block col">
                                                  <select class="form-control mb-2" name="degree_back" style="display:inline-block !important; height:33px; padding:3px">
                                                      <option value=" ">---</option>
                                                      @foreach($degrees as $degree)
                                                          <option value="{{$degree->id}}"  @isset($new_request) {{$new_request->degree_back == $degree->id ? 'selected' : ''}} @endisset>{{$degree->name}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span></span> </div>
                                              <div class="col-9 row">

                                              </div>
                                              <div class="col row">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row" style="">
                                          <div class="col row">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> </span> </div>
                                              <div class="d-inline-block col">
                                                  <div class="row m-auto justify-content-between" style="max-width: 100%">
                                                      <div class="">
                                                          <button class="btn btn-success mini_submit">تحديد الكل</button>
                                                      </div>
                                                      <div class="">
                                                          <button class="btn btn-success mini_submit">إلغاء الكل</button>
                                                      </div>
                                                      <div class="">
                                                          <button class="btn btn-success mini_submit">تصفية</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="col row" style="margin-top:auto; margin-bottom:auto;">
                                              <div class="d-inline-block col-3 label_div" style="padding-left: 0;"><span> </span> </div>
                                              <div class="d-inline-block col">
                                                  <input type="submit" class="btn btn-success w-100" value="عرض">
                                              </div>
                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                          <div class="table_from_trip">
                              <div style="padding:0;  border: 2px solid #0000008a; max-height: 250px; overflow:auto">
                                  <div class="table-responsive">
                                      <table class="table table-bordered table-hover table-sm p-0 mb-0" data-page-length="50"
                                             style="text-align: center">
                                          <thead>
                                          <tr>
                                              <th>تشغيل</th>
                                              <th>التاريخ</th>
                                              <th>الوقت</th>
                                              <th>من</th>
                                              <th>إلى</th>
                                              <th>نوع الخدمة</th>
                                              <th>الحالة</th>
                                              <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          @isset($runTrips_back)
                                              @foreach ($runTrips_back as $runTrip_back)
                                                  <tr>
                                                      <td>{{ $runTrip_back->id }}</td>
                                                      <td>{{ $runTrip_back->startDate }}</td>
                                                      <td>{{date("g:iA", strtotime($runTrip_back->startTime))}}</td>
                                                      <td>@isset($new_request) {{ $stationFrom_back_request->name }} @endisset</td>
                                                      <td>@isset($new_request) {{ $stationTo_back_request->name }} @endisset</td>
                                                      <td>
                                                          @foreach($runTrip_back->tripData->tripDegrees as $tripDegree)
                                                              @isset($tripDegree) {{ $tripDegree->degree->name }} , @endisset
                                                          @endforeach
                                                      </td>
                                                      <td>{{ $runTrip->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                                      <td><input type="checkbox" name="runTrip_back" value="{{$runTrip_back->id}}"></td>
                                                  </tr>
                                          @endforeach
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
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".messages").delay(5000).slideUp(300);
        });



        /* عشن ياخد الرحلات المتعلم عليها */
        $('input[name="runTrip_back"]').on("click", function()
        {
            if (this.checked)
            {
                $('#get_connect_runTrip').append('<input type="hidden" name="runTrips_back[]" value="'+ $(this).val() +'">');
            }
            else {
                $('input[value="'+ $(this).val() +'"][type="hidden"][name="runTrips_back[]"]').remove();
            }
        });


        /* عشن ياخد الرحلة المتعلم عليها */
        $('input[name="runTrip_go"]').on("click", function()
        {
            if (this.checked)
            {
                $('#get_connect_runTrip').append('<input type="hidden" name="runTrip_go" value="'+ $(this).val() +'">');
            }
            else {
                $('input[value="'+ $(this).val() +'"][type="hidden"][name="runTrip_go"]').remove();
            }
        });



    </script>
@endsection



