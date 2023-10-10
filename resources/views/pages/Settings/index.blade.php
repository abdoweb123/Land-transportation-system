@extends('layouts.master')
@section('css')
@section('title')
    إعدادات التشغيل
@stop

<style>
    select{padding:10px !important;}
    button{padding: 5px 3px 0 4px; margin-left: 5px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   إعدادات التشغيل
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

                    {{--  button of add_modal_office  --}}
                    <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                        إضافة إعداد
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الوقت المسموح فيه التعديل</th>
                                <th>الوقت المسموح فيه التعديل بدون غرامة</th>
                                <th>غرامة التعديل</th>
                                <th>غرامة الإلغاء</th>
                                <th>الحالة</th>
                                <th>مدخل البيانات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($settings as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->time_to_edit }} </td>
                                    <td>{{ $item->time_to_edit_without_fee }} </td>
                                    <td>{{ $item->editFee }} </td>
                                    <td>{{ $item->cancelFee }} </td>
                                    <td>{{$item->active == 1 ? 'نشط' : 'غير نشط'}} </td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        <button type="button" class="process" style="cursor:pointer; background-color:#d4e3f026; border-radius:3px; border: 1px solid #dddd;"
                                                data-toggle="modal" data-target="#edit{{ $item->id }}" title="تعديل">
                                            <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></button>

                                        <button type="button" class="process" style="cursor:pointer; background-color:#d4e3f026; border-radius:3px; border: 1px solid #dddd;"
                                                data-toggle="modal" data-target="#delete{{ $item->id }}" title="حذف">
                                            <i style="color:red; font-size:18px;" class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!--  page of edit_modal_office -->
                                @include('pages.Settings.edit')

                                <!--  page of delete_modal_office -->
                                @include('pages.Settings.delete')




                            @endforeach
                        </table>

                        <div> {{$settings->links('pagination::bootstrap-4')}}</div>

                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_office -->
       @include('pages.Settings.create')
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



