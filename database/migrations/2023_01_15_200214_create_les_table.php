<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('les', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->integer('type'); // plus , minus
            $table->longText('action');
            $table->unsignedBigInteger('ticket_id')->nullable(); // from reservation_booking_requests table
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('office_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('ticket_id')->references('id')->on('reservation_booking_requests')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }





    public function down()
    {
        Schema::dropIfExists('les');
    }
}
