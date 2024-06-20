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
        Schema::create('post_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postId')->nullable()->constrained('post')->onUpdate('SET NULL')->onDelete('CASCADE');
            $table->foreignId('categoryId')->nullable()->constrained('category')->onUpdate('SET NULL')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_post_category');
    }
};
