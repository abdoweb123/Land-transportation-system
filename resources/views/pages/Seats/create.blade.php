@extends('layouts.master')
@section('css')
@section('title')
    دليل تصميم الأتوبيسات
@stop
@endsection

@section('PageText')

    قائمه المقاعد
@stop
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    إضافة المقاعد
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
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

                    <form method="post" action="{{route('seats.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="overflow:auto">
                            <div class="m-5 p-4" style="border:1px solid #ddd; width:30%">
                                <h6 style="font-family: 'Cairo', sans-serif;color: blue">إضافة مقاعد</h6><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group length">
                                            <label>الطول : <span class="text-danger">*</span></label>
                                            <input type="number" name="length" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group width">
                                            <label>العرض : <span class="text-danger">*</span></label>
                                            <input type="number" name="width" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group slug">
                                            <label>عدد المقاعد: <span class="text-danger">*</span></label>
                                            <input type="text" name="slug" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Classroom_id">الأسطول التابع لها : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="busType_id" required>
                                                <option selected disabled>--اختر الأسطول--</option>
                                                @foreach($busTypes as $busType)
                                                    <option value="{{$busType->id}}">{{$busType->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bus_box row m-auto" style="background-color:#ddd; width:70%">

                            </div>
                        </div>

                        <br>
                        <button type="button" id="show_seats" class="btn btn-info btn-sm nextBtn btn-lg pull-right"
                                style="margin-right:28px; margin-left:25px">عرض المقاعد</button>
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->



@endsection

@section('js')
    <script>

        $(document).ready(function (){

            $(".alert").delay(5000).slideUp(300);

            $('.length input').on('keyup', function (){
                $('.slug input').val( $('.length input').val() * $('.width input').val())
            })

            $('.width input').on('keyup', function (){
                $('.slug input').val( $('.length input').val() * $('.width input').val())
            })


            /*** show seats of bus ***/
            $('#show_seats').on('click', function () {

                $('.bus_box').empty();
                $('.bus_box').css({
                    width: '0px',
                    height: '0px',
                });

                let width = $('input[name="width"]').val();
                let length = $('input[name="length"]').val();

                $('.bus_box').css({
                    width: (width * 100 + width * 20) + 'px',
                    height: (length * 90 + length * 20) + 'px',
                });


                let slug_value = $('input[name="slug"]').val();

                let array = new Array();
                for (let i=1; i<=slug_value; i++)
                {
                    array[i] = i;
                    $('.bus_box').append('<div id="'+'select-'+array[i]+'" style="width:100px; height:90px; padding:37px 0; margin:10px; text-align:center; background-color:beige; position:relative">' +
                        '<a>'
                        + '<select id="#my_select" name="type['+array[i]+']" class="select" style="position:absolute; top:0; right:-65px; display:none">'
                        +    '<option value=" ">اختر</option>'
                        +    '<option value="3">سائق</option>'
                        +    '<option value="1">متاح</option>'
                        +    '<option value="2">غير مرئي</option>'
                        + '</select>'
                        +'</a>' + array[i] + '</div>');
                }


            });



            /*** To hide select options when click on another seat ***/
            $('.bus_box').on('click', 'div', function ()
            {
                $(this).find('select').fadeIn();
                $(this).siblings().find('select').fadeOut();
            });


            /*** To hide select options when click on another element in the page ***/
            $(document).mouseup(function (e)
            {
                var container = $('.select');

                if (!container.is(e.target) && container.has(e.target).length === 0)
                {
                    container.fadeOut();
                }
            });



            /*** To change the background of a seat after choosing a type ***/
            $('.bus_box').on('change', 'div select', function ()
            {
                let option_val = $(this).find('option:selected').val();
                let option = $(this).find('option:selected').parents().eq(2);
                if (option_val === '3'){
                    option.css({
                        backgroundColor:'#c4c40b',
                        color:'white',
                    })
                }
                if(option_val === '2'){
                    option.css({
                        backgroundColor:'red',
                        color:'white',
                    })
                }
                if(option_val === '1'){
                    option.css({
                        backgroundColor:'beige',
                        color:'black',
                    })
                }
            });



        }); //end of document
    </script>
@endsection
