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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->integer('userId')->default(null);
            $table->boolean('published')->default(true);
            $table->string('position', 16)->default('');
            $table->string('picture')->nullable();
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
            $table->softDeletes('deletedAt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
