<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In de nieuwe migration file
public function up()
{
    Schema::table('pages', function ($table) {
        $table->string('access_level')->change(); // Verander naar string type
    });
}

public function down()
{
    Schema::table('pages', function ($table) {
        $table->tinyInteger('access_level')->change(); // Voor rollback
    });
}
};
