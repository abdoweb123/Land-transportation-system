<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات إعداد الحجز
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('settings.update',$item->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الوقت المسموح فيه التعديل :</label>
                            <input type="text" name="time_to_edit" value="{{$item->time_to_edit}}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">الوقت المسموح للتعديل بدون غرامة :</label>
                            <input type="text" name="time_to_edit_without_fee" value="{{$item->time_to_edit_without_fee}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">غرامة التعديل :</label>
                            <input type="text" name="editFee" value="{{$item->editFee}}" class="form-control">
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">غرامة الإلغاء :</label>
                            <input type="text" name="cancelFee" value="{{$item->cancelFee}}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الحالة :</label>
                            <select name="active" class="form-control">
                                @if($item->active == 1)
                                    <option value="1" selected>نشط</option>
                                    <option value="0">غير نشط</option>
                                @else
                                    <option value="1">نشط</option>
                                    <option value="0" selected>غير نشط</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
