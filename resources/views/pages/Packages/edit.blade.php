<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات الاشتراك
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('packages.update',$item->id) }}" method="post">
                    {{ method_field('patch') }}
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الاسم:</label>
                            <input id="name_ar" type="text" name="title" value="{{$item->title}}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المبلغ الكلي:</label>
                            <input type="text" class="form-control" name="total" value="{{$item->total}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">المبلغ بعد التخفيض:</label>
                            <input type="text" class="form-control" name="sub_total" value="{{$item->sub_total}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">الوصف:</label>
                            <textarea name="description" class="form-control">{{$item->description}}</textarea>
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
