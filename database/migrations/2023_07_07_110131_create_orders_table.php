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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('pet_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('transaction_no');
            $table->string('reference_no');
            $table->string('contact');
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
            $table->string('remark')->nullable();
            $table->string('payment_type');
            $table->boolean('has_been_received_by_buyer')->default(false);
            $table->boolean('has_been_delivered_by_seller')->default(false);
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
        Schema::dropIfExists('orders');
    }
};