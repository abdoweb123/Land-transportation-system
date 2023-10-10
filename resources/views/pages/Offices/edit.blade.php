<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات المكتب
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('offices.update','test') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">الاسم باللغة العربية :</label>
                            <input id="Name" type="text" name="name_ar" class="form-control" value="{{ $item->getTranslation('name', 'ar') }}" required>
                            <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                        </div>
                        <div class="col">
                            <label for="Name_en" class="mr-sm-2">الاسم باللغة الإنجليزية :</label>
                            <input type="text" class="form-control" value="{{ $item->getTranslation('name', 'en') }}" name="name_en" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="station_id" class="mr-sm-2">اسم المحطة التابع لها :</label>
                            <select class="form-control mr-sm-2 p-2" name="station_id" required>
                                <option class="custom-select mr-sm-2 p-2" disabled>--- اختر اسم المحطة ---</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}" {{$station->id == $item->station_id ? 'selected' : ''}}>{{ $station->name }}</option>
                                @endforeach
                            </select>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
