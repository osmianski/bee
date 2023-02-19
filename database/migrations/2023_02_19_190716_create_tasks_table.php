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
            $table->timestampsTz();

            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->string('workflowy_id')->unique();
            $table->string('name')->index();
            $table->string('type', 20)->index();
            $table->unsignedSmallInteger('position')->index();
            $table->text('description')->nullable();
            $table->dateTimeTz('planned_at')->nullable();
            $table->dateTimeTz('completed_at')->nullable();
            $table->text('path');
            $table->boolean('is_leaf')->default(false);
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
