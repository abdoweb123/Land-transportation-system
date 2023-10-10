<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('stationFrom_id');
            $table->unsignedBigInteger('stationTo_id');
            $table->unsignedBigInteger('admin_id');
            $table->integer('max_trips');
            $table->integer('max_duration');
            $table->double('total');
            $table->double('sub_total')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('type');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationFrom_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('stationTo_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }




    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
