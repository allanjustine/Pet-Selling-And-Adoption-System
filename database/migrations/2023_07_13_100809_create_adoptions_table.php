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
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('breed_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('pet_name');
            $table->string('sex');
            $table->date('birth_date');
            $table->string('color');
            $table->string('type');
            $table->longText('reason');
            $table->foreignId('adopter_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete(); // the buyer 
            $table->string('adopter_name')->nullable();
            $table->string('adopter_contact')->nullable();
            $table->boolean('is_adopted')->default(false);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('adoptions');
    }
};