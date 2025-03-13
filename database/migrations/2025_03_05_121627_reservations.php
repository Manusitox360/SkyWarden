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
    Schema::Create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('flight_id')->constrained('flights');
        $table->boolean('status');
        $table->integer('price');
        $table->timestamps();
    }
    );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
Schema::dropIfExists('reservations');
    }
};
