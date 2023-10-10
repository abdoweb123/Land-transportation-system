@extends('layouts.master')
@section('css')
@section('title')
    قائمة الحجوزات
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
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    قائمة الحجوزات
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
                            <div class="alert alert-{{$msg}}">
                                {{Session::get('alert-'.$msg)}}
                            </div>
                        @endif
                    @endforeach


{{--                    <a href="{{route('reservationBookingRequests.create')}}" class="button x-small">--}}
{{--                        إضافة حجز--}}
{{--                    </a>--}}
{{--                    <br><br>--}}

{{--                    <div class="line mb-3" style="border-bottom: 1px solid #e9ecef; padding-bottom:30px">--}}
{{--                    </div>--}}
{{--                     <form action="{{route('reservationBookingRequests.index')}}" method="get" enctype="multipart/form-data">--}}
{{--                        <div class="row mb-5">--}}
{{--                            <div class="col">--}}
{{--                                <label for="name_ar" class="mr-sm-2">محطة الانطلاق :</label>--}}
{{--                                <select class="form-control mr-sm-2 p-2" name="stationFrom_id">--}}
{{--                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                    @foreach($stations as $station)--}}
{{--                                        <option value="{{$station->id}}">{{ $station->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <label for="name_ar" class="mr-sm-2">محطة الوصول :</label>--}}
{{--                                <select class="form-control mr-sm-2 p-2" name="stationTo_id">--}}
{{--                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                    @foreach($stations as $station)--}}
{{--                                        <option value="{{$station->id}}">{{ $station->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <label for="name_ar" class="mr-sm-2">التاريخ :</label>--}}
{{--                                <input class="form-control" type="text" id="datepicker-action" name="date" data-date-format="yyyy-mm-dd" style="padding:13px">--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <label for="name_ar" class="mr-sm-2"> </label>--}}
{{--                                <input type="submit" value="ابحث" class="btn btn-success form-control" style="background-color: #84ba3f; color: white; font-size: 16px; padding:12px; margin-top: 5px;">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        </form>--}}


                        <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الرحلة</th>
                                <th>اسم الرحلة</th>
                                <th>اسم العميل</th>
                                <th>محطة الانطلاق</th>
                                <th>محطة الوصول</th>
                                <th>كود الكوبون</th>
                                <th>العنوان</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reservationBookingRequests as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>@isset($item->runTrip->id)  {{ $item->runTrip->id }} @else _____ @endisset</td>
                                    <td>@isset($item->tripData->name)  {{ $item->tripData->name }} @else _____ @endisset</td>
                                    <td>@isset($item->user->name)  {{ $item->user->name }} @else _____ @endisset</td>
                                    <td>@isset($item->stationFrom->name)  {{ $item->stationFrom->name }} @else _____ @endisset</td>
                                    <td>@isset($item->stationTo->name)  {{ $item->stationTo->name }} @else _____ @endisset</td>
                                    <td>@isset($item->coupon->code)  {{ $item->coupon->code }} @else _____ @endisset</td>
                                    <td>{{$item->address == null ? '_____' : $item->address}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____ @endisset</td>
                                    <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>
                                        <a href="{{route('reservationBookingRequests.edit',$item->id)}}" class="process">
                                           <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></a>

                                        <button type="button" class="process" data-toggle="modal" data-target="#delete{{ $item->id }}" title="حذف">
                                           <i style="color:red; font-size:18px;" class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!--  page of delete_modal_city -->
                                @include('pages.ReservationBookingRequests.delete')

                            @endforeach
                        </table>

                        <div> {{$reservationBookingRequests->links('pagination::bootstrap-4')}}</div>
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
            $(".alert").delay(5000).slideUp(300);
        });
    </script>
@endsection




