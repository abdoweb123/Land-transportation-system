@extends('layouts.master')
@section('css')

@section('title')
    إضافة موظف
@stop

<style>
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    إضافة موظف
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
                        <form method="POST" action="{{ route('create.employee') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="3">
                            <div class="row">
                                <div class="section-field col">
                                    <label class="mb-10" for="name">الإسم :</label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" autocomplete="name" autofocus required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="mb-10" for="name">الكود :</label>
                                    <input class="form-control" name="code" required>
                                </div>
                                <div class="section-field col">
                                    <label class="mb-10" for="name">المكتب :</label>
                                    <select class="form-control mr-sm-2 p-2" name="office_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($offices as $office)
                                            <option value="{{$office->id}}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="section-field col">
                                    <label class="mb-10" for="name">البريدالالكتروني :</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}"  autocomplete="email" autofocus required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="section-field col">
                                    <label class="mb-10" for="Password">كلمة المرور :</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           autocomplete="current-password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="section-field col">
                                    <label class="mb-10" for="name">القسم :</label>
                                    <select class="form-control mr-sm-2 p-2" name="department_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="section-field col">
                                    <label class="mb-10" for="name">الوظيفة :</label>
                                    <select class="form-control mr-sm-2 p-2" name="employeeJob_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($employeeJobs as $employeeJob)
                                            <option value="{{$employeeJob->id}}">{{ $employeeJob->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="section-field col">
                                    <label class="mb-10" for="name">موقف الموظف :</label>
                                    <select class="form-control mr-sm-2 p-2" name="employeeSituation_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($employeeSituations as $employeeSituation)
                                            <option value="{{$employeeSituation->id}}">{{ $employeeSituation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="mb-10" for="name">الدرجة :</label>
                                    <select class="form-control mr-sm-2 p-2" name="degree" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        <option class="custom-select mr-sm-2 p-2" value="1">مسئول النظام</option>
                                        <option class="custom-select mr-sm-2 p-2" value="2">موظف</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label class="mb-10" for="name">تاريخ الميلاد :</label>
                                    <input type="date" class="form-control" name="birthdate" required>
                                </div>
                                <div class="col-4">
                                    <label class="mb-10" for="name">تاريخ التعيين :</label>
                                    <input type="date" class="form-control" name="appointDate" required>
                                </div>
                            </div>

{{--                            @error('type')--}}
{{--                            <span class="invalid-feedback d-inline-block" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}

                            <br><br>

                            <button class="button"><span>حفظ</span><i class="fa fa-check"></i></button>
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


