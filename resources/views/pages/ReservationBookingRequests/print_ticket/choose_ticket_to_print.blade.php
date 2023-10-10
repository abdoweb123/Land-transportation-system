@extends('layouts.master')
@section('css')
@section('title')
  التذاكر المحجوزة
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
    #datatable_filter{display:none}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    التذاكر المحجوزة
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


                        <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم التذكرة</th>
                                <th>رقم الرحلة</th>
                                <th>محطة الانطلاق</th>
                                <th>محطة الوصول</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($find_tickets as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{$item->runTrip_id}}</td>
                                    <td>@isset($item->stationFrom->name)  {{ $item->stationFrom->name }} @else _____ @endisset</td>
                                    <td>@isset($item->stationTo->name)  {{ $item->stationTo->name }} @else _____ @endisset</td>
                                    <td>
                                        <form action="{{route('reservationBookingRequests.print_ticket_instead')}}" method="get" class="d-inline-block" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="ticket_id" value="{{$item->id}}">
                                        <button type="submit" class="btn btn-success">
                                            <i style="color:white; font-size:18px;" class="ti-ticket"></i>&nbsp; طباعة </button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div>
                            {{$find_tickets->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.ReservationBookingRequests.print_ticket.search_ticket_to_print')
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




