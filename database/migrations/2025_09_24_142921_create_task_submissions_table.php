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
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            // user_id nullable (guest submissions possible)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('response')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['task_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
