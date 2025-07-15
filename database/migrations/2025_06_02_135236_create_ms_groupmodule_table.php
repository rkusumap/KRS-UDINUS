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
        Schema::create('ms_groupmodule', function (Blueprint $table) {
            $table->char('id_gmd','36')->primary();
            $table->char('level_gmd','36');
            $table->char('module_gmd','36');
            $table->text('action_gmd')->nullable(); // Text column


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_groupmodule');
    }
};
