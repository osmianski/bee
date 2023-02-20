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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestampsTz();

            $table->string('workflowy_id')->unique();
            $table->string('name')->index();
            $table->string('type', 20)->nullable()->index();
            $table->unsignedSmallInteger('position')->index();
            $table->text('description')->nullable();
            $table->boolean('is_obsolete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
