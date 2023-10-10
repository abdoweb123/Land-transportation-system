<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات العميل
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form method="POST" action="{{ route('update.user') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">الاسم :</label>
                            <input id="name" type="text" name="name" value="{{$item->name}}" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="mobile" class="mr-sm-2">الهاتف :</label>
                            <input type="text" class="form-control" value="{{$item->mobile}}" name="mobile" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                            <input id="email" type="text" value="{{$item->email}}" name="email" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="password" class="mr-sm-2">كلمة المرور :</label>
                            <input type="password" class="form-control" name="password" value="{{$item->password}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="mr-sm-2">الرقم القومي :</label>
                            <input id="email" type="text" name="nationalId" value="{{$item->nationalId}}" class="form-control" required>
                        </div>
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
                    <br>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success"><span>حفظ</span></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
