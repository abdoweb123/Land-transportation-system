
@extends('layouts.master')
@section('css')

@section('title')
   عرض بيانات السائق
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    عرض بيانات السائق
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
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

                    <div class="card-body">
                        <div class="tab nav-border">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                       role="tab" aria-controls="home-02"
                                       aria-selected="true">عرض بيانات السائق</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02"
                                       role="tab" aria-controls="profile-02"
                                       aria-selected="false">عرض ملفات السائق</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                     aria-labelledby="home-02-tab">
                                    <table class="table table-striped table-hover" style="text-align:center">
                                        <tbody>
                                        <tr>
                                            <th scope="row">الاسم</th>
                                            <td>{{ $driver->name }}</td>
                                            <th scope="row">المسمي الوظيفي</th>
                                            <td>{{$driver->title}}</td>
                                            <th scope="row">الهاتف</th>
                                            <td>{{$driver->mobile}}</td>
                                            <th scope="row">البريد الإلكتروني</th>
                                            <td>{{$driver->email}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">الرقم القومي</th>
                                            <td>{{ $driver->nationalId }}</td>
                                            <th scope="row">نوع الرخصة</th>
                                            <td>{{$driver->licenceType->name}}</td>
                                            <th scope="row">اسم المكتب التابع له</th>
                                            <td>{{$driver->office->name}}</td>
                                            <th scope="row">تاريخ انتهاء الترخيص</th>
                                            <td>{{ $driver->licence_end}}</td>
                                        </tr>

                                        <tr style="width:100%">
                                            <th scope="row">تاريخ انتهاء الضرائب</th>
                                            <td>{{$driver->taxes_end}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="profile-02" role="tabpanel"
                                     aria-labelledby="profile-02-tab">
                                    <div class="card card-statistics">
                                        <div class="card-body">
                                            <form method="post" action="{{route('Upload_driver_attachment')}}" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="academic_year">إضافة مرفقات : <span class="text-danger">*</span></label>
                                                            <input type="file" accept="image/*" name="documents[]" multiple required>
                                                            <input type="hidden" name="driver_id" value="{{$driver->id}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="button button-border x-small mt-3">
                                                            حفظ البيانات
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <br>
                                        <table class="table center-aligned-table mb-0 table table-hover"
                                               style="text-align:center">
                                            <thead>
                                            <tr class="table-secondary">
                                                <th scope="col">#</th>
                                                <th scope="col">اسم المرفق</th>
                                                <th scope="col">تاريخ الإضافة</th>
                                                <th scope="col">العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($driver->driverAttachments as $attachment)
                                                <tr style='text-align:center;vertical-align:middle'>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$attachment->name}}</td>
                                                    <td>{{$attachment->created_at->diffForHumans()}}</td>
                                                    <td colspan="2">
                                                        <a class="btn btn-outline-info btn-sm"
                                                           href="{{url('download/file/driver',$attachment->id)}}"
                                                           role="button" style="margin-left:5px"><i class="ti-download"></i>&nbsp; تنزيل</a>

                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#soft_delete_img{{ $attachment->id }}"
                                                                title="{{ trans('Grades_trans.Delete') }}" style="margin-left:5px">
                                                            <i class="ti-trash"></i>&nbsp;   حذف جزئي
                                                        </button>


                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#force_delete_img{{ $attachment->id }}"
                                                                title="{{ trans('Grades_trans.Delete') }}" style="margin-left:5px">
                                                            <i class="ti-trash"></i>&nbsp;   حذف كلي
                                                        </button>

                                                    </td>
                                                </tr>
                                                @include('pages.Drivers.soft_delete_attachment')
                                                @include('pages.Drivers.force_delete_attachment')
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- row closed -->
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


