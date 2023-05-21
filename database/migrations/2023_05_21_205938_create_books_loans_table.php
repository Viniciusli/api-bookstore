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
        Schema::create('books_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->references('id')->on('books');
            $table->foreignId('loan_id')->references('id')->on('loans');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('publisher_id')->references('id')->on('publishers');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_loans');
    }
};
