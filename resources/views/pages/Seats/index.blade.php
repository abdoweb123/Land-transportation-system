@extends('layouts.master')
@section('css')
@section('title')
    التصميم
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('main_trans.citys') }}
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

                    {{--  button of add_modal_city  --}}
                    <a type="button" class="button x-small" href="{{route('seats.create')}}">
                        إضافة مقاعد
                    </a>
                    <br><br>


                       <div class="row">
                           <div class="bus_box row col-md-6">

                           </div>

                           <div class="bus_box row col-md-6">
                               @foreach ($seats as $item)
                                   <div style="width:{{$item->bus->width}}">
                                       <input type="checkbox" name="seats" class="text-center m-1" style="width:100px; height:90px; padding:35px; background-color:beige; border:1px solid #ddd">
                                       {{$item->name}}
                                   </div>
                               @endforeach

{{--                                   @foreach ($seats as $item)--}}
{{--                                       <input type="checkbox" name="seats" class="text-center m-1" style="width:100px; height:90px; padding:35px; background-color:beige; border:1px solid #ddd">--}}
{{--                                       {{$item->name}}--}}
{{--                                   @endforeach--}}
                           </div>
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
        });
    </script>
@endsection



