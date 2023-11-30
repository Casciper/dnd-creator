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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('category_id');
            $table->timestamp('publication_date');
            $table->string('title');
            $table->string('slug');
            $table->string('description', 1024)->nullable();
            $table->text('text');
            $table->string('image_inner', 512)->nullable();
            $table->string('image_outer', 512)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
