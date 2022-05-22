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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('payment_method');
            $table->string('payment_id')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('payment_amount');
            $table->string('payment_currency');
            $table->string('payment_description')->nullable();
            $table->boolean('is_refunded')->default(false);
            $table->boolean('is_added_to_wallet')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->foreignId('verified_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('payments');
    }
};
