<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(0);
            $table->integer('sort')->default(0);
            $table->string('type');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->text('text')->nullable();
            $table->text('announce')->nullable();
            NestedSet::columns($table);
            $table->text('image_outer')->nullable();
            $table->text('image_inner')->nullable();
            $table->text('uri');
            $table->string('template')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
