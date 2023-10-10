<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->string('mass')->nullable();
            $table->string('volume')->nullable();
            $table->string('price')->nullable();
            $table->boolean('user_on_the_trip')->nullable();
            $table->unsignedBigInteger('tripSeat_id')->nullable();
            $table->boolean('breakable')->nullable();
            $table->boolean('fast')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('user_phone');
            $table->unsignedBigInteger('from_station_id');
            $table->unsignedBigInteger('to_station_id');
            $table->unsignedBigInteger('run_trip_id');
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_nationalId')->nullable();
            $table->string('other1')->nullable();
            $table->string('other2')->nullable();
            $table->boolean('receiving')->nullable();
            $table->boolean('delivering')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('from_station_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('to_station_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('run_trip_id')->references('id')->on('run_trips')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tripSeat_id')->references('id')->on('trip_seats')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
