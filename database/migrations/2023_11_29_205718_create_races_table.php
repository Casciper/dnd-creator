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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->string('size');
            $table->integer('speed');
            $table->text('description');
            $table->integer('strength')->nullable();
            $table->integer('dexterity')->nullable();
            $table->integer('constitution')->nullable();
            $table->integer('intelligence')->nullable();
            $table->integer('wisdom')->nullable();
            $table->integer('charisma')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
