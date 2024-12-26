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
        Schema::create('reservation', function (Blueprint $table) {
              // Make id UUID to match the format
              $table->uuid('id')->primary();
            
              // If your users table uses auto-increment ID
              $table->unsignedBigInteger('user_id');
              $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
              
              // Book ID as UUID to match books table
              $table->uuid('book_id');
              $table->foreign('book_id')
                    ->references('id')
                    ->on('books')
                    ->onDelete('cascade');
              
              $table->dateTime('reserved_at')->default(now());
              $table->dateTime('due_date');
              $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])
                    ->default('pending');
              
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
