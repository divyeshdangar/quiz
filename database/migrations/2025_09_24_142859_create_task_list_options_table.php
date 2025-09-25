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
        Schema::create('task_list_options', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('task_list_id')->constrained('task_lists')->cascadeOnDelete();
            $table->enum('type', ['option', 'text', 'textarea', 'poll'])->default('option');
            $table->string('image')->nullable();
            $table->boolean('is_right')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_list_options');
    }
};
