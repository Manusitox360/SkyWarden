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
        Schema::table('flights', function (Blueprint $table) {
            // Eliminar las columnas antiguas (si existen)
            $table->dropColumn(['departure_location', 'arrival_location']);
        
            // Agregar nuevas columnas FK
            $table->foreignId('departure_location_id')->constrained('locations');
            $table->foreignId('arrival_location_id')->constrained('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
