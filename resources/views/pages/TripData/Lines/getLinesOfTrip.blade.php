@extends('layouts.master')
@section('css')
@section('title')
    خطوط الرحلات
@stop

<style>
    .input_table , .input_table:active ,
    .input_table:focus {
        border:none;
        outline: none;
        width: 75%;
        text-align: center;
    }

    select {
        border:none;
        outline: none;
    }

    #datatable_filter{display: none}
    table .dataTable{margin:0 !important;}
    #datatable_wrapper .table .dataTable {
        margin: 0 !important;
    }
    p{
        /*margin-bottom: 10px !important;*/
        margin: 10px -5px 10px 10px !important;
        padding: 10px !important;
        display: inline-block;
    }
    .degree span{
        background-color:#c4c40b;
        color:white;
        padding: 5px 10px;
        border-radius: 5px;
    }
    table{margin-bottom: 50px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    قائمة خطوط الرحلات
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <h6 class="mb-2"><span style="border-radius: 5px; padding:5px"><span> رحلة {{ $data['tripData']->name }} </span> / المحطات  / الخطوط</span></h6>

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

{{--                    <h6 class="text-center"><span style="background-color:#84ba3f; color:white; border-radius: 5px; padding:5px"> رحلة {{$data['tripData']->name}}&nbsp; --> المحطات &nbsp;--> الخطوط &nbsp;</span></h6>--}}

                    @foreach(['danger','warning','success','info'] as $msg)
                        @if(Session::has('alert-'.$msg))
                            <div class="alert alert-{{$msg}} messages">
                                {{Session::get('alert-'.$msg)}}
                            </div>
                        @endif
                    @endforeach

                    <br><br>

                    <form action="{{route('updateLines')}}" method="post">
                        @csrf

                    <div class="table-responsive">
                        @foreach($data['tripData']->tripDegrees as $item)

                            <table class="table table-hover table-sm table-bordered p-0" style="text-align: center">
                                <p class="degree"> <span> {{$item->degree->name}} </span> </p>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>محطة الانطلاق</th>
                                    <th>محطة الوصول</th>
                                    <th>سعر الذهاب</th>
                                    <th>سعر الذهاب والعودة</th>
                                    <th>سعر الذهاب للأجانب</th>
                                    <th>سعر الذهاب والعودة للأجانب</th>
                                    <th>حالة الرحلة</th>
                                    <th>غرامة إلغاء الرحلة</th>
                                    <th>غرامة تعديل الرحلة</th>
                                    <th>مدخل البيانات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x = $item->degree->id; ?>
                                @foreach ($data['lines'] as $item)

                                        @if($item->degree->id == $x)
                                            <tr>

                                                <input type="hidden" name="degree_id[]" value="{{$x}}">
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>@isset($item->stationFrom->station->name) {{ $item->stationFrom->station->name }} @else لا يوجد @endisset</td>
                                                <td>@isset($item->stationTo->station->name) {{ $item->stationTo->station->name }} @else لا يوجد @endisset</td>
                                                <td><input class="input_table" type="number" step=".01" name="priceGo[]" value="{{$item->priceGo}}"></td>
                                                <td><input class="input_table" type="number" step=".01" name="priceBack[]" value="{{$item->priceBack}}"></td>
                                                <td><input class="input_table" type="number" step=".01" name="priceForeignerGo[]" value="{{$item->priceForeignerGo}}"></td>
                                                <td><input class="input_table" type="number" step=".01" name="priceForeignerBack[]" value="{{$item->priceForeignerBack}}"></td>
                                                <td>
                                                    <select name="active[]">
                                                        <option value="{{$item->active}}">{{$item->active  == 1 ? 'نشط' : 'غير نشط'}}</option>
                                                        @if($item->active == 1)
                                                            <option value="2">غير نشط</option>
                                                        @else
                                                            <option value="1">نشط</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td><input class="input_table" type="number" name="cancelFee[]" value="{{$item->cancelFee}}"></td>
                                                <td><input class="input_table" type="number" name="editFee[]" value="{{$item->editFee}}"></td>
                                                <td>@isset($item->admin->name)  {{ $item->admin->name }} @else لا يوجد @endisset</td>
                                                <input type="hidden" name="id[]" value="{{$item->id}}">

                                                <input type="hidden" name="stationFrom_id[]" value="{{$item->stationFrom_id}}">
                                                <input type="hidden" name="stationTo_id[]" value="{{$item->stationTo_id}}">
                                            </tr>


                                @endif
                                @endforeach

                            </table>
                        @endforeach

                        <input type="hidden" name="degrees" value="{{count($data['tripData']->tripDegrees)}}">
                        <input type="hidden" name="tripData_id" value="{{$data['tripData']->id}}">
                        <button type="submit" class="btn btn-success mt-1 mb-4 mx-2">حفظ</button>
                        <a href="{{route('showBusTypeSeatsOfTrip',$data['tripData']->id)}}" class="btn btn-secondary mt-1 mb-4 mx-2">التالي</a>
                    </div>
                    </form>



                        <div> {{$data['lines']->links('pagination::bootstrap-4')}}</div>

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
            $(".messages").delay(5000).slideUp(300);
        });
    </script>
@endsection



