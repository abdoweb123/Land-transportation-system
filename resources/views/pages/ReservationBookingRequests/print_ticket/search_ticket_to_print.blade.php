<!-- add_modal_city -->
<div class="modal fade" id="print_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    طباعة تذكرة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('reservationBookingRequests.search_tickets_instead') }}" method="get" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="name_ar" class="mr-sm-2">رقم الهاتف :</label>
                            <input id="name_ar" type="text" name="user_phone" class="form-control" style="display:inline-block" required>
                        </div>
                        <div class="col">
                            <label for="name_en" class="mr-sm-2">تاريخ إنشاء التذكرة :</label>
                            <input type="date" name="date_of_ticket" class="form-control" style="display:inline-block" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="station_id" class="mr-sm-2">الكود السري ( إن وجد ) :</label>
                            <input type="text" name="secret_code" class="form-control" style="display:inline-block">
                        </div>
                    </div>
                    <br><br>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تأكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
