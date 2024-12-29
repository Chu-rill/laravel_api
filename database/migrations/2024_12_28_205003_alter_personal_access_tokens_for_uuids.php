<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class AlterPersonalAccessTokensForUuids extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Change tokenable_id to support UUIDs
            $table->uuid('tokenable_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Revert tokenable_id to unsignedBigInteger
            $table->unsignedBigInteger('tokenable_id')->change();
        });
    }
};
