@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@endsection


@section('style')

    .col-md-3 , .col-md-6{
        cursor:pointer;
    }
    .div-dash a{color:black !important; text-decoration:none}
    .div-dash div img{
        height: 55%;
        width: 100%;
        object-fit: cover;
    }
@endsection




@section('content')

<p>تم تسجيل الدخول بنجاح</p>
{{--    <div class="div-dash mt-5">--}}
{{--        <div class="row row-dash" id="#my-taps">--}}
{{--            <div class="col-sm-6 col-lg-4">--}}
{{--                <a href="{{route('product_ForAdmin.create')}}">--}}
{{--                    <img src="{{asset('images/download.jfif')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        شراء منتج--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap6">--}}
{{--                <a href="{{route('admin.dashboard.content','tap6')}}">--}}
{{--                    <img src="{{asset('images/images.jfif')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                       المبيعات--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap1">--}}
{{--                <a href="{{route('admin.dashboard.content','tap1')}}">--}}
{{--                    <img src="{{asset('images/images (1).jfif')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        المورّدين--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap2">--}}
{{--                <a href="{{route('admin.dashboard.content','tap2')}}">--}}
{{--                    <img src="{{asset('images/images (3).jfif')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        المصروفات--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap3">--}}
{{--                <a href="{{route('admin.dashboard.content','tap3')}}">--}}
{{--                    <img src="{{asset('images/istockphoto-1303339829-170667a.jpg')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        إدارة الحسابات--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap4">--}}
{{--                <a href="{{route('admin.dashboard.content','tap4')}}">--}}
{{--                    <img src="{{asset('images/cash.jpg')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        العملاء--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-4" id="tap5">--}}
{{--                <a href="{{route('admin.dashboard.content','tap5')}}">--}}
{{--                    <img src="{{asset('images/images (2).jfif')}}">--}}
{{--                    <div class="dash-inside">--}}
{{--                        مخزن المنتجات--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection
