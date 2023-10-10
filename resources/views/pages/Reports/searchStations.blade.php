@extends('layouts.master')
@section('css')
@section('title')
    بيان الركاب والإيرادات لفترة
@stop


<style>
    .process{border:none; border-radius:3px; padding:3px 5px;}
    select{padding:10px !important;}
    .process
    {
        cursor:pointer;
        background-color:white;
        border-radius:3px;
        border: 1px solid #dddd;
        padding: 5px 3px 0 4px;
        margin-left: 2px;
    }
    th{text-align:center !important;}
    .top , .span_top{background-color: #dddddd40;}
    .span_top{padding:4px}
    .text_bold{font-weight: bold}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    بيان الركاب والإيرادات لفترة
@stop
<!-- breadcrumb -->
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


                    <form action="{{route('searchForStation')}}" method="get" enctype="multipart/form-data">
                        <div class="row mb-5">
                            <div class="col">
                                <label for="name_ar" class="mr-sm-2">تاريخ البداية :</label>
                                <input class="form-control" type="date" name="startDate" @isset($request) value="{{$request->startDate}}" @endisset required>
                            </div>
                            <div class="col">
                                <label for="name_ar" class="mr-sm-2">تاريخ النهاية :</label>
                                <input class="form-control" type="date" name="endDate" @isset($request) value="{{$request->endDate}}" @endisset required>
                            </div>
                            <div class="col">
                                <label for="name_ar" class="mr-sm-2"> </label>
                                <input type="submit" value="ابحث" class="btn btn-success form-control" style="background-color: #84ba3f; color: white; font-size: 16px; padding:15px; margin-top: 5px;">
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered head">
                            <tr style="display:flex; margin-bottom:10px;">
                                <th style="width:120px;">التاريخ والموعد</th>
                                <th style="width:120px;">كود التشغيل</th>
                                <th style="width:70px;">السيارة</th>
                                <th style="width:70px;">السائق</th>
                                <th style="width:120px;">سعر التذكرة</th>
                                <th style="width:120px;">عدد المقاعد</th>
                                <th style="width:140px;">أعلى إيراد متوقع (إيراد 100%)</th>
                                <th style="width:120px;">عدد الركاب الفعلي</th>
                                <th style="width:120px;">الإيراد الفعلي</th>
                                <th style="width:120px;">متوسط سعر التذكرة</th>
                                <th style="width:110px">الكيلومتر</th>
                                <th style="width:110px">إيراد كم</th>
                                <th style="width:110px">نسبة الإيراد %</th>
                                <th style="width:110px">نسبة الإشغال%</th>
                            </tr>
                            <tr style="display: flex">
                                <td style="width:620px; text-align:center; background-color:#ddd"></td>
                                <td class="count1 top text_bold" style="width:140px;"></td>
                                <td class="count2 top text_bold" style="width:120px;"></td>
                                <td class="count3 top text_bold" style="width:120px;"></td>
                                <td class="count  top text_bold" style="width:120px;"></td>
                                <td class="count4 top text_bold" style="width:110px"></td>
                                <td class="count5 top text_bold" style="width:110px"></td>
                                <td class="count6 top text_bold" style="width:110px"></td>
                                <td class="count7 top text_bold" style="width:110px"></td>
                            </tr>
<!--                            --><?php  $i=0 ?>
                            @isset($lines)
                                @foreach($groupLines as $groupLine)
                                    <tr style="display: flex">
                                        <td class="top" style="width:620px; text-align:center">{{\App\Models\Station::find($groupLine->from_id)->name}} &nbsp;&nbsp;=====>&nbsp;&nbsp; {{\App\Models\Station::find($groupLine->to_id)->name}} &nbsp;&nbsp; ( {{\App\Models\Degree::find($groupLine->degree_id)->name}} )</td>
                                        <?php $count1 = 0; $count2 = 0;  $count3 = 0;  $count4 = 0; $count5 = 0; $count6 = 0; $count7 = 0; ?>
                                            <span style="display: none">
                                                @for($z=0; $z<count($lines); $z++)
                                                    @if($lines[$z]->from_id == $groupLine->from_id && $lines[$z]->to_id == $groupLine->to_id && $lines[$z]->degree_id == $groupLine->degree_id)
                                                        @isset($arr_trip_seat_price[$z]) {{ $count1 += ($arr_trip_seat_price[$z] * $lines[$z]->priceGo) }} @else 0 @endisset
                                                        <?php  $booked_seats = (isset( $lines[$z]->total)?  $lines[$z]->total :false); ?> @if($booked_seats != 0) {{$count2 += $booked_seats}} @else {{$booked_seats = 0}} @endif
                                                        <?php  $real_cash_all = (isset( $lines[$z]->total)?  $lines[$z]->total :false); ?> {{ $count3 += ($real_cash_all * $lines[$z]->priceGo) }}
                                                        <?php  $distance = (isset( $lines[$z]->distance)?  $lines[$z]->distance :false); ?> @if($distance != 0) {{ $count4 += $distance}} @else {{$distance = 0}}  @endif
                                                        {{ $count5 += (($real_cash_all * $lines[$z]->priceGo) / $distance) }}
                                                        {{ $count6 += ((($real_cash_all * $lines[$z]->priceGo) / ($arr_trip_seat_price[$z] * $lines[$z]->priceGo)) * 100) }}
                                                            @isset($arr_trip_seat_price[$z]) {{ $count7 += (($booked_seats / $arr_trip_seat_price[$z]) * 100) }} @else 0 @endisset
                                                    @endif
                                                @endfor
                                            </span>

                                        <input type="hidden" name="count1[]" value="{{number_format((float)$count1,2, '.','')}}">
                                        <input type="hidden" name="count2[]" value="{{$count2}}">
                                        <input type="hidden" name="count3[]" value="{{$count3}}">
                                        <input type="hidden" name="count4[]" value="{{$count4}}">
                                        <input type="hidden" name="count5[]" value="{{$count5}}">
                                        <input type="hidden" name="count6[]" value="{{ number_format((float)$count6,2, '.','')}}">
                                        <input type="hidden" name="count7[]" value="{{ number_format((float)$count7,2, '.','')}}">

                                        {{--  أعلى إيراد متوقع  --}}
                                        <td class="text_bold" style="width:140px;"><span class="span_top">{{ number_format((float)$count1,2, '.','') }}</span></td>
                                        {{--  عدد الركاب الفعلي  --}}
                                        <td class="text_bold" style="width:120px;"><span class="span_top">{{ $count2 }}</span></td>
                                        {{--  الإيراد الفعلي  --}}
                                        <td class="text_bold" style="width:120px;"><span class="span_top"> {{ $count3 }}</span></td>
                                        {{--   متوسط سعر التذكرة  --}}
                                        <td class="text_bold" style="width:120px;"></td>
                                        {{--   الكيلومتر  --}}
                                        <td class="text_bold" style="width:110px"><span class="span_top">{{ $count4 }}</span></td>
                                        {{--  إيراد كم --}}
                                        <td class="text_bold" style="width:110px"><span class="span_top">{{ $count5 }}</span></td>
                                        {{--  نسبة الإيراد % --}}
                                        <td class="text_bold" style="width:110px"><span class="span_top">{{ number_format((float)$count6,2, '.','') }}</span></td>
                                        {{--  نسبة الإشغال % --}}
                                        <td class="text_bold" style="width:110px"><span class="span_top">{{ number_format((float)$count7,2, '.','') }}</span></td>
                                    </tr>

                                    @for($z=0; $z<count($lines); $z++)
                                        @if($lines[$z]->from_id == $groupLine->from_id && $lines[$z]->to_id == $groupLine->to_id && $lines[$z]->degree_id == $groupLine->degree_id)
                                            <tr style="display: flex">
                                                <td style="width:120px;">{{$lines[$z]->startTime}} &nbsp;&nbsp;&nbsp; {{$lines[$z]->startDate}}</td>
                                                <td style="width:120px;">{{$lines[$z]->id}}</td>
                                                <td style="width:70px;">{{\App\Models\Bus::find($lines[$z]->bus_id)->code}}</td>
                                                <td style="width:70px;">{{\App\Models\Driver::find($lines[$z]->driver_id)->name}}</td>
                                                <td style="width:120px;">{{$lines[$z]->priceGo}}</td>

                                                @if($i<= $arr_trip_seat_price)
                                                    {{--  عدد المقاعد  --}}
                                                    <td style="width:120px;">@isset($arr_trip_seat_price[$z]) {{$arr_trip_seat_price[$z]}} @else 0 @endisset</td>
                                                    {{--  أعلى إيراد متوقع  --}}
                                                    <td style="width:140px;">@isset($arr_trip_seat_price[$z]) {{$arr_trip_seat_price[$z] * $lines[$z]->priceGo}} @else 0 @endisset</td>
                                                    {{--  عدد الركاب الفعلي  --}}
                                                    <td style="width:120px;"><?php  $booked_seats = (isset( $lines[$z]->total)?  $lines[$z]->total :false); ?> @if($booked_seats != 0) {{$booked_seats}} @else {{$booked_seats = 0}}  @endif</td>
                                                    {{--  الإيراد الفعلي --}}
                                                    <td style="width:120px;"><?php  $real_cash_all = (isset( $lines[$z]->total)?  $lines[$z]->total :false); ?> {{number_format((float)($real_cash_all * $lines[$z]->priceGo), 2, '.','' )}}</td>
                                                    {{--  متوسط سعر التذكرة --}}
                                                    <td style="width:120px;"></td>
                                                    {{--  الكيلومتر --}}
                                                    <td style="width:110px"><?php  $distance = (isset( $lines[$z]->distance)?  $lines[$z]->distance :false); ?> @if($distance != 0) {{$distance}} @else {{$distance = 0}}  @endif</td>
                                                    {{--  إيراد كم --}}
                                                    <td style="width:110px">{{  number_format((float)(($real_cash_all * $lines[$z]->priceGo) / $distance) ,2, '.','')}}</td>
                                                    {{--  نسبة الإيراد % --}}
                                                    <td style="width:110px"> {{ number_format((float)((($real_cash_all * $lines[$z]->priceGo) / ($arr_trip_seat_price[$z] * $lines[$z]->priceGo)) * 100), 2, '.','' )}}</td>
                                                    {{--  نسبة الإشغال % --}}
                                                    <td style="width:110px">@isset($arr_trip_seat_price[$z])  {{number_format((float)($booked_seats / $arr_trip_seat_price[$z]) * 100, 2, '.','')}} @else 0 @endisset</td>
                                                    <?php $i++ ?>
                                                @endif
                                            </tr>
                                        @endif
                                    @endfor

                                @endforeach

                            @endisset
                        </table>
                        @isset($dataAll)
                            <div> {{$dataAll->links('pagination::bootstrap-4')}}</div>
                        @endisset
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


            let sumCount1 = 0;
            $('input[name="count1[]"]').each(function (){
                sumCount1 += parseFloat($(this).val());
            });
            $('.count1').append(sumCount1.toFixed(2));


            let sumCount2 = 0;
            $('input[name="count2[]"]').each(function (){
                sumCount2 += parseFloat($(this).val());
            });
            $('.count2').append(sumCount2.toFixed(2));


            let sumCount3 = 0;
            $('input[name="count3[]"]').each(function (){
                sumCount3 += parseFloat($(this).val());
            });
            $('.count3').append(sumCount3.toFixed(2));


            let sumCount4 = 0;
            $('input[name="count4[]"]').each(function (){
                sumCount4 += parseFloat($(this).val());
            });
            $('.count4').append(sumCount4.toFixed(2));


            let sumCount5 = 0;
            $('input[name="count5[]"]').each(function (){
                sumCount5 += parseFloat($(this).val());
            });
            $('.count5').append(sumCount5.toFixed(2));


            let sumCount6 = 0;
            $('input[name="count6[]"]').each(function (){
                sumCount6 += parseFloat($(this).val());
            });
            $('.count6').append(sumCount6.toFixed(2));


            let sumCount7 = 0;
            $('input[name="count7[]"]').each(function (){
                sumCount7 += parseFloat($(this).val());
            });
            $('.count7').append(sumCount7.toFixed(2));


        });
    </script>
@endsection




