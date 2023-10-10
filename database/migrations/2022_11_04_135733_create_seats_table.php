<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('busType_id');
            $table->unsignedBigInteger('admin_id');
            $table->integer('type')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('busType_id')->references('id')->on('bus_types')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
