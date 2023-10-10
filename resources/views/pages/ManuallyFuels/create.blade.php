<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة وقود يدوي
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('manuallyFuels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="bus_id" class="mr-sm-2">كود الحافلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="bus_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($buses as $bus)
                                <option value="{{$bus->id}}" {{old('bus_id') == $bus->id ? 'selected' : ''}}>{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المسافة المقطوعة (م) :</label>
                            <input type="text" name="distance" value="{{old('distance')}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">التعليق :</label>
                            <textarea name="comments" class="form-control" required>{{old('comments')}}</textarea>
                        </div>
                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
