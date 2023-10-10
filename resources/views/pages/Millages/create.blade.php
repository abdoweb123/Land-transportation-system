<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة خصم
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('millages.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">نوع الخصم :</label>
                            <select name="type" class="form-control" style="padding:10px" required>
                                <option value=" ">-- اختر النوع --</option>
                                <option value="1">المسافة</option>
                                <option value="2">المبلغ المدفوع</option>
                                <option value="3">عدد الرحلات</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">عدد الوحدات :</label>
                            <input type="text" class="form-control" name="minimum" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">كود الكوبون :</label>
                            <select name="coupon_id" class="form-control" style="padding:10px" required>
                                <option value=" ">-- اختر النوع --</option>
                                @foreach($coupons as $coupon)
                                    <option value="{{ $coupon->id }}">{{$coupon->code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('main_trans.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
