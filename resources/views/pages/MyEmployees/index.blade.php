@extends('layouts.master')
@section('css')
@section('title')
    قائمة الموظفين
@stop


<style>
    .process{border:none; border-radius:3px; padding:3px 5px;}
     select{padding:10px !important;}
    .process
    {
        cursor:pointer;
        background-color:#d4e3f026;
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
    قائمة الموظفين
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


                    <a href="{{route('myEmployees.create')}}" class="button x-small">
                        إضافة وظيفة
                    </a>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>كود الموظف</th>
                                <th>الاسم</th>
                                <th>المكتب التابع له</th>
                                <th>نقطة الانطلاق</th>
                                <th>الوظيفة</th>
                                <th>القسم</th>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>الهاتف</th>
                                <th>البريد الالكتروني</th>
                                <th>مدخل البيانات</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['myEmployees'] as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->oracle_id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>@isset($item->office->name)  {{ $item->office->name }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->collectionPoint->name)  {{ $item->collectionPoint->name }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->EmployeeJob->name)  {{ $item->EmployeeJob->name }} @else لا يوجد @endisset</td>
                                    <td>@isset($item->department->name)  {{ $item->department->name }} @else لا يوجد @endisset</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{ $item->gender == 1 ? 'ذكر' : 'أنثي'}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                    <td>{{ $item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>
                                        <a href="{{route('myEmployees.edit',$item->id)}}" class="process">
                                           <i style="color:cadetblue; font-size:18px;" class="fa fa-edit"></i></a>

                                        <button type="button" class="process" data-toggle="modal" data-target="#delete{{ $item->id }}" title="حذف">
                                           <i style="color:red; font-size:18px;" class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!--  page of delete_modal_city -->
                                @include('pages.MyEmployees.delete')

                            @endforeach
                        </table>

                        <div> {{$data['myEmployees']->links('pagination::bootstrap-4')}}</div>
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




