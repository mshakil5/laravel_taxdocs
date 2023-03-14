<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('payroll_id')->unsigned()->nullable();
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');
            $table->string('national_insurance',191)->nullable();
            $table->string('frequency',191)->nullable();
            $table->double('pay_rate',10,2)->nullable();
            $table->string('working_hour',191)->nullable();
            $table->string('holiday_hour',191)->nullable();
            $table->string('overtime_hour',191)->nullable();
            $table->string('total_paid_hour',191)->nullable();
            $table->longText('note')->nullable();
            $table->boolean('admin_notification')->default(0);
            $table->boolean('accfirm_notification')->default(0);
            $table->boolean('status')->default(0);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_details');
    }
};
