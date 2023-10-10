@extends('layouts.master')
@section('css')
@section('title')
    بيانات الأتوبيسات
@stop

<style>

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
    بيانات الأتوبيسات
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
                    <a href="{{route('buses.create')}}" type="button" class="button x-small">
                        إضافة حافلة
                    </a>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الكود</th>
                                <th>الاسم</th>
                                <th>الأسطول التابع له</th>
                                <th>السائق</th>
                                <th>الحالة</th>
                                <th>مدخل البيانات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($buses as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><a href="{{route('show.bus.seats',$item->id)}}" style="color:red"> {{ $item->busType->name }} </a> </td>
                                    <td>@isset($item->driver->name)  {{ $item->driver->name }} @else _____ @endisset</td>
                                    <td>{{$item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____ @endisset</td>
                                    <td>

                                    <a href="{{route('buses.show',$item->id)}}" class="process" style="cursor:pointer" >
                                        <i style="color:green; font-size:18px;" class="fa fa-eye"></i></a>


                                    <a href="{{route('buses.edit',$item->id)}}" class="process" style="cursor:pointer" >
                                       <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></a>


                                    <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                       data-target="#delete{{ $item->id }}" title="حذف">
                                       <i style="color:red; font-size:18px;" class="fa fa-trash"></i></a>

                                    </td>
                                </tr>

                                <!--  page of delete_modal_city -->
                                @include('pages.Buses.delete')


                            @endforeach
                        </table>

                        <div> {{$buses->links('pagination::bootstrap-4')}}</div>
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



