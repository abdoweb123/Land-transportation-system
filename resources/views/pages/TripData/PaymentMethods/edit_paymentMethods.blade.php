<!-- edit_modal_city -->
<div class="modal fade" id="edit_paymentMethods{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    وسائل الدفع
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('update_paymentMethods', 'test') }}" method="post">
                    @csrf
                    @method('post')
                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">

                    <div class="row">
                        <div class="col">
                            <label for="name" class="mr-sm-2 d-block">وسائل الدفع :</label>
                            <div class="contain-degrees row">
                               <div class="degree col-4 mb-2">
                                    <input type="checkbox" name="paymentMethods[]" value="1" style="margin-left:5px;" @foreach($item->tripPaymentMethods as $tripPaymentMethod) {{$tripPaymentMethod->paymentMethod_id == 1 ? 'checked' : '' }} @endforeach>  كاش
                               </div>
                                <div class="degree col-4 mb-2">
                                     <input type="checkbox" name="paymentMethods[]" value="2" style="margin-left:5px;" @foreach($item->tripPaymentMethods as $tripPaymentMethod) {{$tripPaymentMethod->paymentMethod_id == 2 ? 'checked' : '' }} @endforeach> محفظة
                                </div>
{{--                                        @foreach($paymentMethods as $paymentMethod)--}}
{{--                                    <div class="degree col-4 mb-2">--}}
{{--                                        <input type="checkbox" name="paymentMethods[]"--}}
{{--                                               value="{{$paymentMethod->id}}" @foreach($item->tripPaymentMethods as $tripPaymentMethod) {{$tripPaymentMethod->paymentMethod_id == $paymentMethod->id ? 'checked' : '' }} @endforeach style="margin-left: 5px;">--}}
{{--                                        {{ $paymentMethod->name }}--}}

{{--                                    </div>--}}
{{--                                @endforeach--}}
                            </div>
                        </div>
                    </div>


                    <br><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main_trans.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
