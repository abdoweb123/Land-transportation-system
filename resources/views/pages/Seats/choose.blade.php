@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('cities_trans.title_page') }}
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



                   <div id="seats">
                       <form action="{{route('seats.test')}}" method="POST">
                           @csrf
                           @foreach ($seats as $item)
                           <div class="bus">
                               <input type="checkbox" name="seats[]" value="{{$item->id}}"
                               @if($item->type == 'unacceptable')checked @endif >{{$item->name}}
                           </div>
                           @endforeach
                           <button type="submit" class="button btn-sm x-small mb-3" id="btn_update_all">
                               تعديل المقاعد المختارة
                           </button>
                       </form>
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



