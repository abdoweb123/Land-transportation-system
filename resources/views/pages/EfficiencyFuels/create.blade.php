<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة وقود
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('efficiencyFuels.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">كود الحافلة :</label>
                            <select class="form-control" name="bus_id" required>
                                <option value=" " selected>-- اختر --</option>
                                @foreach($buses as $bus)
                                    <option value="{{$bus->id}}">{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">كمية البنزين :</label>
                            <input type="text" name="volume" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2 d-block">المبلغ الكلي المدفوع :</label>
                            <input type="text" name="total_cost" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">ملاحظات :</label>
                            <textarea name="notes" class="form-control"></textarea>
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
