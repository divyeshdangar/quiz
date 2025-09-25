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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['mcq', 'form', 'poll', 'review']);
            $table->string('code')->nullable()->unique();
            $table->string('title');
            $table->text('description')->nullable();
            // total time stored as seconds
            $table->unsignedBigInteger('total_time')->default(0);
            $table->foreignId('task_category_id')
                  ->nullable()
                  ->constrained('task_categories')
                  ->nullOnDelete();
            $table->boolean('is_timebase')->default(false);
            $table->boolean('is_individual')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'task_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
