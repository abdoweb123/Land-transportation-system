@extends('layouts.master')
@section('css')
@section('title')
    حجز نولون
@stop



{{-- start select with live search --}}
{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>--}}
<link rel="stylesheet" href="{{asset('css/hierarchy-select.min.css')}}">
<link rel="stylesheet" href="{{asset('css/demo.css')}}">
{{-- end select with live search --}}                                                                                                                               {{-- end select with live search --}}

<style>                                                                                                                    .search-boxx{transform: translate3d(270px, 33px, 0px) !important;}
    select{padding:10px !important;}
    .search-boxx {
        transform: translate3d(270px, 33px, 0px) !important;
        width: 100% !important;
        right:270px;
    }
    .dropdown-toggle{
        padding: 8px !important;
        width: 100% !important;
    }
    .dropdown-menu.show {
        display: inline-table !important;
    }
    #pre-loader{display:none}
    input[type='radio']{margin-left:2px}
    .yesNo{font-size:15px}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    حجز نولون
@stop
<!-- breadcrumb -->
@endsection
@section('content')

    <!-- row -->
    <div class="row">
        <button type="button" class="button x-small w-25 mb-3 mx-3" data-toggle="modal" data-target="#exampleModal">
            إضافة مستخدم جديد
        </button>
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @foreach(['danger','warning','success','info'] as $msg)
                    @if(Session::has('alert-'.$msg))
                        <div class="alert alert-{{$msg}}">
                            {{Session::get('alert-'.$msg)}}
                        </div>
                    @endif
                @endforeach
                <div class="card-body">
                    <div class="modal-body">
                        <form action="{{ route('shippings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                            <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                            <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">

                            @isset($newUser)
                                <input type="hidden" name="user_id" value="{{$newUser->id}}">
                            @endisset
                            <div class="row">
                                <div class="col">
                                    <label for="name_en" class="mr-sm-2">اسم العميل: ابحث بالاسم أو برقم الهاتف</label>
                                    {{-- start select with live search --}}
                                    @isset($newUser)
                                        <input  type="text" class="form-control" value="{{$newUser->name}}" readonly>
                                    @else
                                        <div class="dropdown hierarchy-select d-inline" id="example">
                                            <button type="button" class="btn btn-primary dropdown-toggle" id="example-two-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu search-boxx" aria-labelledby="example-two-button">
                                                <div class="hs-searchbox">
                                                    <input type="text" class="form-control" autocomplete="off">
                                                </div>
                                                <div class="hs-menu-inner">
                                                    <a class="dropdown-item" data-value="" data-default-selected="" href="#"> -- كل العملاء -- </a>
                                                    @foreach($users as $user)
                                                        <a class="dropdown-item" data-value="{{$user->id}}" href="#">{{$user->name}} <span style="display:none" required>{{$user->mobile}}</span>  <span style="display:none">{{$user->nationalId}}</span> </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input class="d-none" name="user_id" readonly="readonly" aria-hidden="true" type="text"/>
                                        </div>
                                    @endisset

                                    {{-- end select with live search --}}
                                </div>

                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">اسم المستلم :</label>
                                    <input id="name" type="text" name="receiver_name" value="{{old('receiver_name')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">هاتف المستلم :</label>
                                    <input id="name" type="text" name="receiver_phone" value="{{old('receiver_phone')}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="city_id" class="mr-sm-2">رقم المقعد :</label>
                                    <select class="form-control mr-sm-2 p-2" name="tripSeat_id">
                                        <option class="custom-select mr-sm-2 p-2" value=" ">-- اختر --</option>
                                        @foreach($tripSeats as $tripSeat)
                                            <option value="{{$tripSeat->id}}">{{ $tripSeat->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الرقم القومي للمستلم :</label>
                                    <input id="name" type="text" name="receiver_nationalId" value="{{old('receiver_nationalId')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الكتلة :</label>
                                    <input id="name" type="text" name="mass"  value="{{old('mass')}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الحجم :</label>
                                    <input id="name" type="text" name="volume"  value="{{old('volume')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">السعر :</label>
                                    <input id="name" type="text" name="price"  value="{{old('price')}}" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الوصف :</label>
                                    <input id="name" type="text" name="description" value="{{old('description')}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">أخرى 1 :</label>
                                    <input id="name" type="text" name="other1"  value="{{old('other1')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">أخرى 2 :</label>
                                    <input id="name" type="text" name="other2"  value="{{old('other2')}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل المستخدم مسجل على الرحلة ؟ :</label>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col">
                                            <input id="name" type="radio" name="user_on_the_trip" value="1" required><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="user_on_the_trip" value="2" required><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل النولون قابل للكسر ؟ :</label>
                                    <div class="row">
                                        <div class="col">
                                            <input id="name" type="radio" name="breakable" value="1"><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="breakable" value="2"><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل تريد توصيله بسرعة ؟ :</label>
                                    <div class="row">
                                        <div class="col">
                                            <input id="name" type="radio" name="fast" value="1"><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="fast" value="2"><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">الحالة :</label>
                                    <div class="row">
                                        <div class="col">
                                            <input id="name" type="checkbox" name="receiving" value="1">
                                            <label for="name_ar" class="mr-sm-2">تم الاستلام</label>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="checkbox" name="delivering" value="1">
                                            <label for="name_ar" class="mr-sm-2">تم التسليم</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.ReservationBookingRequests.createNewClientForShipping')
    </div>


@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);


            // To hide div max_amount when ...
            $('.percent').change(function (){
                if ( $($(this).val() == '1') ){      // جنيه
                    $('.max_amount').slideToggle();            // اخفيه
                }
                else {       // %
                    $('.max_amount').slideToggle();           // اظهره
                }
            });



            // for live search with select
            $('#example').hierarchySelect({
                hierarchy: false,
                width: 'auto'
            });

        });

    </script>


    {{-- start select with live search --}}
    {{--    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
    <script src="{{{asset('js/hierarchy-select.min.js')}}}"></script>
    {{-- end select with live search --}}



@endsection



