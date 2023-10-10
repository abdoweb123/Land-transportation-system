<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة محافظة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('states.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">اسم المحافظة باللغة العربية</label>
                            <input id="name_ar" type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">اسم المحافظة باللغة الإنجليزية</label>
                            <input id="name_en" type="text" name="name_en" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="station_id" class="mr-sm-2">اسم الدولة التابع لها :</label>
                            <select class="form-control mr-sm-2 p-2" name="country_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر اسم الدولة ---</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">إرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
