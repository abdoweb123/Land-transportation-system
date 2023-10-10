@extends('layouts.master')
@section('css')
@section('title')
    تعديل بيانات النولون
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
    تعديل بيانات النولون
@stop
<!-- breadcrumb -->
@endsection
@section('content')

    <!-- row -->
    <div class="row">
{{--        <button type="button" class="button x-small w-25 mb-3 mx-3" data-toggle="modal" data-target="#exampleModal">--}}
{{--            إضافة مستخدم جديد--}}
{{--        </button>--}}
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
                        <form action="{{ route('shippings.update',$shipping->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{$shipping->user_id}}">
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">اسم المستخدم :</label>
                                    <input id="name" type="text" value="{{$shipping->user->name}}" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">اسم المستلم :</label>
                                    <input id="name" type="text" name="receiver_name" value="{{old('receiver_name',$shipping->receiver_name)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">هاتف المستلم :</label>
                                    <input id="name" type="text" name="receiver_phone" value="{{old('receiver_phone',$shipping->receiver_phone)}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="city_id" class="mr-sm-2">رقم المقعد :</label>
                                    <select class="form-control mr-sm-2 p-2" name="tripSeat_id">
                                        <option class="custom-select mr-sm-2 p-2" value=" ">-- اختر --</option>
                                        @foreach($tripSeats as $tripSeat)
                                            <option value="{{$tripSeat->id}}" {{$tripSeat->id == $shipping->tripSeat_id ? 'selected' : ''}}>{{ $tripSeat->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الرقم القومي للمستلم :</label>
                                    <input id="name" type="text" name="receiver_nationalId" value="{{old('receiver_nationalId',$shipping->receiver_nationalId)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الوصف :</label>
                                    <input id="name" type="text" name="description" value="{{old('description',$shipping->description)}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الكتلة :</label>
                                    <input id="name" type="text" name="mass"  value="{{old('mass',$shipping->mass)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الحجم :</label>
                                    <input id="name" type="text" name="volume"  value="{{old('volume',$shipping->volume)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">السعر :</label>
                                    <input id="name" type="text" name="price"  value="{{old('price',$shipping->price)}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">أخرى 1 :</label>
                                    <input id="name" type="text" name="other1"  value="{{old('other1',$shipping->other1)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">أخرى 2 :</label>
                                    <input id="name" type="text" name="other2"  value="{{old('other2',$shipping->other2)}}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل المستخدم مسجل على الرحلة ؟ :</label>
                                    <div class="row" style="margin-top:20px">
                                        <div class="col">
                                            <input id="name" type="radio" name="user_on_the_trip" {{$shipping->user_on_the_trip==1 ? 'checked' : ''}} value="1" required><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="user_on_the_trip" {{$shipping->user_on_the_trip==2 ? 'checked' : ''}} value="2" required><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل النولون قابل للكسر ؟ :</label>
                                    <div class="row">
                                        <div class="col">
                                            <input id="name" type="radio" name="breakable" {{$shipping->breakable==1 ? 'checked' : ''}} value="1"><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="breakable" {{$shipping->breakable==2 ? 'checked' : ''}} value="2"><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">هل تريد توصيله بسرعة ؟ :</label>
                                    <div class="row">
                                        <div class="col">
                                            <input id="name" type="radio" name="fast" {{$shipping->fast==1 ? 'checked' : ''}} value="1"><span class="yesNo">نعم</span>
                                        </div>
                                        <div class="col">
                                            <input id="name" type="radio" name="fast" {{$shipping->fast==2 ? 'checked' : ''}} value="2"><span class="yesNo">لا</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2 d-block">الحالة :</label>
                                   <div class="row">
                                       <div class="col">
                                           <input id="name" type="checkbox" name="receiving" value="1" {{$shipping->receiving == 1 ? 'checked' : ''}}>
                                           <label for="name_ar" class="mr-sm-2">تم الاستلام</label>
                                       </div>
                                       <div class="col">
                                           <input id="name" type="checkbox" name="delivering" value="1" {{$shipping->delivering == 1 ? 'checked' : ''}}>
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



