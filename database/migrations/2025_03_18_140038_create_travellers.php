<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travellers', function (Blueprint $table) {
            $table->id();
            $table->integer('traveller_id')->length(10);
            $table->integer('user_id')->length(10);
            $table->integer('zip_id')->length(10);
            $table->integer('major_id')->length(10);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('country');
            $table->string('address');
            $table->string('gender');
            $table->string('phone');
            $table->string('emergency_phone_1');
            $table->string('emergency_phone_2');
            $table->string('nationality');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('iban');
            $table->string('bic');
            $table->tinyInteger('medical_issue');
            $table->string('medical_info');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travellers');
    }
};
