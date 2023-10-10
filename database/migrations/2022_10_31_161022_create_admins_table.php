<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->integer('type');
            $table->string('email')->unique();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('employeeJob_id')->nullable();
            $table->unsignedBigInteger('employeeSituation_id')->nullable();
            $table->date('birthdate')->nullable();
            $table->date('appointDate')->nullable();
            $table->integer('degree')->nullable();
            $table->boolean('active');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('admins');
    }


    // خد بالك ان الموظف مرتبط ب office ولكن في ال mysql مباشرة نظرا لتعذر فعل ذلك باستخدام laravel migration
    // خد بالك ان الموظف مرتبط ب department ولكن في ال mysql مباشرة نظرا لتعذر فعل ذلك باستخدام laravel migration
    // خد بالك ان الموظف مرتبط ب employeeJob ولكن في ال mysql مباشرة نظرا لتعذر فعل ذلك باستخدام laravel migration
    // خد بالك ان الموظف مرتبط ب employeeSituation ولكن في ال mysql مباشرة نظرا لتعذر فعل ذلك باستخدام laravel migration


}
