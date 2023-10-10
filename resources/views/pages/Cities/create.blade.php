<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('cities_trans.add_city') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">{{ trans('cities_trans.city_name_ar') }}:</label>
                            <input id="name_ar" type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">{{ trans('cities_trans.city_name_en') }}:</label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="station_id" class="mr-sm-2">اسم المحافظة التابع لها :</label>
                            <select class="form-control mr-sm-2 p-2" name="state_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر اسم المحافظة ---</option>
                                @foreach($states as $state)
                                    <option value="{{$state->id}}">{{ $state->name }}</option>
                                @endforeach
                            </select>
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
