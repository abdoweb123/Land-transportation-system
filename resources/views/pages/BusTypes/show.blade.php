<!-- show_modal_city -->
<div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('cities_trans.show_city') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <label for="code" class="mr-sm-2">كود الحافلة
                                :</label>
                            <input id="code" type="text" value="{{$item->code}}" class="form-control" readonly>
                        </div>
                        <div class="col">
                            <label for="name" class="mr-sm-2">اسم الحافلة
                                :</label>
                            <input type="text" value="{{$item->name}}" class="form-control" readonly>
                        </div>
                    </div>
                    <br><br>


                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
            </div>
        </div>
    </div>
</div>
