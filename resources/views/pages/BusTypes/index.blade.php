@extends('layouts.master')
@section('css')
@section('title')
    دليل الماركات
@stop

<style>
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
    دليل الماركات
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
                            @foreach ($errors->all() as $error)
                                <div>
                                  {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif


                    @foreach(['danger','warning','success','info'] as $msg)
                        @if(Session::has('alert-'.$msg))
                            <div class="alert alert-{{$msg}}">
                                {{Session::get('alert-'.$msg)}}
                            </div>
                        @endif
                    @endforeach

                    {{--  button of add_modal_city  --}}
                    <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                        إضافة ماركة
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الماركة</th>
                                <th>طول الحافلة</th>
                                <th>عرض الحافلة</th>
                                <th>عدد المقاعد</th>
                                <th>الحالة</th>
                                <th>مدخل البيانات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($busTypes as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->length }}</td>
                                    <td>{{ $item->width }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        <a href="{{route('show.busType.seats',$item->id)}}" class="process" style="cursor:pointer">
                                            <i style="color:green; font-size:18px;" class="fa fa-eye"></i>&nbsp; عرض التصميم</a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#edit{{ $item->id }}" title="تعديل">
                                           <i style="color:#a3a373; font-size:18px;" class="fa fa-edit"></i></a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#delete{{ $item->id }}" title="حذف">
                                           <i style="color:red; font-size:18px;" class="fa fa-trash"></i></a>

                                    </td>
                                </tr>

                                <!--  page of edit_modal_BusTypes -->
                                @include('pages.BusTypes.edit')

                                <!--  page of delete_modal_BusTypes -->
                                @include('pages.BusTypes.delete')


                                <!--  page of show_modal_BusTypes -->
                                @include('pages.BusTypes.show')

                            @endforeach
                        </table>

                        <div> {{$busTypes->links('pagination::bootstrap-4')}}</div>
                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_city -->
       @include('pages.BusTypes.create')
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



