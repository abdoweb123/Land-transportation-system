<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة خط لرحلة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('lines.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم الرحلة * :</label>
                            <select class="form-control mr-sm-2 p-2" name="tripData_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['tripData'] as $trip)
                                    <option value="{{$trip->id}}">{{ $trip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">درجة الرحلة * :</label>
                            <select class="form-control mr-sm-2 p-2" name="degree_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['degrees'] as $degree)
                                    <option value="{{$degree->id}}">{{ $degree->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">محطة الانطلاق * :</label>
                            <select class="form-control mr-sm-2 p-2" name="stationFrom_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['stations'] as $station)
                                    <option value="{{$station->id}}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">محطة الوصول * :</label>
                            <select class="form-control mr-sm-2 p-2" name="stationTo_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['stations'] as $station)
                                    <option value="{{$station->id}}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب * :</label>
                            <input type="number" class="form-control" name="priceGo">
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب والعودة * :</label>
                            <input type="number" class="form-control" name="priceBack">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب للأجانب :</label>
                            <input type="number" class="form-control" name="priceForeignerGo">
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">سعر الذهاب والعودة للأجانب :</label>
                            <input type="number" class="form-control" name="priceForeignerBack">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">غرامة إلغاء الرحلة * :</label>
                            <input type="number" class="form-control" name="cancelFee">
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">غرامة تعديل الرحلة * :</label>
                            <input type="number" class="form-control" name="editFee">
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
