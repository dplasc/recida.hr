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
        Schema::create('car_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->text('description');
            $table->string('brand');
            $table->string('model');
            $table->string('year');
            $table->string('car_type');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->string('engine_size');
            $table->string('cylinder');
            $table->string('interior_color');
            $table->string('exterior_color');
            $table->string('drive_train');
            $table->string('trim');
            $table->string('mileage');
            $table->string('vin');
            $table->string('price');
            $table->string('discount_price')->nullable();
            $table->string('visibility');
            $table->string('feature')->nullable();
            $table->string('specification')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('json_id')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('area');
            $table->string('address');
            $table->string('postal_code');
            $table->string('Latitude');
            $table->string('Longitude');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_listings');
    }
};
