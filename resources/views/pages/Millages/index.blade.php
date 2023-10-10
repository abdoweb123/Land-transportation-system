@extends('layouts.master')
@section('css')
@section('title')
   دليل الخصومات
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
    دليل الخصومات
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

                    {{--  button of add_modal_city  --}}
                    <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                        إضافة خصم
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نوع الخصم</th>
                                <th>عدد الوحدات</th>
                                <th>الكوبون التابع له</th>
                                <th>مدخل البيانات</th>
                                <th>{{ trans('main_trans.processes') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($millages as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>@if($item->type == 1) المسافة المقطوعة @elseif($item->type == 2) المبلغ المدفوع @elseif($item->type == 3) عدد الرحلات @endif</td>
                                    <td>{{ $item->minimum }}&nbsp; <span> @if($item->type == 1) ك.م @elseif($item->type == 2) جنيه @elseif($item->type == 3) رحلة @endif</span></td>
                                    <td>@isset($item->coupon->code)  {{ $item->coupon->code }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#edit{{ $item->id }}" title="{{ trans('main_trans.edit') }}">
                                           <i style="color:#a3a373; font-size:18px" class="fa fa-edit"></i></a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#delete{{ $item->id }}" title="{{ trans('cities_trans.delete') }}">
                                           <i style="color:red; font-size:18px" class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!--  page of edit_modal_city -->
                                @include('pages.Millages.edit')

                                <!--  page of delete_modal_city -->
                                @include('pages.Millages.delete')

                            @endforeach
                        </table>

                        <div> {{$millages->links('pagination::bootstrap-4')}}</div>
                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_city -->
       @include('pages.Millages.create')
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



