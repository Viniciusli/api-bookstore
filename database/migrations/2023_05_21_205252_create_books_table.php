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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('publisher_id');
            $table->string('title');
            $table->date('published_at')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('publisher_id')->references('id')->on('publishers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
