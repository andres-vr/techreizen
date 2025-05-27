<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 255);
            $table->string('content', 10960); //tekst
            $table->boolean('login');
            $table->boolean('guideOrTraveller');
            $table->enum('type', ["HTML", "PDF"]); //content veranderen naar HTML, PDF, ...
            $table->string("routename", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages'); 

    }
};
