@extends('layouts.master')
@section('css')
@section('title')
   تعديل بيانات الاشترك
@stop


{{-- start select with live search --}}
{{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>--}}
<link rel="stylesheet" href="{{asset('css/hierarchy-select.min.css')}}">
<link rel="stylesheet" href="{{asset('css/demo.css')}}">
{{-- end select with live search --}}

<style>
    .search-boxx{transform: translate3d(875px, 33px, 0px) !important;}
    select{padding:10px !important;}
</style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   تعديل بيانات الاشترك
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <h3 class="mb-2">تعديل بيانات اشتراك <span> : {{$bookedPackage->user->name}}</span></h3>
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


                        <form action="{{ route('bookedPackages.update', $bookedPackage->id) }}" method="post">
                            {{ method_field('patch') }}
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">اختر الاشتراك:</label>
                                    <select name="package_id" class="form-control" required>
                                        <option selected disabled>-- اختر --</option>
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}" {{$package->id == $bookedPackage->package->id ? 'selected' : ''}}>{{$package->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="name_en" class="mr-sm-2">التاريخ:</label>
                                    <input type="date" class="form-control" name="startDate" value="{{$bookedPackage->startDate}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_en" class="mr-sm-2">اسم العميل: ابحث بالاسم أو برقم الهاتف</label>
                                    {{-- start select with live search --}}
                                    <div class="dropdown hierarchy-select" id="example">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" id="example-two-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu search-boxx" aria-labelledby="example-two-button">
                                            <div class="hs-searchbox">
                                                <input type="text" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="hs-menu-inner">
                                                <a class="dropdown-item" data-value="" data-default-selected="" href="#">-- كل العملاء --</a>
{{--                                                <a class="dropdown-item" data-value="{{$bookedPackage->user->id}}" href="#">{{$bookedPackage->user->name}} : {{$bookedPackage->user->nam}}</a>--}}
                                                @foreach($users as $user)
{{--                                                    @if($user_id != $bookedPackage->user->id)--}}
                                                    <a class="dropdown-item" data-value="{{$user->id}}" href="#">{{$user->name}} : {{$user->mobile}}</a>
{{--                                                    @endif--}}
                                                @endforeach
                                            </div>
                                        </div>
                                        <input class="d-none" name="user_id" readonly="readonly" aria-hidden="true" type="text" required/>
                                    </div>
                                    {{-- end select with live search --}}
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                <button type="submit" class="btn btn-success">تعديل</button>
                            </div>
                        </form>


                </div>
            </div>
        </div>


        <!--  page of add_modal_city -->
        @include('pages.BookedPackages.create')
    </div>



@endsection
@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);


            // for live search with select

            $('#example').hierarchySelect({
                hierarchy: false,
                width: 'auto'
            });

        });
    </script>


    {{-- start select with live search --}}
{{--    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
    <script src="{{{asset('js/hierarchy-select.min.js')}}}"></script>
    {{-- end select with live search --}}

@endsection







