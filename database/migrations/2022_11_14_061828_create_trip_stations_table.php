<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tripData_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('station_id');
            $table->integer('type');         // (صعود , نزول , صعود ونزول)
            $table->integer('timeInMinutes');   // وقت الوصول من المحطة اللي قبلها للمحطة دي
            $table->double('distance')->default(0);   // المسافة من المحطة اللي قبلها للمحطة دي
            $table->integer('rank');     // دا الترتيب اللي هو هيدخله
            $table->integer('printTimes');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('tripData_id')->references('id')->on('trip_data')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('station_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }




    public function down()
    {
        Schema::dropIfExists('trip_stations');
    }
}
