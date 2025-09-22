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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->index();
            $table->string('image')->nullable()->default('default.png');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('lang', ['e', 'g', 'h'])->default('e'); // e: english, h: hindi, g: gujarati
            $table->enum('status', ['1', '0'])->default('1');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreign('parent_id')->references('id')->on('blogs');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->index();
            $table->string('image')->nullable()->default('default.png');
            $table->foreignId('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['1', '0'])->default('1');
            $table->text('meta_description')->nullable();
            $table->foreign('parent_id')->references('id')->on('blog_categories');
            $table->timestamps();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('blog_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_categories');
    }
};
