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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('age')->nullable();
            $table->string('alliesAndOrganizations')->nullable();
            $table->string('attachments')->nullable();
            $table->string('chClass')->nullable();
            $table->string('characterTraits')->nullable();
            $table->string('eyes')->nullable();
            $table->string('gender')->nullable();
            $table->string('growth')->nullable();
            $table->string('hair')->nullable();
            $table->string('ideals')->nullable();
            $table->string('name')->nullable();
            $table->string('origin')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('race')->nullable();
            $table->string('skin')->nullable();
            $table->json('stats')->nullable();
            $table->text('story')->nullable();
            $table->string('weaknesses')->nullable();
            $table->string('weight')->nullable();
            $table->string('worldview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
