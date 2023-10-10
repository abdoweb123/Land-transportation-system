@extends('layouts.master')
@section('css')
@section('title')
    @if($id == 3) تسجيل موظف جديد @else تسجيل مدير فرع جديد @endif
@stop
@endsection

@section('PageText')

    @if($id == 3) تسجيل موظف جديد @else تسجيل مدير فرع جديد @endif
@stop
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تسجيل مستخدمين
@stop
<!-- breadcrumb -->
@endsection
@section('content')

{{--    <section class="height-100vh d-flex align-items-center page-section-ptb login"--}}
{{--             style="background-image: url('{{ asset('assets/images/sativa.png')}}');">--}}

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif


        @foreach(['danger','warning','success','info'] as $msg)
            @if(Session::has('alert-'.$msg))
                <div class="alert alert-{{$msg}}">
                    {{Session::get('alert-'.$msg)}}
                </div>
            @endif
        @endforeach

        <div class="container">
            <div class="row justify-content-center no-gutters vertical-align mb-4">
                <div class="col-lg-4 col-md-6 login-fancy-bg bg"
                     style="background-image: url('{{ asset('assets/images/login-inner-bg.jpg')}}');">
                    <div class="login-fancy">
                        <h2 class="text-white mb-20 font-weight-bold">وصلني!</h2>
                        <p class="mb-20 text-white">أهلا بكم في تطبيق وصلني لخدمات النقل والرحلات</p>
                        <p class="mb-20 text-white">نقدم لكم خدمات النقل والرحلات بأفضل جودة</p>
                        <ul class="list-unstyled  pos-bot pb-30">
                            <li class="list-inline-item"><a class="text-white" href="#"> Terms of Use</a> </li>
                            <li class="list-inline-item"><a class="text-white" href="#"> Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 bg-white">
                    <div class="login-fancy pb-40 clearfix">
                        <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">@if($id == 3) تسجيل موظف جديد @else تسجيل مدير فرع جديد @endif</h3>

                        <form method="POST" action="{{ route('register.admin') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="section-field mb-20">
                                <label class="mb-10" for="name">الإسم*</label>
                                <input class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name') }}" autocomplete="name" autofocus>
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
                                       value="{{ old('email') }}"  autocomplete="email" autofocus>
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
                                        autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" name="type" value="{{$id}}">
                            @error('type')
                            <span class="invalid-feedback d-inline-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="section-field">
                                <div class="remember-checkbox mb-30">
                                    <input type="checkbox" class="form-control" name="two" id="two" />
                                    <label for="two"> تذكرني</label>
                                </div>
                            </div>
                            <button class="button"><span>تسجيل مستخدم جديد</span><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
{{--    </section>--}}


@endsection

@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);
        });
    </script>
@endsection
