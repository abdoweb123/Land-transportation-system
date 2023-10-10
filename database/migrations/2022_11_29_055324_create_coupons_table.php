<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->double('amount');
            $table->boolean('percent');
            $table->date('startDate');
            $table->date('endDate');
            $table->double('max_amount')->nullable();
            $table->integer('max_users')->nullable();
            $table->integer('used_by');
            $table->integer('used_count');
            $table->integer('max_per_user');
            $table->unsignedBigInteger('customerType_id')->nullable();
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('admin_id')->references('id')->on('admins')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('customerType_id')->references('id')->on('customer_types')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }




    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
