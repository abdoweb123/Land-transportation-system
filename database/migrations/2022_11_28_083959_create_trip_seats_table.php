<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tripData_id');
            $table->unsignedBigInteger('seat_id');
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('admin_id');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tripData_id')->references('id')->on('trip_data')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('seat_id')->references('id')->on('seats')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }




    public function down()
    {
        Schema::dropIfExists('trip_seats');
    }
}
