<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات المحطة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('tripStations.update', 'test') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                    <input type="hidden" name="tripData_id" value="{{$tripData->id}}">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم المحطة :</label>
                            <select class="form-control mr-sm-2 p-2" name="station_id" required>
                                <option class="custom-select mr-sm-2 p-2" disabled>--- اختر من القائمة ---</option>
                                <option value="{{$item->station->id}}">{{ $item->station->name }}</option>
                                @foreach($stations as $station)
                                    @if($station->id !== $item->station->id)
                                        <option value="{{$station->id}}">{{ $station->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">نوع الرحلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="type" required>
                                <option class="custom-select mr-sm-2 p-2" disabled>--- اختر من القائمة ---</option>
                                <option class="custom-select mr-sm-2 p-2" value="{{$item->type}}">
                                    @if($item->type == 1 ) صعود @elseif($item->type == 2 ) نزول @elseif($item->type == 3 ) صعود ونزول @endif
                                </option>
                                @if($item->type == 1)
                                    <option value="2">نزول</option>
                                    <option value="3">صعود و نزول</option>
                                @elseif($item->type == 2)
                                    <option value="1">صعود</option>
                                    <option value="3">صعود و نزول</option>
                                @elseif($item->type == 3)
                                    <option value="1">صعود</option>
                                    <option value="2">نزول</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">المسافة المقطوعة للوصول لها (كم) :</label>
                            <input type="text" class="form-control" name="distance" value="{{$item->distance}}" required>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">الوقت المستغرق للوصول لها :</label>
                            <input type="text" class="form-control" name="timeInMinutes" value="{{$item->timeInMinutes}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">ترتيب المحطة :</label>
                            <input type="text" class="form-control" name="rank" value="{{$item->rank}}" required>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">عدد مرات طباعة اللوحة :</label>
                            <input type="text" class="form-control" name="printTimes" value="{{$item->printTimes}}" required>
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
