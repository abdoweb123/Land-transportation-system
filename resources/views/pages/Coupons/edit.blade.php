@extends('layouts.master')
@section('css')
@section('title')
    تعديل بيانات الكوبون
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تعديل بيانات الكوبون
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
                        <form action="{{ route('coupons.update', $coupon->id) }}" method="post">
                            {{ method_field('patch') }}
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الكود:</label>
                                    <input id="name" type="text" name="code" value="{{$coupon->code}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="mr-sm-2" style="display:block">الخصم:</label>
                                    <input type="text" class="form-control" name="amount" value="{{$coupon->amount}}" style="display:inline-block; width:88%" required>
                                    <select name="percent" class="percent" style="height:42px" required>
                                        @if($coupon->percent == 0)
                                            <option value="0" selected>%</option>
                                            <option value="1">جنيه</option>
                                        @else
                                            <option value="1" selected>جنيه</option>
                                            <option value="0">%</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row max_amount" style="@if($coupon->percent == 0) display:block; @else display:none; @endif">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">أكبر قيمة للخصم:</label>
                                    <input id="name" type="text" name="max_amount"  value="{{$coupon->max_amount}}" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">تاريخ البداية:</label>
                                    <input id="name" type="date" name="startDate"  value="{{$coupon->startDate}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">تاريخ النهاية:</label>
                                    <input id="name" type="date" name="endDate"  value="{{$coupon->endDate}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">العدد الكلي للأشخاص:</label>
                                    <input id="name" type="text" name="max_users"  value="{{$coupon->max_users}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2">اسم الرحلة:</label>
                                        </div>
                                        <div class="col">
                                            <label for="name_ar" class="mr-sm-2 mx-0">الكل</label>
                                            <input type="checkbox" name="allTrips">
                                        </div>
                                    </div>
                                    <select name="trips[]" multiple class="form-control trips" style="padding:10px; display:inline-block">
                                        @foreach($trips as $trip)
                                            <option value="{{$trip->id}}"  @foreach ($coupon->couponTrips as $tripData) {{$trip->id == $tripData->tripData_id ? 'selected' : ''}}  @endforeach>{{$trip->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2"> العدد الأقصى لكل مستخدم :</label>
                                    <input id="name" type="text" name="max_per_user"  value="{{$coupon->max_per_user}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2"> نوع العميل :</label>
                                    <select name="customerType_id" class="form-control" style="padding:10px">
                                        <option disabled>-- اختر النوع --</option>
                                        @foreach($customerTypes as $customerType)
                                            <option value="{{$customerType->id}}" {{$customerType->id == $coupon->customerType->id ? 'selected' : ''}}>{{$customerType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الملاحظات:</label>
                                    <textarea name="notes" rows="6" class="form-control">{{$coupon->notes}}</textarea>
                                </div>
                            </div>
                            <br><br>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main_trans.close') }}</button>
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


            // To hide div max_amount when ...
            $('.percent').change(function (){
                if ( $($(this).val() == '1') ){      // جنيه
                    $('.max_amount').slideToggle();            // اخفيه
                }
                else {       // %
                    $('.max_amount').slideToggle();           // اظهره
                }

            });

        });


    </script>
@endsection








