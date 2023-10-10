<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('run_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tripData_id');
            $table->double('trip_distance');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('host_id')->nullable();
            $table->integer('type');       // تأتي من ال types المدخلة في ال TripData
            $table->date('startDate');
            $table->boolean('canceled')->default(2);// 1-ملغي 2-غير ملغي
            $table->boolean('active')->default(1);
            $table->time('startTime');
            $table->text('notes')->nullable();
            $table->double('driverTips')->nullable();
            $table->double('hostTips')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tripData_id')->references('id')->on('trip_data')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('driver_id')->references('id')->on('drivers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('host_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }




    public function down()
    {
        Schema::dropIfExists('run_trips');
    }
}
