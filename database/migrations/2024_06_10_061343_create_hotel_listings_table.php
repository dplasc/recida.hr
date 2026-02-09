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
        Schema::create('hotel_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('room');
            $table->string('bed');
            $table->string('bath');
            $table->string('size');
            $table->string('amenities');
            $table->string('person');
            $table->string('price');
            $table->string('discount_price')->nullable();
            $table->string('visibility');
            $table->string('feature')->nullable();
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_listings');
    }
};
