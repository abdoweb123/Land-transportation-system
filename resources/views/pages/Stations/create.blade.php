<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('stations_trans.add_station') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('stations.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">{{ trans('stations_trans.station_name_ar') }}
                                :</label>
                            <input id="name_ar" type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">{{ trans('stations_trans.station_name_en') }}
                                :</label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="city_id" class="mr-sm-2">{{ trans('stations_trans.choose_city_name') }}
                                :</label>
                            <select class="form-control mr-sm-2 p-2" name="city_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">{{ trans('stations_trans.choose') }}</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{ $city->name }}</option>
                                @endforeach
                            </select>
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
