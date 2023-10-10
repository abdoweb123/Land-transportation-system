<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة مشكلة للمكون
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('issues.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">اسم المكون :</label>
                            <select class="form-control" name="category_id" required>
                                <option value=" " selected>-- اختر --</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">العنوان :</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2 d-block">الأولوية :</label>
                            <div class="row">
                                @for($i=1; $i<=5; $i++)
                                     <div class="col-4 mb-2">
                                        <input type="radio" name="priority" value="{{$i}}" required> <span>{{$i}}</span>
                                     </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">النوع :</label>
                            <select name="type" class="form-control" required>
                                <option value=" " selected>-- اختر --</option>
                                <option value="1">تجديد</option>
                                <option value="2">تغيير</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الوصف :</label>
                            <textarea name="description" class="form-control"></textarea>
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
