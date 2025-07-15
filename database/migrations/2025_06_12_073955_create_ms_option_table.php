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
        Schema::create('ms_option', function (Blueprint $table) {
            $table->bigIncrements('id_option');
            $table->text('primary_color_option')->nullable(); // Text column
            $table->text('primary_color_shadow_option')->nullable(); // Text column
            $table->text('primary_color_focus_button_option')->nullable(); // Text column
            $table->text('primary_color_focus_input_border_option')->nullable(); // Text column
            $table->longText('logo_app_option')->nullable(); // Text column
            $table->longText('logo_mini_app_option')->nullable(); // Text column
            $table->text('name_app_option')->nullable(); // Text column
            $table->text('acronym_name_app_option')->nullable(); // Text column
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_option');
    }
};
