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
        Schema::create('task_ids', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletesTz();

            $table->foreignId('task_id')
                ->nullable()
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->string('workflowy_id')->unique();
            $table->string('section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_ids');
    }
};
