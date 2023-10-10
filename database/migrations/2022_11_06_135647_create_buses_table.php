<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('chassis');
            $table->string('motor_number')->default(0);
            $table->unsignedBigInteger('busModel_id');
            $table->unsignedBigInteger('busOwner_id');
            $table->unsignedBigInteger('insuranceCompany_id');
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('busType_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->date('licenceStart');
            $table->date('licenceEnd');
            $table->date('taxesStart');
            $table->date('taxesEnd');
            $table->date('driverLicenceStart');
            $table->date('driverLicenceEnd');
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('busType_id')->references('id')->on('bus_types')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('driver_id')->references('id')->on('drivers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('busModel_id')->references('id')->on('bus_models')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('busOwner_id')->references('id')->on('bus_owners')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('insuranceCompany_id')->references('id')->on('insurance_companies')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('bank_id')->references('id')->on('banks')
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
        Schema::dropIfExists('buses');
    }
}
