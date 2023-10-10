<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('booking_id');  // reservation_booking table
            $table->unsignedBigInteger('runTrip_id');
            $table->unsignedBigInteger('seat_id');  // trip_seats table
            $table->unsignedBigInteger('stationFrom_id');  // trip_stations table
            $table->unsignedBigInteger('stationTo_id');  // trip_stations table
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('office_id');  // employee_office
            $table->unsignedBigInteger('city_id');  // employee_city
            $table->unsignedBigInteger('admin_id');
            $table->double('total');  // seat price
            $table->double('sub_total')->nullable()->default(0);  // seat price after discount
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('booking_id')->references('id')->on('reservation_booking_requests')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('runTrip_id')->references('id')->on('run_trips')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('seat_id')->references('id')->on('trip_seats')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationFrom_id')->references('id')->on('trip_stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationTo_id')->references('id')->on('trip_stations')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }





    public function down()
    {
        Schema::dropIfExists('booking_seats');
    }
}
