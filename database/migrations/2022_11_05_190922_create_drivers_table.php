<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->string('password');
            $table->string('image');
            $table->string('nationalId');
            $table->date('licence_end');
            $table->date('taxes_end');
            $table->unsignedBigInteger('licenceType_id');
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active');
            $table->unsignedBigInteger('office_id');
            $table->string('role')->nullable();
            $table->string('email_verified_at')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('bio')->nullable();
            $table->string('balance')->nullable();
            $table->string('real_balance')->nullable();
            $table->string('percentage')->nullable();
            $table->string('manager')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('licenceType_id')->references('id')->on('licences')
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
        Schema::dropIfExists('drivers');
    }
}
