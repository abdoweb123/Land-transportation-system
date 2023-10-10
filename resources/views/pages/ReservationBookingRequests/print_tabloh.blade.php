<!-- add_modal_city -->
<div class="modal fade" id="print_tabloh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif; text-align:center" class="modal-title" id="exampleModalLabel">
                    تحديد السائق والمضيف والأتوبيس
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{route('reservationBookingRequests.print_tabloh')}}" method="get" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                    <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                    <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                    <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">السائق :</label>
                            <select class="form-control mr-sm-2 p-2" name="driver_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}" {{ old('driver_id') == $driver->id ? 'selected' : ''}}>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">السائق الإضافي :</label>
                            <select class="form-control mr-sm-2 p-2" name="extra_driver_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}" {{ old('extra_driver_id') == $driver->id ? 'selected' : ''}}>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">المضيف :</label>
                            <select class="form-control mr-sm-2 p-2" name="host_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($hosts as $host)
                                    <option value="{{$host->id}}" {{ old('host_id') == $host->id ? 'selected' : ''}}>{{ $host->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">السيارة :</label>
                            <select class="form-control mr-sm-2 p-2" name="bus_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($buses as $bus)
                                    <option value="{{$bus->id}}"  {{ old('bus_id') == $bus->id ? 'selected' : ''}}>{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">ملاحظات :</label>
                            <input type="text" name="notes" class="form-control" value="{{old('notes')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">ملاحظات أخرى :</label>
                            <textarea name="other_notes" class="form-control">{{old('other_notes')}}</textarea>
                        </div>
                    </div>

                    <br><br>

                    <div class="modal-footer">
                        <input type="submit" name="submit" value="حفظ" class="btn btn-success">
                        <input type="submit" name="submit" value="عرض فقط" class="btn btn-success">
                        <input type="submit" name="submit" value="طباعة" class="btn btn-success">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

















{{--

<!-- add_modal_city -->
<div class="modal fade" id="print_tabloh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif; text-align:center" class="modal-title" id="exampleModalLabel">
                    تحديد السائق والمضيف والأتوبيس
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <div class="form_div_print_tabloh">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2">السائق :</label>
                            <select class="form-control mr-sm-2 p-2" name="driver_id" required>
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">السائق الإضافي :</label>
                            <select class="form-control mr-sm-2 p-2" name="extra_driver_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">المضيف :</label>
                            <select class="form-control mr-sm-2 p-2" name="host_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($hosts as $host)
                                    <option value="{{$host->id}}">{{ $host->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">السيارة :</label>
                            <select class="form-control mr-sm-2 p-2" name="bus_id">
                                <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>
                                @foreach($buses as $bus)
                                    <option value="{{$bus->id}}">{{ $bus->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">ملاحظات :</label>
                            <input type="text" name="notes" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title" class="mr-sm-2">ملاحظات أخرى :</label>
                            <textarea name="other_notes" class="form-control"></textarea>
                        </div>
                    </div>

                    <br><br>

                    <div class="modal-footer">
                        <form action="#" method="get" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                            <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                            <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                            <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                            <button type="submit" class="btn btn-success">طباعة</button>
                        </form>
                        <form action="#" method="get" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="runTrip_id" value="{{$old_request->runTrip_id}}">
                            <input type="hidden" name="tripData_id" value="{{$old_request->tripData_id}}">
                            <input type="hidden" name="stationFrom_id" value="{{$old_request->stationFrom_id}}">
                            <input type="hidden" name="stationTo_id" value="{{$old_request->stationTo_id}}">
                            <button type="submit" class="btn btn-success">عرض فقط</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


--}}












{{--@extends('layouts.master')--}}
{{--@section('css')--}}

{{--@section('title')--}}
{{--    طباعة التابلوه--}}
{{--@stop--}}

{{--<style>--}}
{{--    select{padding:10px !important;}--}}
{{--</style>--}}

{{--@endsection--}}
{{--@section('page-header')--}}
{{--    <!-- breadcrumb -->--}}
{{--@section('PageTitle')--}}
{{--    طباعة التابلوه--}}
{{--@stop--}}
{{--<!-- breadcrumb -->--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <!-- row -->--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12 mb-30" style="max-width: 900px;  margin: auto;">--}}
{{--            <h4 class="text-center" style="color:#28a745; font-weight:bold">تحديد السائق والمضيف والأتوبيس</h4>--}}
{{--            <div class="card card-statistics h-100">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="modal-body">--}}
{{--                        <form action="{{ route('create.driver') }}" method="POST" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="name" class="mr-sm-2">السائق :</label>--}}
{{--                                    <select class="form-control mr-sm-2 p-2" name="driver_id" required>--}}
{{--                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                        @foreach($drivers as $driver)--}}
{{--                                            <option value="{{$driver->id}}">{{ $driver->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="title" class="mr-sm-2">السائق الإضافي :</label>--}}
{{--                                    <select class="form-control mr-sm-2 p-2" name="extra_driver_id">--}}
{{--                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                        @foreach($drivers as $driver)--}}
{{--                                            <option value="{{$driver->id}}">{{ $driver->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="title" class="mr-sm-2">المضيف :</label>--}}
{{--                                    <select class="form-control mr-sm-2 p-2" name="host_id">--}}
{{--                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                        @foreach($hosts as $host)--}}
{{--                                            <option value="{{$host->id}}">{{ $host->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="title" class="mr-sm-2">السيارة :</label>--}}
{{--                                    <select class="form-control mr-sm-2 p-2" name="bus_id">--}}
{{--                                        <option class="custom-select mr-sm-2 p-2" value=" ">--- اختر ---</option>--}}
{{--                                        @foreach($buses as $bus)--}}
{{--                                            <option value="{{$bus->id}}">{{ $bus->code }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="title" class="mr-sm-2">ملاحظات :</label>--}}
{{--                                    <input type="text" name="notes" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <label for="title" class="mr-sm-2">ملاحظات أخرى :</label>--}}
{{--                                    <textarea name="other_notes" class="form-control"></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <br><br>--}}

{{--                            <div class="modal-footer">--}}
{{--                                <button type="submit" class="btn btn-success">حفظ</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}





