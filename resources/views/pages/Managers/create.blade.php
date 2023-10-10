<!-- add_modal_station -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    إضافة مدير
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form method="POST" action="{{ route('create.manager') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="section-field mb-20">
                        <label class="mb-10" for="name">الإسم*</label>
                        <input class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ old('name') }}" autocomplete="name" autofocus required>
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
                               value="{{ old('email') }}"  autocomplete="email" autofocus required>
                        <input type="hidden" value="" name="type">
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
                               autocomplete="current-password" required>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="hidden" name="type" value="2">
                    @error('type')
                    <span class="invalid-feedback d-inline-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <button class="button"><span>حفظ</span><i class="fa fa-check"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
