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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('type');
            $table->integer('listing_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('message');
            $table->integer('customer_id');
            $table->integer('agent_id');
            $table->string('time');
            $table->string('listing_type');
            $table->string('zoom_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
