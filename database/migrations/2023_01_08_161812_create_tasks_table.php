<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletesTz();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->json('data')->nullable();

            $table->text('name')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('position')->nullable();
            $table->string('original_workflowy_id')->unique();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->boolean('completed')->default(false);
            $table->dateTimeTz('due_at')->nullable();
            $table->dateTimeTz('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
