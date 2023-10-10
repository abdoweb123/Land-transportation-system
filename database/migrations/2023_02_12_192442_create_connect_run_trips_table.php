<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectRunTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connect_run_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('runTrip_go_id');
            $table->unsignedBigInteger('runTrip_back_id');
            $table->unsignedBigInteger('admin_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('runTrip_go_id')->references('id')->on('run_trips')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('runTrip_back_id')->references('id')->on('run_trips')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }





    public function down()
    {
        Schema::dropIfExists('connect_run_trips');
    }
}
