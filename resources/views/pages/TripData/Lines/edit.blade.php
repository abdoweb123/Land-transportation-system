<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                تعديل خط الرحلة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('update.line') }}" method="post">
                    @csrf
                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب * :</label>
                            <input type="number" class="form-control" name="priceGo" value="{{$item->priceGo}}">
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب والعودة * :</label>
                            <input type="number" class="form-control" name="priceBack" value="{{$item->priceBack}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب للأجانب * :</label>
                            <input type="number" class="form-control" name="priceForeignerGo" value="{{$item->priceForeignerGo}}">
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب والعودة للأجانب * :</label>
                            <input type="number" class="form-control" name="priceForeignerBack" value="{{$item->priceForeignerBack}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">غرامة إلغاء الرحلة * :</label>
                            <input type="number" class="form-control" name="cancelFee" value="{{$item->cancelFee}}">
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">غرامة تعديل الرحلة * :</label>
                            <input type="number" class="form-control" name="editFee" value="{{$item->editFee}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">الحالة * :</label>
                            <select class="form-control mr-sm-2 p-2" name="active">
                                <option class="custom-select mr-sm-2 p-2" disabled>--- اختر من القائمة ---</option>
                                <option value="{{$item->active}}">{{$item->active  == 1 ? 'نشط' : 'غير نشط'}}</option>
                                @if($item->active == 1)
                                    <option value="2">غير نشط</option>
                                @else
                                    <option value="1">نشط</option>
                                @endif
                            </select>
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
