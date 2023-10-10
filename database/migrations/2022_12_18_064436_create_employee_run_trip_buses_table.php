<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRunTripBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_run_trip_buses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employeeRunTrip_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('employeeRunTrip_id')->references('id')->on('employee_run_trips')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    public function down()
    {
        Schema::dropIfExists('employee_run_trip_buses');
    }
}
