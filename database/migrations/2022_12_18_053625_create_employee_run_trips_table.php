<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRunTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_run_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('route_id')->references('id')->on('routes')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('driver_id')->references('id')->on('drivers')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }






    public function down()
    {
        Schema::dropIfExists('employee_run_trips');
    }
}
