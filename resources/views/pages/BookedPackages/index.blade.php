@extends('layouts.master')
@section('css')
@section('title')
    دليل الاشتراكات المحجوزة
@stop



{{-- start select with live search --}}
{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>--}}
<link rel="stylesheet" href="{{asset('css/hierarchy-select.min.css')}}">
<link rel="stylesheet" href="{{asset('css/demo.css')}}">
{{-- end select with live search --}}

<style>
    .search-boxx{transform: translate3d(270px, 33px, 0px) !important;}
    .process{border:none; border-radius:3px;}
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
    دليل الاشتراكات المحجوزة
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
                    <button type="button" class="button x-small create-package" data-toggle="modal" data-target="#exampleModal">
                        حجز اشتراك
                    </button>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الاشتراك</th>
                                <th>اسم المستخدم</th>
                                <th>التاريخ</th>
                                <th>عدد مرات الاستخدام</th>
                                <th>الحالة</th>
                                <th>مدخل البيانات</th>
                                <th>{{ trans('main_trans.processes') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bookedPackages as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>@isset($item->package->title)  {{ $item->package->title }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->user->name)  {{ $item->user->name }} @else لا يوجد @endisset</td>
                                    <td>{{ $item->startDate }}</td>
                                    <td>{{ $item->used }}</td>
                                    <td>{{$item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>
                                        <a  class="process" style="cursor:pointer; padding: 3px 3px 0px 4px;"
                                           href="{{route('bookedPackages.edit',$item->id)}}" title="{{ trans('main_trans.edit') }}">
                                           <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#delete{{ $item->id }}" title="{{ trans('cities_trans.delete') }}">
                                           <i style="color:red; font-size:18px;" class="fa fa-trash"></i></a>

                                    </td>
                                </tr>


                                <!--  page of delete_modal_city -->
                                @include('pages.BookedPackages.delete')


                            @endforeach
                        </table>

                        <div> {{$bookedPackages->links('pagination::bootstrap-4')}}</div>
                    </div>


                </div>
            </div>
        </div>


       <!--  page of add_modal_city -->
       @include('pages.BookedPackages.create')
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);


            // for live search with select

                $('#example').hierarchySelect({
                    hierarchy: false,
                    width: 'auto'
                });

        });
    </script>


{{-- start select with live search --}}
{{--    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
    <script src="{{{asset('js/hierarchy-select.min.js')}}}"></script>
{{-- end select with live search --}}

@endsection



