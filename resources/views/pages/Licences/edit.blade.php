<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات نوع الرخصة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('licences.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الاسم</label>
                            <input id="name_ar" type="text" name="name" value="{{ $item->name }}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="image" class="mr-sm-2">الحالة</label>
                            <select name="active" class="form-control">
                                @if($item->active == 1)
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
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">إرسال</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
