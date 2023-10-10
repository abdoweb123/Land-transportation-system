<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('time_to_edit');
            $table->string('time_to_edit_without_fee');
            $table->double('cancelFee')->default(0);   // غرامة إالغاء الرحلة
            $table->double('editFee')->default(0);     // غرامة تعديل الرحلة
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }




    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
