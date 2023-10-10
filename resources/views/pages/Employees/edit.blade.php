@extends('layouts.master')
@section('css')

@section('title')
    تعديل بيانات الموظف
@stop

<style>
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تعديل بيانات الموظف
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
                        <form method="POST" action="{{ route('update.employee') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$employee->id}}">
                            <input type="hidden" name="type" value="3">
                            <div class="row">
                                <div class="section-field col">
                                    <label class="mb-10" for="name">الإسم :</label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name', $employee->name) }}" autocomplete="name" autofocus required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="mb-10" for="name">الكود :</label>
                                    <input class="form-control" name="code" value="{{$employee->code}}" required>
                                </div>
                                <div class="section-field col">
                                    <label class="mb-10" for="name">المكتب :</label>
                                    <select class="form-control mr-sm-2 p-2" name="office_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($offices as $office)
                                            <option value="{{$office->id}}" {{$office->id == $employee->office_id ? 'selected' : ''}}>{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="section-field col">
                                    <label class="mb-10" for="name">البريدالالكتروني :</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email',$employee->email) }}"  autocomplete="email" autofocus required>
                                    <input type="hidden" value="" name="type">
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
                                           autocomplete="current-password" value="{{$employee->password}}" required>
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
                                            <option value="{{$department->id}}" {{$department->id == $employee->department_id ? 'selected' : ''}}>{{ $department->name }}</option>
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
                                            <option value="{{$employeeJob->id}}"  {{$employeeJob->id == $employee->employeeJob_id ? 'selected' : ''}}>{{ $employeeJob->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="section-field col">
                                    <label class="mb-10" for="name">موقف الموظف :</label>
                                    <select class="form-control mr-sm-2 p-2" name="employeeSituation_id" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        @foreach($employeeSituations as $employeeSituation)
                                            <option value="{{$employeeSituation->id}}"  {{$employeeSituation->id == $employee->employeeSituation_id ? 'selected' : ''}}>{{ $employeeSituation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="mb-10" for="name">الدرجة :</label>
                                    <select class="form-control mr-sm-2 p-2" name="degree" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        <option class="custom-select mr-sm-2 p-2" value="1" {{$employee->degree == 1 ? 'selected' : ''}}>مسئول النظام</option>
                                        <option class="custom-select mr-sm-2 p-2" value="2" {{$employee->degree == 2 ? 'selected' : ''}}>موظف</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label class="mb-10" for="name">تاريخ الميلاد :</label>
                                    <input type="date" class="form-control" name="birthdate" value="{{$employee->birthdate}}" required>
                                </div>
                                <div class="col-4">
                                    <label class="mb-10" for="name">تاريخ التعيين :</label>
                                    <input type="date" class="form-control" name="appointDate" value="{{$employee->appointDate}}" required>
                                </div>
                                <div class="col">
                                    <label class="mb-10" for="name">الحالة :</label>
                                    <select class="form-control mr-sm-2 p-2" name="active" required>
                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                        <option class="custom-select mr-sm-2 p-2" value="1" {{$employee->active == 1 ? 'selected' : ''}}>نشط</option>
                                        <option class="custom-select mr-sm-2 p-2" value="2" {{$employee->active == 2 ? 'selected' : ''}}>غير نشط</option>
                                    </select>
                                </div>
                            </div>

                            @error('type')
                            <span class="invalid-feedback d-inline-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

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








{{--<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"--}}
{{--     aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">--}}
{{--                    تعديل بيانات الموظف--}}
{{--                </h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <!-- add_form -->--}}
{{--                <form method="POST" action="{{ route('update.employee') }}" enctype="multipart/form-data">--}}
{{--                    @csrf--}}
{{--                    @method('PUT')--}}
{{--                    <input type="hidden" name="id" value="{{$item->id}}">--}}

{{--                    <div class="row">--}}
{{--                        <div class="section-field mb-20 col">--}}
{{--                            <label class="mb-10" for="name">الإسم*</label>--}}
{{--                            <input class="form-control @error('name') is-invalid @enderror" name="name"--}}
{{--                                   value="{{ $item->name }}" autocomplete="name" autofocus>--}}
{{--                            <input type="hidden" value="" name="type">--}}
{{--                            @error('name')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="section-field mb-20 col">--}}
{{--                            <label class="mb-10" for="name">المكتب *</label>--}}
{{--                            <select class="form-control mr-sm-2 p-2" name="office_id">--}}
{{--                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر اسم المكتب ---</option>--}}
{{--                                @foreach($offices as $office)--}}
{{--                                    <option value="{{$office->id}}" {{$office->id == $item->office_id ? 'selected' : ''}}>{{ $office->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="section-field mb-20 col">--}}
{{--                            <label class="mb-10" for="name">البريدالالكتروني*</label>--}}
{{--                            <input id="email" type="email"--}}
{{--                                   class="form-control @error('email') is-invalid @enderror" name="email"--}}
{{--                                   value="{{ $item->email }}"  autocomplete="email" autofocus>--}}

{{--                            @error('email')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="section-field mb-20 col">--}}
{{--                            <label class="mb-10" for="Password">كلمة المرور * </label>--}}
{{--                            <input id="password" type="password"--}}
{{--                                   class="form-control @error('password') is-invalid @enderror" name="password"--}}
{{--                                   value="{{$item->password}}" autocomplete="current-password">--}}

{{--                            @error('password')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <input type="hidden" name="type" value="3">--}}
{{--                    @error('type')--}}
{{--                    <span class="invalid-feedback d-inline-block" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                    @enderror--}}

{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>--}}
{{--                        <button type="submit" class="btn btn-success">تعديل</button>--}}
{{--                    </div>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
