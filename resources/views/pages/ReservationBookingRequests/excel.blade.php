@extends('layouts.master')
@section('css')
@section('title')
   استيراد بيانات الموظفين
@stop


<style>
    .process{border:none; border-radius:3px; padding:3px 5px;}
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   استيراد بيانات الموظفين
@stop
<!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h6><span style="border-radius: 5px; padding:5px">استيراد بيانات الموظفين</span></h6>

    @foreach(['danger','warning','success','info'] as $msg)
        @if(Session::has('alert-'.$msg))
            <div class="alert alert-{{$msg}}">
                {{Session::get('alert-'.$msg)}}
            </div>
        @endif
    @endforeach


    <!-- row mb-3 -->
    <div class="row mb-3">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form action="{{route('import.excelEmployee')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel">
                        <button class="btn btn-success btn-sm">استيراد</button>
                    </form>
                </div>

                <div class="card-body">
                    <a class="btn btn-info" href="{{route('store.employees.data')}}">تسجيل بيانات المموظفين</a>
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
