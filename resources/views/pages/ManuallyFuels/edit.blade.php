<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات الوقود اليدوي
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('manuallyFuels.update',$item->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <label for="bus_id" class="mr-sm-2">كود الحافلة :</label>
                            <select class="form-control mr-sm-2 p-2" name="bus_id"numeric>
                                <option class="custom-select mr-sm-2 p-2" disabled>--- اختر ---</option>
                                @foreach($buses as $bus)
                                    <option value="{{$bus->id}}" {{old('bus_id') == $bus->id ? 'selected' : ''}} {{$bus->id == $item->bus_id ? 'selected' : ''}}>{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المسافة المقطوعة (م) :</label>
                            <input type="text" name="distance" value="{{old('distance', $item->distance)}}" class="form-control"numeric>
                        </div>
                    </div>
                    <div class="row">
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
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">التعليق :</label>
                            <textarea name="comments" class="form-control" required>{{old('comments', $item->comments)}}</textarea>
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
