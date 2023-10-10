@extends('layouts.master')
@section('css')
@section('title')
   تقارير التذاكر الشاملة
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
    #datatable_filter{display:none}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تقارير التذاكر الشاملة
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

                     <form action="{{route('search_tickets_by_date_office')}}" method="get" enctype="multipart/form-data">
                        @csrf

                         <div class="row mb-5">
                            <div class="col">
                                <label for="name_ar" class="mr-sm-2">من :</label>
                                <input type="date" name="date_from" value="@isset($request){{$request->date_from}}@endisset" class="form-control">
                            </div>
                             <div class="col">
                                <label for="name_ar" class="mr-sm-2">إلى :</label>
                                <input type="date" name="date_to" value="@isset($request){{$request->date_to}}@endisset" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_ar" class="mr-sm-2">المكتب :</label>
                                <select class="form-control mr-sm-2 p-2" name="office_id" style="height: 65%;">
                                    <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                    @foreach($offices as $office)
                                        <option value="{{$office->id}}" @isset($request){{ $office->id == $request->office_id ? 'selected' : ''}}@endisset>{{ $office->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col">
                                 <label for="name_ar" class="mr-sm-2"> </label>
                                 <input type="submit" value="ابحث" class="btn btn-success form-control" style="background-color: #84ba3f; color: white; font-size: 16px; padding:12px; margin-top: 5px;">
                             </div>
                        </div>

                        </form>


                        <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم التذكرة</th>
                                <th>رقم الرحلة</th>
                                <th>اسم الرحلة</th>
                                <th>اسم العميل</th>
                                <th>محطة الانطلاق</th>
                                <th>محطة الوصول</th>
                                <th>نوع التذكرة</th>
                                <th>إجمالي المدفوع</th>
                                <th>مدخل البيانات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($tickets)
                                @foreach ($tickets as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->runTrip_id }}</td>
                                        <td>@isset($item->tripData->name) {{ $item->tripData->name }} @else ____ @endisset</td>
                                        <td>@isset($item->user->name) {{ $item->user->name }} @else ____ @endisset</td>
                                        <td>@isset($item->stationFrom->name) {{ $item->stationFrom->name }} @else ____ @endisset</td>
                                        <td>@isset($item->stationTo->name) {{ $item->stationTo->name }} @else ____ @endisset</td>
                                        <td>{{ $item->type == 1 ? 'ذهاب' : 'ذهاب وعودة' }}</td>
                                        <td>{{ $item->sub_total }}</td>
                                        <td>@isset($item->admin->name)  {{ $item->admin->name }} @else ____ @endisset</td>
                                    </tr>

                                @endforeach
                            @endisset
                        </table>
                        @isset($tickets)
                        <div> {{$tickets->links('pagination::bootstrap-4')}}</div>
                         @endisset
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




