<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            // Use bigIncrements for id
            $table->bigIncrements('id'); // Changed from UUID to bigIncrements

            // Define user_id as unsignedBigInteger with foreign key constraints
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Define book_id as unsignedBigInteger with foreign key constraints
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');

            // Reserved at timestamp
            $table->dateTime('reserved_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Due date
            $table->dateTime('due_date');

            // Reservation status with default value
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])
                ->default('pending');

            // Timestamps
            $table->timestamps();

            // Soft deletes
            $table->softDeletes();

            // Indexes
            $table->index(['user_id', 'book_id']); // Combined index for better performance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
