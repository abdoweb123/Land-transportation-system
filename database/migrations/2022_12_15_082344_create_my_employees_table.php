<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('oracle_id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('collectionPoint_id'); // stations table
            $table->unsignedBigInteger('employeeJob_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->text('address')->nullable();
            $table->integer('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('collectionPoint_id')->references('id')->on('stations')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('employeeJob_id')->references('id')->on('employee_jobs')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }





    public function down()
    {
        Schema::dropIfExists('my_employees');
    }
}
