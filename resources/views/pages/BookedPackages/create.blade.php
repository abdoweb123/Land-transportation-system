<!-- add_modal_city -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    حجز اشتراك
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->

                <form action="{{ route('bookedPackages.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">اختر الاشتراك:</label>
                            <select name="package_id" class="form-control" required>
                                <option value=" ">-- اختر --</option>
                                @foreach($packages as $package)
                                    <option value="{{$package->id}}">{{$package->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">التاريخ:</label>
                            <input type="date" class="form-control" name="startDate" required>
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
                                        @foreach($users as $user)
                                        <a class="dropdown-item" data-value="{{$user->id}}" href="#">{{$user->name}} : {{$user->mobile}}</a>
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
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('main_trans.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
