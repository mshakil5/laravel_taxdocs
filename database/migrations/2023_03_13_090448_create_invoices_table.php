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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('new_user_id')->unsigned()->nullable();
            $table->foreign('new_user_id')->references('id')->on('new_users')->onDelete('cascade');
            $table->bigInteger('firm_id')->unsigned()->nullable();
            $table->foreign('firm_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('image',191)->nullable();
            $table->string('user_name',191)->nullable();
            $table->string('email',191)->nullable();
            $table->longText('billing_address')->nullable();
            $table->string('terms',191)->nullable();
            $table->string('invoiceid',191)->nullable();
            $table->string('invoice_date',191)->nullable();
            $table->string('due_date',191)->nullable();
            $table->longText('message_on_invoice')->nullable();
            $table->longText('message_on_appointment')->nullable();
            $table->longText('tomail')->nullable();
            $table->longText('subjectmail')->nullable();
            $table->longText('mailbody')->nullable();
            $table->string('company_name',191)->nullable();
            $table->string('company_vatno',191)->nullable();
            $table->string('company_tell_no',191)->nullable();
            $table->string('company_email',191)->nullable();
            $table->string('acct_no',191)->nullable();
            $table->string('short_code',191)->nullable();
            $table->string('bank',191)->nullable();
            $table->double('subtotal',10,2)->nullable();
            $table->double('vat',10,2)->nullable();
            $table->double('discount',10,2)->nullable();
            $table->double('total',10,2)->nullable();
            $table->double('balance_due',10,2)->nullable();
            $table->boolean('admin_notification')->default(0);
            $table->boolean('accfirm_notification')->default(0);
            $table->boolean('paid')->default(0);
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
        Schema::dropIfExists('invoices');
    }
};
