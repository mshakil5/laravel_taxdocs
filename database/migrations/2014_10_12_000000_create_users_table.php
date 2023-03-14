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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('bname',255)->nullable();
            $table->string('baddress',255)->nullable();
            $table->string('bweb',255)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_type')->default(0);
            $table->string('admin_id')->nullable();
            $table->string('firm_id')->nullable();
            $table->string('accountant_name')->nullable();
            $table->string('house_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('town')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('blandnumber')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->string('bank_acc_number')->nullable();
            $table->string('bank_acc_sort_code')->nullable();
            $table->string('photo')->nullable();
            $table->string('about')->nullable();
            $table->string('reg_number')->nullable();
            $table->longText('note')->nullable();
            $table->string('postcode')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google')->nullable();
            $table->string('linkedin')->nullable();
            $table->boolean('agent_notify')->default(0);
            $table->boolean('status')->default(1);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
