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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('customer_id');
            $table->datetime('loaned_at');
            $table->datetime('return_at');
            $table->datetime('returned_at')->nullable();
            $table->enum('status', ['in progress', 'overdue', 'returned'])->default('in progress');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
