<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة عميل
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('shippings.createNewUser') }}" method="get" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                    <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                    <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">الاسم * :</label>
                            <input id="name" type="text" name="name" value="{{old('name')}}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="mobile" class="mr-sm-2">الهاتف * :</label>
                            <input type="text" class="form-control" name="mobile" value="{{old('mobile')}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                            <input id="email" type="text" name="email" value="{{old('email')}}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="password" class="mr-sm-2">كلمة المرور * :</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="mr-sm-2">الرقم القومي :</label>
                            <input id="email" type="text" name="nationalId" value="{{old('nationalId')}}" class="form-control" required>
                        </div>
                    </div>
                    <br>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success"><span>حفظ</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
