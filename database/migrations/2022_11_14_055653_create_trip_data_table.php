<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('busType_id');
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active')->default(1);    // 1-نشط 2-غير نشط
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('busType_id')->references('id')->on('bus_types')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }




    public function down()
    {
        Schema::dropIfExists('trip_data');
    }
}
