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
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
       // database/migrations/xxxx_xx_xx_add_image_path_to_pages_table.php
/*
       public function up()
{
    Schema::table('pages', function (Blueprint $table) {
        $table->string('image')->nullable(); // Voeg een kolom voor afbeeldingspaden toe
    });
}

public function down()
{
    Schema::table('pages', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}*/
};
