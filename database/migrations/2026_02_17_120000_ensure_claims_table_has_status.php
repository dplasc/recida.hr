<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ensures claims table exists with status column (pending/approved/rejected).
     */
    public function up(): void
    {
        if (!Schema::hasTable('claims')) {
            Schema::create('claims', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('listing_id');
                $table->string('listing_type');
                $table->unsignedBigInteger('user_id');
                $table->text('description')->nullable();
                $table->string('file')->nullable();
                $table->string('status', 20)->default('pending');
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('claims', 'status')) {
            Schema::table('claims', function (Blueprint $table) {
                $table->string('status', 20)->default('pending')->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: preserving data. Status column is required for claim flow.
    }
};
