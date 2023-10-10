@extends('layouts.master')
@section('css')
@section('title')
    تشغيل الرحلة
@stop

<style>
    td{width:8%;}
    select{padding:10px !important;}
    .process
    {
        cursor:pointer;
        background-color: #d4e3f026;
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
  قائمة الرحلات المشغلة
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

                    {{--  button of add_modal_station  --}}
                    <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                        إضافة تشغيل لرحلة
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>رقم الرحلة</th>
                                <th>اسم الرحلة</th>
                                <th>توقيت الرحلة</th>
                                <th>التاريخ</th>
                                <th>اسم السائق</th>
                                <th>اسم الحافلة</th>
                                <th>اسم المضيف</th>
                                <th>نوع الرحلة</th>
                                <th>عمولة السائق</th>
                                <th>عمولة المضيف</th>
                                <th>حالة النشاط</th>
                                <th>الحالة</th>
{{--                                <th>الحالة</th>--}}
                                <th>الملاحظات</th>
                                <th>مدخل البيانات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['runTrips'] as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>@isset($item->tripData->name) {{ $item->tripData->name }} @else لا يوجد @endisset</td>
                                    <td style="width:11%">{{$item->startTime}}</td>
                                    <td style="width:11%">{{$item->startDate}}</td>
                                    <td>@isset($item->driver->name) {{ $item->driver->name }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->bus->code) {{ $item->bus->code }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->host->name) {{ $item->host->name }} @else لا يوجد @endisset</td>
                                    <td>{{ $item->type  == 1 ? 'ذهاب' : 'ذهاب وعودة' }}</td>
                                    <td>{{ $item->driverTips  !== null ? $item->driverTips : 'لا يوجد' }}</td>
                                    <td>{{ $item->hostTips  !== null ? $item->hostTips : 'لا يوجد' }}</td>
                                     <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td> @if( $item->canceled == 1) <span style="background-color:red; padding:5px; color:white;">ملغي</span> @else <span>مفعل</span> @endif </td>
{{--                                    <td>--}}
{{--                                        @if($item->active  == 1)--}}
{{--                                            @if( $item->startDate == \Carbon\Carbon::now()->format('Y-m-d'))<span style="background-color:#70c419; color:white"> قيد التنفيذ </span>--}}
{{--                                            @else <span style="background-color:#c4c40b; color:white"> مفعل </span> @endif--}}
{{--                                        @elseif($item->active  == 2) <span style="background-color:red; color:white">غير مفعل </span> @endif--}}
{{--                                    </td>--}}
                                    <td>{{ $item->notes  !== null ? $item->notes : 'لا يوجد' }}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
{{--                                        @if( $item->startDate !== \Carbon\Carbon::now()->format('Y-m-d'))--}}


                                                <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                                   data-target="#edit{{ $item->id }}" title="{{ trans('main_trans.edit') }}">
                                                   <i style="color:#a3a373; font-size:18px" class="fa fa-edit"></i></a>

                                                <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                                   data-target="#delete{{ $item->id }}" title="{{ trans('main_trans.delete') }}">
                                                   <i style="color:red; font-size:18px" class="fa fa-trash"></i></a>
{{--                                        @else--}}
{{--                                          .......--}}
{{--                                        @endif--}}

                                    </td>
                                </tr>

                                <!--  page of edit_modal_station -->
                                @include('pages.RunTrips.edit')

                                <!--  page of delete_modal_station -->
                                @include('pages.RunTrips.delete')

                            @endforeach
                        </table>

                        <div> {{$data['runTrips']->links('pagination::bootstrap-4')}}</div>

                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_station -->
       @include('pages.RunTrips.create')
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".messages").delay(5000).slideUp(300);
        });
    </script>
@endsection



