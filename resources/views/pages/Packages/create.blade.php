<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة اشتراك
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('packages.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الاسم:</label>
                            <input id="name_ar" type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">أقصى عدد للرحلات:</label>
                            <input type="number" class="form-control" name="max_trips" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">محطة الانطلاق:</label>
                            <select name="stationFrom_id" class="form-control" required>
                                <option value=" ">-- اختر --</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}">{{$station->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">محطة الوصول:</label>
                            <select name="stationTo_id" class="form-control" required>
                                <option value=" ">-- اختر --</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}">{{$station->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">مدة الاشتراك بالأيام:</label>
                            <input type="number" class="form-control" name="max_duration" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المبلغ الكلي:</label>
                            <input type="text" class="form-control" name="total" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المبلغ بعد التخفيض:</label>
                            <input type="text" class="form-control" name="sub_total">
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">النوع:</label>
                            <select name="type" class="form-control" required>
                                <option value="1">ذهاب</option>
                                <option value="2">ذهاب و عودة</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col">
                            <label for="name_en" class="mr-sm-2">الوصف:</label>
                            <textarea name="description" class="form-control"></textarea>
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
