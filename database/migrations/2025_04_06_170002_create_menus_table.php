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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('icon', length: 32)->nullable();
            $table->string('title', length: 128);
            $table->string('route', length: 128)->nullable();
            $table->integer('order')->default(0);
            $table->enum('title_only', ['1', '0'])->default('0');
            $table->enum('type', ['0', '1', '2', '3'])->default('0'); // 1: other, 2: sidebar, 3: header
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('user_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->text('menuIds')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('user_menus');
    }
};
