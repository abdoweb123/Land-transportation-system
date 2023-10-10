@extends('layouts.master')
@section('css')

@section('title')
    Test
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">Test</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">Test</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <form action="{{route('test.store')}}" method="post">
                    @csrf
                    <input type="number" name="name" placeholder="name">
                    <input type="text" name="slug" placeholder="slug">
                    <input type="text" name="status" placeholder="status">
                    <input type="text" name="bus_id" placeholder="bus_id">
                    <input type="text" name="type" placeholder="type">
                    <input type="submit">
                </form>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                           style="text-align: center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>processes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tests as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>@if($item->status !=1)<span style="background-color:red; color:white; padding:10px 30px">{{$item->name}}</span> @else{{$item->name}}@endif</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="btn btn-success btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ trans('main_trans.processes') }}
                                        </a>

                                    </div>
                                </td>
                            </tr>


                        @endforeach
                    </table>

{{--                    <div> {{$cities->links('pagination::bootstrap-4')}}</div>--}}

                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection
