<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('collection_point_from_id'); // stations table
            $table->unsignedBigInteger('collection_point_to_id'); // stations table
            $table->unsignedBigInteger('route_id');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('employeeRunTrip_id');
            $table->string('seat_number')->nullable();
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->string('shift');
            $table->string('address')->nullable(); // from my_employee table
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('collection_point_from_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('collection_point_to_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('route_id')->references('id')->on('routes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('employee_id')->references('id')->on('my_employees')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }




    public function down()
    {
        Schema::dropIfExists('booking_requests');
    }
}
