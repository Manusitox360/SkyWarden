<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'flight_id',
        'status',
        'seat_number',
    ];

    // Relation with flight
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // Verify if the reservation is available
    public function isReservationAvailable(): bool
    {
        return $this->status === true;
    }
}
