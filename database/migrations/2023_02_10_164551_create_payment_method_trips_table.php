<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tripData_id');
            $table->integer('paymentMethod_id');
            $table->unsignedBigInteger('admin_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tripData_id')->references('id')->on('trip_data')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }





    public function down()
    {
        Schema::dropIfExists('payment_method_trips');
    }
}
