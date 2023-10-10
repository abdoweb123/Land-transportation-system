<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات المكون
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('issues.update', $item->id) }}" method="post">
                    {{ method_field('patch') }}
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">اسم المكون :</label>
                            <select class="form-control" name="category_id" required>
                                <option disabled selected>-- اختر --</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $item->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">العنوان :</label>
                            <input type="text" name="title" value="{{$item->title}}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2 d-block">الأولوية :</label>
                            <div class="row">
                                @for($i=1; $i<=5; $i++)
                                    <div class="col-4 mb-2">
                                        <input type="radio" name="priority" value="{{$i}}" {{$i == $item->priority ? 'checked' : ''}} required> <span>{{$i}}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">النوع :</label>
                            <select name="type" class="form-control" required>
                                <option disabled selected>-- اختر --</option>
                                @if($item->type == 1)
                                    <option value="1" selected>تجديد</option>
                                    <option value="2">تغيير</option>
                                @else
                                    <option value="1">تجديد</option>
                                    <option value="2" selected>تغيير</option>
                                @endif
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الحالة :</label>
                            <select name="active" class="form-control">
                                @if($item->active == 1)
                                    <option value="1" selected>نشط</option>
                                    <option value="0">غير نشط</option>
                                @else
                                    <option value="1">نشط</option>
                                    <option value="0" selected>غير نشط</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">الوصف :</label>
                            <textarea name="description" class="form-control">{{ $item->description}}</textarea>
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
