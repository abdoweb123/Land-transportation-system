<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة محطة للرحلة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('tripStations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tripData_id" value="{{$tripData->id}}">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم المحطة :</label>
                            <select class="form-control mr-sm-2 p-2" name="station_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">نوع المحطة :</label>
                            <select class="form-control mr-sm-2 p-2" name="type" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                <option value="1">صعود</option>
                                <option value="2">نزول</option>
                                <option value="3">صعود و نزول</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">المسافة المقطوعة للوصول لها (كم) :</label>
                            <input type="text" class="form-control" name="distance" required>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">الوقت المستغرق للوصول لها :</label>
                            <input type="text" class="form-control" name="timeInMinutes" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">ترتيب المحطة :</label>
                            <input type="text" class="form-control" name="rank" required>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">عدد مرات طباعة اللوحة :</label>
                            <input type="text" class="form-control" name="printTimes" required>
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
