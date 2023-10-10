@extends('layouts.master')
@section('css')

@section('title')
    تعديل بيانات السائق
@stop

<style>
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تعديل بيانات السائق
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="modal-body">
                        <form action="{{ route('update.driver') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{$driver->id}}" name="id">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" value="{{$driver->name}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="title" class="mr-sm-2">المسمي الوظيفي :</label>
                                    <input type="text" class="form-control" value="{{$driver->title}}" name="title" required>
                                </div>
                                <div class="col">
                                    <label for="mobile" class="mr-sm-2">الهاتف :</label>
                                    <input type="text" class="form-control"  value="{{$driver->mobile}}" name="mobile" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="image" class="mr-sm-2">الصورة :</label>
                                    <input type="file" class="form-control" name="image" value="{{$driver->image}}">
                                </div>
                                <div class="col">
                                    <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                                    <input id="email" type="text" name="email" value="{{$driver->email}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="password" class="mr-sm-2">كلمة المرور :</label>
                                    <input type="password" class="form-control" name="password" value="{{$driver->password}}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="email" class="mr-sm-2">الرقم القومي :</label>
                                    <input id="email" type="text" name="nationalId" class="form-control" value="{{$driver->nationalId}}" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="city_id" class="mr-sm-2">نوع الرخصة :</label>
                                    <select class="form-control mr-sm-2 p-2" name="licenceType_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($licences as $licence)
                                            <option value="{{$licence->id}}" {{$licence->id == $driver->licenceType_id ? 'selected' : ''}}>{{ $licence->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label for="city_id" class="mr-sm-2">اسم المكتب التابع له :</label>
                                    <select class="form-control mr-sm-2 p-2" name="office_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($offices as $office)
                                            <option value="{{$office->id}}" {{$office->id == $driver->office_id ? 'selected' : ''}}>{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">تاريخ انتهاء الترخيص :</label>
                                    <input id="name" type="date" name="licence_end" class="form-control" value="{{$driver->licence_end}}" required>
                                </div>
                                <div class="col">
                                    <label for="name" class="mr-sm-2">تاريخ انتهاء الضرائب :</label>
                                    <input id="name" type="date" name="taxes_end" class="form-control" value="{{$driver->taxes_end}}" required>
                                </div>
                                <div class="col">
                                    <label for="image" class="mr-sm-2">الحالة</label>
                                    <select name="active" class="form-control">
                                        @if($driver->active == 1)
                                            <option value="1" selected>نشط</option>
                                            <option value="2">غير نشط</option>
                                        @else
                                            <option value="1">نشط</option>
                                            <option value="2" selected>غير نشط</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">حفظ</button>
                            </div>
                        </form>
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





