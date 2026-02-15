<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $tables = [
            'car_listings',
            'beauty_listings',
            'real_estate_listings',
            'hotels',
            'restaurants',
            'custom_listings',
            'hotel_listings',
            'restaurant_listings',
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }
            if (Schema::hasColumn($tableName, 'Latitude')) {
                if ($driver === 'mysql') {
                    DB::statement("ALTER TABLE `{$tableName}` MODIFY `Latitude` VARCHAR(255) NULL");
                } else {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->string('Latitude')->nullable()->change();
                    });
                }
            }
            if (Schema::hasColumn($tableName, 'Longitude')) {
                if ($driver === 'mysql') {
                    DB::statement("ALTER TABLE `{$tableName}` MODIFY `Longitude` VARCHAR(255) NULL");
                } else {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->string('Longitude')->nullable()->change();
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $tables = [
            'car_listings',
            'beauty_listings',
            'real_estate_listings',
            'hotels',
            'restaurants',
            'custom_listings',
            'hotel_listings',
            'restaurant_listings',
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }
            if (Schema::hasColumn($tableName, 'Latitude')) {
                if ($driver === 'mysql') {
                    DB::statement("ALTER TABLE `{$tableName}` MODIFY `Latitude` VARCHAR(255) NOT NULL");
                } else {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->string('Latitude')->nullable(false)->change();
                    });
                }
            }
            if (Schema::hasColumn($tableName, 'Longitude')) {
                if ($driver === 'mysql') {
                    DB::statement("ALTER TABLE `{$tableName}` MODIFY `Longitude` VARCHAR(255) NOT NULL");
                } else {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->string('Longitude')->nullable(false)->change();
                    });
                }
            }
        }
    }
};
