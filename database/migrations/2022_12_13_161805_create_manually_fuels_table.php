<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManuallyFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manually_fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('admin_id');
            $table->double('distance');
            $table->text('comments');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }





    public function down()
    {
        Schema::dropIfExists('manually_fuels');
    }
}
