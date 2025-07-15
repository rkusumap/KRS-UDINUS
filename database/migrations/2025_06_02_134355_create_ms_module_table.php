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
        Schema::create('ms_module', function (Blueprint $table) {
            $table->char('id_module','36')->primary();
            $table->char('induk_module','36')->nullable();
            $table->text('code_module')->nullable(); // Text column
            $table->text('name_module')->nullable(); // Text column
            $table->text('link_module')->nullable(); // Text column
            $table->text('description_module')->nullable(); // Text column
            $table->text('icon_module')->nullable(); // Text column
            $table->text('action_module')->nullable(); // Text column
            $table->text('order_module')->nullable(); // Text column
            $table->text('show_module')->nullable(); // Text column

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_module');
    }
};
