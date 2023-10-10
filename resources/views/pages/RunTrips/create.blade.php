<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة تشغيل لرحلة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('runTrips.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم الرحلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="tripData_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['tripData'] as $trip)
                                    <option value="{{$trip->id}}">{{ $trip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم السائق :</label>
                            <select class="form-control mr-sm-2 p-2" name="driver_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['drivers'] as $driver)
                                    <option value="{{$driver->id}}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>تاريخ البداية : </label>
                            <input type="date" name="startDate" class="form-control" value="{{ old('date')}}" data-date-format="yyyy-mm-dd" required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <label>تاريخ النهاية : </label>
                            <input type="date" name="endDate" class="form-control" value="{{ old('date')}}" data-date-format="yyyy-mm-dd" required>
                        </div>
                        <div class="col">
                            <label>توقيت الرحلة : </label>
                            <input type="time" name="startTime" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم الحافلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="bus_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['buses'] as $bus)
                                    <option value="{{$bus->id}}">{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم المضيف :</label>
                            <select class="form-control mr-sm-2 p-2" name="host_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                @foreach($data['hosts'] as $host)
                                    <option value="{{$host->id}}">{{ $host->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">نوع الرحلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="type" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر من القائمة ---</option>
                                <option value="1">ذهاب</option>
                                <option value="2">ذهاب وعودة</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">عمولة السائق :</label>
                            <input type="number" class="form-control" name="driverTips">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <label for="city_id" class="mr-sm-2">عمولة المضيف :</label>
                            <input type="number" class="form-control" name="hostTips">
                        </div>
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">ملاحظات :</label>
                            <input type="number" class="form-control" name="notes">
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
