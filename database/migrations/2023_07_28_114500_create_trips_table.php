<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->cascadeOnDelete();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamps();
        });
        Schema::create('trip_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->nullable()->constrained('stations')->nullOnDelete();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('station_order');
            $table->boolean('current_station')->default(false);
            $table->timestamps();
        });
        Schema::create('trip_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->foreignId('from_station_id')->constrained('stations')->cascadeOnDelete();
            $table->foreignId('to_station_id')->constrained('stations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_tickets');
        Schema::dropIfExists('trip_stations');
        Schema::dropIfExists('trips');
    }
};
