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
        Schema::table('users', function (Blueprint $table) {
            $table->string('vizi_user_id')->nullable()->index();
            $table->timestamp('vizi_linked_at')->nullable();
            $table->text('vizi_last_action_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['vizi_user_id', 'vizi_linked_at', 'vizi_last_action_link']);
        });
    }
};
