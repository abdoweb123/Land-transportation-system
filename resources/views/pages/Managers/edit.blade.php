<!-- edit_modal_city -->
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    تعديل بيانات المدير
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form method="POST" action="{{ route('update.manager') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="section-field mb-20">
                        <label class="mb-10" for="name">الإسم*</label>
                        <input class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ $item->name }}" autocomplete="name" autofocus required>
                        <input type="hidden" value="" name="type">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="section-field mb-20">
                        <label class="mb-10" for="name">البريدالالكتروني*</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{ $item->email }}"  autocomplete="email" autofocus required>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="section-field mb-20">
                        <label class="mb-10" for="Password">كلمة المرور * </label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               value="{{$item->password}}" autocomplete="current-password" required>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="hidden" name="type" value="3">
                    @error('type')
                    <span class="invalid-feedback d-inline-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
