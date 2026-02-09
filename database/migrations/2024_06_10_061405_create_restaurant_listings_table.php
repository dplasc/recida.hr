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
        Schema::create('restaurant_listings', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_id');
            $table->string('title');
            $table->string('sub_title');
            $table->string('price');
            $table->string('discount_price');
            $table->string('image');
            $table->string('amenities');
            $table->text('opening');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_listings');
    }
};
