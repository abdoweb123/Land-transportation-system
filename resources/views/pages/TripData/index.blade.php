@extends('layouts.master')
@section('css')
@section('title')
    دليل الرحلات
@stop
@endsection

@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   دليل الرحلات
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
                        إضافة رحلة
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الرحلة</th>
                                <th>اسم الأسطول</th>
                                <th>درجة الرحلة</th>
                                <th>الملاحظات</th>
                                <th>حالة النشاط</th>
                                <th>مدخل البيانات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tripData as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><a href="{{route('getStationsOfTrip',$item->id)}}" style="color:red">{{ $item->name}}</a></td>
                                    <td>@isset($item->busType->name)  {{ $item->busType->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        @foreach($item->tripDegrees as $degree_id)
                                            {{$degree_id->degree->name}} ,
                                        @endforeach
                                    </td>
                                    <td>{{ $item->notes  == null ? 'لا يوجد' : $item->notes }}</td>
                                    <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        <div class="dropdown show">
                                            <a class="btn btn-success btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                الإجراءات
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a type="button" class="dropdown-item" style="cursor:pointer" data-toggle="modal"
                                                   data-target="#edit{{ $item->id }}" title="{{ trans('main_trans.edit') }}">
                                                   <i style="color:#a3a373" class="fa fa-edit"></i>&nbsp; تعديل</a>

{{--                                                <a type="button" class="dropdown-item" style="cursor:pointer" data-toggle="modal"--}}
{{--                                                   data-target="#delete{{ $item->id }}" title="{{ trans('main_trans.delete') }}">--}}
{{--                                                   <i style="color:red" class="fa fa-trash"></i>&nbsp; حذف</a>--}}

                                                <a type="button" class="dropdown-item" style="cursor:pointer" href="{{route('getStationsOfTrip',$item->id)}}">
                                                    <i style="color:green" class="fa fa-eye"></i>&nbsp; عرض المحطات</a>

                                                <a type="button" class="dropdown-item" style="cursor:pointer" href="{{route('getAllLinesOfTrip',$item->id)}}">
                                                    <i style="color:goldenrod" class="fa fa-eye"></i>&nbsp; عرض الخطوط</a>


                                                <a type="button" class="dropdown-item" style="cursor:pointer" data-toggle="modal"
                                                   data-target="#edit_paymentMethods{{ $item->id }}">
                                                    <i style="color:#a3a373" class="fa fa-money"></i>&nbsp; وسائل الدفع </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                @include('pages.TripData.edit')


                                @include('pages.TripData.PaymentMethods.edit_paymentMethods')


                                @include('pages.TripData.delete')


                                <!--  page of show_modal_station -->
{{--                                @include('pages.TripData.show')--}}

                            @endforeach
                        </table>

                        <div> {{$tripData->links('pagination::bootstrap-4')}}</div>

                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_station -->
       @include('pages.TripData.create')
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



