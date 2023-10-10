<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEfficiencyFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efficiency_fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('admin_id');
            $table->double('meters');
            $table->double('volume');
            $table->double('total_cost');
            $table->double('cost_per_meter');
            $table->text('notes')->nullable();
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('bus_id')->references('id')->on('buses')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    public function down()
    {
        Schema::dropIfExists('efficiency_fuels');
    }

}
