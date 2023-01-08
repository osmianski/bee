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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletesTz();

            $table->json('data')->nullable();

            $table->string('section')->nullable();
            $table->text('name')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('position')->default(0);

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
