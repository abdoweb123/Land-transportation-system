@extends('layouts.master')
@section('css')
@section('title')
    إضافة سائق
@stop
@endsection

@section('PageText')

    إضافة سائق
@stop
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
  قائمة السائقين
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

                    <form method="post"  action="{{route('register.driver')}}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <h6 style="font-family: 'Cairo', sans-serif;color: blue">إضافة سائق</h6><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>name : <span class="text-danger">*</span></label>
                                    <input  type="text" name="name"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>title : <span class="text-danger">*</span></label>
                                    <input  type="text" name="title"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>role : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="role" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>email : <span class="text-danger">*</span></label>
                                    <input  type="text" name="email"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>mobile : <span class="text-danger">*</span></label>
                                    <input  type="text" name="mobile"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>fcm_token : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="fcm_token" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>bio : <span class="text-danger">*</span></label>
                                    <input  type="text" name="bio"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>balance : <span class="text-danger">*</span></label>
                                    <input  type="text" name="balance"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>real_balance : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="real_balance" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>percentage : <span class="text-danger">*</span></label>
                                    <input  type="text" name="percentage"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>office : <span class="text-danger">*</span></label>
                                    <input  type="text" name="office"  class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>manager : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="manager" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>image : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="image" type="text" >
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">خفظ</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    </div>



@endsection



