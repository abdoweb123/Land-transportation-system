@extends('layouts.master')
@section('css')
@section('title')
    تقارير التدفق المالي
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   تقارير التدفق المالي
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="ddd">
                <!-- widgets -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-right">
                                    <span class="text-success">
                                        <i class="fa fa-dollar highlight-icon" aria-hidden="true"></i>
                                    </span>
                                    </div>
                                    <div class="float-left text-right">
                                        <p class="card-text text-dark">إجمالي المبالغ الواردة</p>
                                        <h4 class="text-center">{{$less_type1}} جنيها </h4>
                                    </div>
                                </div>
                                <p class="text-muted pt-3 mb-0 mt-2 border-top">
                                    <i class="fa fa-calendar mr-1" aria-hidden="true"></i> الإجمالي على مدار العمل
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-right">
                                    <span class="text-success">
                                        <i class="fa fa-dollar highlight-icon" aria-hidden="true"></i>
                                    </span>
                                    </div>
                                    <div class="float-left text-right">
                                        <p class="card-text text-dark">إجمالي المبالغ الصادرة</p>
                                        <h4 class="text-center">{{$less_type2}}  جنيها </h4>
                                    </div>
                                </div>
                                <p class="text-muted pt-3 mb-0 mt-2 border-top">
                                    <i class="fa fa-calendar mr-1" aria-hidden="true"></i> الإجمالي على مدار العمل
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

{{--                    <div class="row mt-1">--}}
{{--                        <div class="col-4">--}}
{{--                            <a href="#" class="btn btn-secondary">إجمالي المبالغ الواردة</a> <a href="#" class="btn btn-success">{{$less_type1}}</a>--}}
{{--                        </div>--}}
{{--                        <div class="col-4">--}}
{{--                            <a href="#" class="btn btn-secondary">إجمالي المبالغ الصادرة</a> <a href="#" class="btn btn-success">{{$less_type2}}</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المبلغ</th>
                                <th>التصنيف</th>
                                <th>التذكرة الجديدة</th>
                                <th>الوصف</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                                <th>مدخل البيانات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($less as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{$item->type == 1 ? 'وارد' : 'صادر'}}</td>
                                    <td>{{ $item->ticket_id == null ? '_____' : $item->ticket_id}}</td>
                                    <td>{{ $item->action == null ? '_____' : $item->action }}</td>
                                    <td>{{ $item->created_at}}</td>
                                    <td>{{$item->active == 1 ? 'نشط' : 'غير نشط'}}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____ @endisset</td>
                                </tr>
                            @endforeach
                        </table>

                        <div> {{$less->links('pagination::bootstrap-4')}}</div>

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
            $(".messages").delay(5000).slideUp(300);
        });
    </script>
@endsection



