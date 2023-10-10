@extends('layouts.master')
@section('css')
@section('title')
        تصميم حافلة الرحلة
@stop
@endsection

@section('page-header')
    <style>
        .driver_div{border: 0.1px solid #00000073;}
    </style>
@section('PageTitle')
    تصميم حافلة الرحلة
@stop

@endsection

@section('style')
    <style>
        .table td{padding: 8px;}
    </style>
@endsection


@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

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


                    <br><br>



                    <!-- Start bus design and edit seats-->
                    @if(!$seats->isEmpty())
                    @if(count($tripSeats) == count($seats))  <!-- عدد مقاعد الرحلة = عدد مقاعد الأسطول التي تتبع له الرحلة -->

                        <form class="signupForm" action="{{route('updateTripSeats')}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6" style="border-left:3px solid #ddd"></div>
                                    <div class="col-md-6 bus_design my-5 mx-auto text-center overflow-auto">
                                        <h3 style="font-family: 'Cairo', sans-serif;">عرض  تصميم حافلة الرحلة </h3>
                                        <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                            @foreach($tripSeats as $item)
                                                <div id="select-{{$item->seat->name}}"
                                                     style="@if($item->seat->type == 3) visibility:hidden; color:white;
                                                     @elseif($item->seat->type == 2) visibility:hidden; color:white;
                                                     @else background-color:beige;  @endif width:100px; height:90px; padding:37px 0; margin:10px; text-align:center; position:relative">
                                                    <a>
                                                        <select name="type[{{$item->id}}]" class="select" style="position:absolute; top:0; right:0; width:100%; /*display:none*/">
                                                            <option disabled selected>اختر</option>
                                                            @foreach($tripDegrees as $tripDegree)
                                                                <option value="{{$tripDegree->degree_id}}" {{$tripDegree->degree_id == $item->degree_id ? 'selected' : ''}}>{{$tripDegree->degree->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{$item->seat->name}}
                                                    </a>
                                                </div>
                                            @endforeach
                                            <input type="hidden" value="{{$tripData->id}}" name="tripData_id">
                                            @foreach($tripDegrees as $tripDegree)
                                                <input type="hidden" name="initial_degree" value="{{$tripDegree->degree_id}}">
                                            @endforeach
                                        </div>
                                        <button class="btn btn-success nextBtn" type="submit">تعديل</button>
                                    </div>
                                </div>
                            </form>

                    @else

                        <form class="signupForm" action="{{route('createTripSeats')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6" style="border-left:3px solid #ddd"></div>
                                        <div class="col-md-6 bus_design my-5 mx-auto text-center overflow-auto">
                                            <h3 style="font-family: 'Cairo', sans-serif;">عرض  تصميم حافلة الرحلة </h3>
                                            <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                                @foreach($seats as $item)
                                                    <div id="select-{{$item->name}}"
                                                         style="@if($item->type == 3) visibility:hidden; color:white;
                                                         @elseif($item->type == 2) visibility:hidden; color:white;
                                                         @else background-color:beige;  @endif width:100px; height:90px; padding:37px 0; margin:10px; text-align:center; position:relative">
                                                        <a>
                                                            <select name="type[{{$item->id}}]" class="select" style="position:absolute; top:0; right:0; width:100%; /*display:none*/">
{{--                                                                <option value=" ">اختر</option>--}}
                                                                @foreach($tripDegrees as $tripDegree)
                                                                    <option value="{{$tripDegree->degree_id}}">{{$tripDegree->degree->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            {{$item->name}}
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <input type="hidden" value="{{$tripData->id}}" name="tripData_id">
{{--                                                @foreach($tripDegrees as $tripDegree)--}}
{{--                                                    <input type="hidden" name="initial_degree" value="{{$tripDegree->degree_id}}">--}}
{{--                                                @endforeach--}}
                                            </div>
                                            <button class="btn btn-success nextBtn" type="submit">حفظ</button>
                                        </div>
                                    </div>
                                </form>

                    @endif

                    <!-- End bus design and edit seats-->



                    @else
                        <h3 class="text-center">لم يتم تصميم هذا الأسطول بعد!</h3>
                    @endif
                    <!-- End seats information -->


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



            /*** To hide select options when click on another seat ***/
            $('.bus_box').on('click', 'div', function ()
            {
                $(this).find('select').fadeIn();
                // $(this).siblings().find('select').fadeOut();
            });





        }); //end of document
    </script>
@endsection


