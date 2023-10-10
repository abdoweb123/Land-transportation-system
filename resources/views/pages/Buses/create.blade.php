@extends('layouts.master')
@section('css')

@section('title')
    إضافة أتوبيس
@stop

<style>
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    إضافة أتوبيس
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
                        <form action="{{ route('buses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الكود :</label>
                                    <input id="name" type="text" name="code" value="{{old('code')}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" value="{{old('name')}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">رقم الشاسيه :</label>
                                    <input id="name" type="text" name="chassis" value="{{old('chassis')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">نوع الحافلة :</label>
                                    <select name="busType_id" class="form-control" required>
                                        <option value=" ">-- اختر --</option>
                                        @foreach($busTypes as $busType)
                                            <option value="{{$busType->id}}">{{$busType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الموديل :</label>
                                    <select name="busModel_id" class="form-control" required>
                                        <option value=" ">-- اختر --</option>
                                        @foreach($busModels as $busModel)
                                            <option value="{{$busModel->id}}">{{$busModel->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">المالك :</label>
                                    <select name="busOwner_id" class="form-control" required>
                                        <option value=" ">-- اختر --</option>
                                        @foreach($busOwners as $busOwner)
                                            <option value="{{$busOwner->id}}">{{$busOwner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">شركة التأمين :</label>
                                    <select name="insuranceCompany_id" class="form-control" required>
                                        <option value=" ">-- اختر --</option>
                                        @foreach($insuranceCompanies as $insuranceCompany)
                                            <option value="{{$insuranceCompany->id}}">{{$insuranceCompany->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">البنك :</label>
                                    <select name="bank_id" class="form-control" required>
                                        <option value=" ">-- اختر --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">السائق :</label>
                                    <select name="driver_id" class="form-control">
                                        <option value=" ">-- اختر --</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">رقم الموتور : </label>
                                    <input id="name" type="text" name="motor_number" value="{{old('motor_number')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">المستندات : </label>
                                    <input id="name" type="file" multiple name="documents[]" class="form-control">
                                </div>
                                <div class="row mt-0 col-4" style="margin-left:15px; padding-left:0;">
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">بداية الرخصة :</label>
                                        <input id="name" type="date" name="licenceStart"  value="{{old('licenceStart')}}" class="form-control" required>
                                    </div>
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">انتهاء الرخصة :</label>
                                        <input id="name" type="date" name="licenceEnd"  value="{{old('licenceEnd')}}" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               <div class="row mt-0 col-4" style="margin-left:15px; padding-left:0;">
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">بداية الضرئب :</label>
                                        <input id="name" type="date" name="taxesStart"  value="{{old('taxesStart')}}" class="form-control" required>
                                    </div>
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">انتهاء الضرئب :</label>
                                        <input id="name" type="date" name="taxesEnd"  value="{{old('taxesEnd')}}" class="form-control" required>
                                    </div>
                               </div>
                                <div class="row mt-0 col-4" style="margin-left:15px; padding-left:0;">
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">بداية رخصة السائق :</label>
                                        <input id="name" type="date" name="driverLicenceStart"  value="{{old('driverLicenceStart')}}" class="form-control">
                                    </div>
                                    <div class="col-6" style="padding-left:10px">
                                        <label for="name_ar" class="mr-sm-2">انتهاء رخصة السائق :</label>
                                        <input id="name" type="date" name="driverLicenceEnd"  value="{{old('driverLicenceEnd')}}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
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




