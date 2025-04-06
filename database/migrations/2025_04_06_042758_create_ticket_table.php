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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['1'])->default('1')->comment('1 = ticket');
            $table->string('title');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('title');
            $table->text('message')->nullable();
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('ticket_updates', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('user_id')->nullable()->index();
            $table->enum('type', ['1', '2'])->default('1')->comment('1 = comment, 2 = update/status');
            $table->string('title');
            $table->text('message')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
