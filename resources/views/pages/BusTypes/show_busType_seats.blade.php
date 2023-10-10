@extends('layouts.master')
@section('css')
@section('title')
        بيانات الحافلة
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    بيانات الحافلة
@stop
<!-- breadcrumb -->
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

                    <!-- Start bus information -->
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                                <tr>
                                    <th>اسم الأسطول</th>
                                    <th>عدد المقاعد</th>
                                    <th>طول الحافلة</th>
                                    <th>عرض الحافلة</th>
                                    <th>مدخل البيانات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $busType->name  }}</td>
                                    <td>{{ $busType->slug  }}</td>
                                    <td>{{ $busType->length  }}</td>
                                    <td>{{ $busType->width  }}</td>
                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End bus information -->

                    <!-- Start bus design and edit seats-->
                    @if(!$seats->isEmpty())
                    <form action="{{route('update.seats')}}" method="post">
                        @csrf
                        <div class="bus_design my-5 mx-auto text-center overflow-auto">
                            <h3 style="font-family: 'Cairo', sans-serif;">عرض تصميم الحافلة بالنسبة لللأدمن</h3>
                            <div class="bus_box row mx-auto my-3" style="background-color:#ddd; width:{{$busType->width*100 + $busType->width*20}}px; height:{{$busType->length*90 + $busType->length*20}}px;">
                                @foreach($seats as $item)
                                    <div id="select-{{$item->name}}"
                                         style="@if($item->type == 3) background-color:#c4c40b; color:white;
                                         @elseif($item->type == 2) background-color:red; color:white;
                                         @else background-color:beige;  @endif width:100px; height:90px; padding:37px 0; margin:10px; text-align:center; position:relative">
                                        <a>
                                            <select name="type[{{$item->name}}]" class="select" style="position:absolute; top:0; right:-65px; display:none">
                                                <option selected disabled>اختر</option>
                                                <option value="3">سائق</option>
                                                <option value="1">متاح</option>
                                                <option value="2">غير متاح</option>
                                            </select>
                                            {{$item->name}}
                                        </a>
                                    </div>
                                @endforeach
                                    <input type="hidden" value="{{$busType->id}}" name="busType_id">
                            </div>
                            <div>
                                <div class="admin_table_details text-left">
                                    <div class="driver_div d-inline-block" style="background-color:#c4c40b; width:25px; height:25px; margin-left:4px"></div>
                                    <label style="margin-left:20px">سائق</label>
                                    <div class="driver_div d-inline-block" style="background-color:red; width:25px; height:25px; margin-left:4px"></div>
                                    <label style="margin-left:20px">غير متاح</label>
                                    <div class="driver_div d-inline-block" style="background-color:beige; width:25px; height:25px; margin-left:4px"></div>
                                    <label style="margin-left:20px">متاح</label>
                                </div>
                                <button class="btn btn-success nextBtn btn-lg" type="submit">تعديل</button>
                            </div>
                        </div>
                    </form>
                    <!-- End bus design and edit seats-->

                    <!-- Start seats information -->
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>اسم المقعد</th>
                                <th>حالة المقعد بالنسبة للعميل</th>
                                <th>نوع المقعد</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($seats as $item)
                                <tr>
                                    <td>{{ $item->name  }}</td>
                                    <td>@if($item->staus == null && $item->type == 1) متاح @else <span style="background-color:red; color:white; padding:3px;">غير مرئي</span> @endif</td>
                                    @if($item->type == 1)
                                        <td><span style="background-color:green; color:white; padding:3px;">{{$item->showType($item->type)}}</span></td>
                                    @elseif($item->type == 2)
                                        <td><span style="background-color:red; color:white; padding:3px;">{{$item->showType($item->type)}}</span></td>
                                    @elseif($item->type == 3)
                                        <td><span style="background-color:#c4c40b; color:white; padding:3px;">{{$item->showType($item->type)}}</span></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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


