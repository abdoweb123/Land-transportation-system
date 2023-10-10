<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_booking_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('runTrip_id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('secret_code')->nullable();
            $table->unsignedBigInteger('go_ticket_id')->nullable();
            $table->unsignedBigInteger('stationFrom_id');
            $table->unsignedBigInteger('stationTo_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('address')->nullable();
            $table->double('total');
            $table->double('sub_total')->default(0);
            $table->double('discount')->default(0);
            $table->integer('type'); /*  1-ذهاب  2-ذهاب وعودة  3-حجز طريق  4-ذهاب وعودة مفتوحة */
            $table->integer('passenger_type');  // مصري أجنبي
            $table->double('wallet');  // if (type == go) {priceBack-priceGo} else{0}
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('office_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('runTrip_id')->references('id')->on('run_trips')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('trip_id')->references('id')->on('trip_data')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationFrom_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationTo_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('coupon_id')->references('id')->on('coupons')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



     // تم ربط جدول ال reservation_booking_requests بنفسه عن طريق ال go_ticket_id في ال mysql

    public function down()
    {
        Schema::dropIfExists('reservation_booking_requests');
    }
}
